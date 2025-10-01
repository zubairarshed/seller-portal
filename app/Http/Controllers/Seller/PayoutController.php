<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SellerBalance;
use App\Models\Payout;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        // Seller balance summary
        $balance = SellerBalance::where('seller_id', $sellerId)->first();

        // Seller payout history
        $payouts = Payout::where('seller_id', $sellerId)
            ->latest()
            ->get();

        // Seller order items (to show earnings + refunds/cancels)
        $orderItems = OrderItem::with('order')
            ->where('seller_id', $sellerId)
            ->latest()
            ->get();

        return view('seller.payouts.index', compact('balance', 'payouts', 'orderItems'));
    }
}
