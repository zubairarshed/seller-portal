<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $seller = Auth::user();

        $productsCount = $seller->products()->count();

        $ordersCount = $seller->orderItems()
            ->distinct('order_id')
            ->count('order_id');

        $earnings = $seller->orderItems()
            ->whereHas('order', function ($q) {
                $q->where('status', 'completed');
            })
            ->sum(\DB::raw('quantity * price'));

        return view('seller.dashboard', compact('productsCount', 'ordersCount', 'earnings'));
    }
}
