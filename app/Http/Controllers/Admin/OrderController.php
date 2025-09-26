<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.seller']); // eager load sellers

        // Apply seller filter if one is chosen
        if ($request->filled('seller')) {
            $sellerId = $request->input('seller');

            $orders->whereHas('items', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            });
        }

        $orders = $orders->latest()->get();
        $sellers = User::where('role', 'seller')->get();

        return view('admin.orders.index', compact('orders', 'sellers'));
    }

    public function show(Order $order) {
        return view('admin.orders.show', compact('order'));
    }   

    public function cancel(Order $order) {
        $order->update(['status' => 'cancelled']);
        return redirect()->route('admin.orders.index')->with('message', 'Order cancelled successfully.');
    }

    public function complete(Order $order) {
        $order->update(['status' => 'completed']);
        return redirect()->route('admin.orders.index')->with('message', 'Order completed successfully.');
    }

    public function refund(Order $order) {
        $order->update(['status' => 'refunded']);
        return redirect()->route('admin.orders.index')->with('message', 'Order refunded successfully.');
    }
}
