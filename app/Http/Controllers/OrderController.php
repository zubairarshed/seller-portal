<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class OrderController extends Controller
{
    public function create()
    {
        $products = Product::with('product_images')->get();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {}
}
