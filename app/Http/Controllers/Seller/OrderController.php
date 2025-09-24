<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('seller_id', Auth::id())->latest()->get();
        return view('seller.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeOrder($order);
        return view('seller.orders.show', compact('order'));        
    }

    private function authorizeOrder()
    {
        if($order->seller_id !== Auth::id()) 
        {
            abort(403, 'Unauthorized Action.');
        }
    }
}
