<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all products with their images and seller info
        $products = Product::with(['product_images', 'seller'])->latest()->get();

        return view('home', compact('products'));
    }
}
