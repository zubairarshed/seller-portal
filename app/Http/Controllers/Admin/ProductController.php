<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        // Fetch all approved products with their images + seller
        $products = Product::with(['product_images', 'seller'])->get();
        return view('admin.products.index', compact('products'));
    }
}

