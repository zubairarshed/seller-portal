<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\SellerBalance;


class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Run only if status changed
        if ($order->isDirty('status')) {
            $old = $order->getOriginal('status');
            $new = $order->status;

            // ✅ Order marked as Paid → increase seller balances
            if ($old !== 'completed' && $new === 'completed') {
                foreach ($order->items as $item) {
                    $balance = SellerBalance::firstOrCreate(
                        [
                            'seller_id' => $item->seller_id
                        ],
                        [
                            'total_earned' => 0, 
                            'total_paid' => 0, 
                            'available_balance' => 0
                        ]
                    );

                    $amount = $item->price * $item->quantity;

                    $balance->increment('total_earned', $amount);
                    $balance->increment('available_balance', $amount);
                }
            }

            // ❌ Order refunded or cancelled → rollback seller balances
            if ($old === 'completed' && in_array($new, ['cancelled', 'refunded'])) {
                foreach ($order->items as $item) {
                    $balance = SellerBalance::where('seller_id', $item->seller_id)->first();
                    if ($balance) {
                        $amount = $item->price * $item->quantity;
                        $balance->decrement('total_earned', $amount);
                        $balance->decrement('available_balance', $amount);
                    }
                }
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
