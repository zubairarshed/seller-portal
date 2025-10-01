<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SellerBalance;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user();

        $productsCount = $seller->products()->count();

        $ordersCount = $seller->orderItems()
            ->distinct('order_id')
            ->count('order_id');

        $balance = SellerBalance::where('seller_id', auth()->id())->first();

        return view('seller.dashboard', compact('productsCount', 'ordersCount', 'balance'));
    }
}