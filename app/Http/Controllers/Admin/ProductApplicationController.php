<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductApplication;
use App\Models\Product;
use App\Models\ProductImage;

class ProductApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $applications = ProductApplication::where('status', 'pending')->get();
        return view('admin.product_applications.index', compact('applications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $application = ProductApplication::with(['seller', 'images'])->findOrFail($id);
        return view('admin.product_applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $application = ProductApplication::findOrFail($id);
        return view('admin.product_applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = ProductApplication::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'sku'         => 'nullable|string|max:100',
            'barcode'     => 'nullable|string|max:100',
            'inventory'   => 'required|integer|min:0',
        ]);

        $application->update($request->only([
            'title', 'description', 'price', 'sku', 'barcode', 'inventory'
        ]));

        return redirect()->route('admin.product_applications.show', $application->id)
                         ->with('message', 'Application updated successfully.');
    }

    /**
     * Approve the specified resource.
     */
    public function approve(string $id)
    {
        $application = ProductApplication::with('images')->findOrFail($id);

        // 1. Update application status
        $application->update(['status' => 'approved']);

        // 2. Create the product
        $product = Product::create([
            'seller_id'   => $application->seller_id,
            'title'       => $application->title,
            'description' => $application->description,
            'price'       => $application->price,
            'sku'         => $application->sku,
            'barcode'     => $application->barcode,
            'inventory'   => $application->inventory
        ]);

        // 3. Duplicate images
        foreach ($application->images as $img) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $img->image_path,
                'is_main'    => $img->is_main ?? false,
            ]);
        }

        // 4. Redirect back with success message
        return redirect()
            ->route('admin.product_applications.index')
            ->with('message', 'Product application approved and product created successfully.');
    }

    /**
     * Reject the specified resource from storage.
     */
    public function reject(string $id) {
        $application = ProductApplication::findOrFail($id);
        $application->update(['status' => 'rejected']);

        return redirect()->route('admin.product_applications.index')
                         ->with('message', 'Application rejected successfully.');
    }
}