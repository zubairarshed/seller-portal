<?php 

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductApplication;
use App\Models\ProductApplicationImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductApplicationController extends Controller
{
    /**
     * Show all product applications submitted by this seller
     */
    public function index()
    {
        $applications = ProductApplication::where('seller_id', Auth::id())->latest()->get();

        return view('seller.product_applications.index', compact('applications'));
    }

    /**
     * Show form to create a new product application
     */
    public function create()
    {
        return view('seller.product_applications.create');
    }

    /**
     * Store a new product application
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'sku'         => 'nullable|string|max:100|unique:product_applications',
            'barcode'     => 'nullable|string|max:100|unique:product_applications',
            'inventory'   => 'required|integer|min:0',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $application = ProductApplication::create([
            'seller_id'   => Auth::id(),
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'sku'         => $validated['sku'] ?? null,
            'barcode'     => $validated['barcode'] ?? null,
            'inventory'   => $validated['inventory'],
            'status'      => 'pending',
        ]);

        // Save uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/applications', 'public');
                ProductApplicationImage::create([
                    'product_application_id' => $application->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('seller.product_applications.index')
                         ->with('message', 'Product application submitted and awaiting approval.');
    }

    /**
     * Show details of a single product application
     */
    public function show(ProductApplication $productApplication)
    {
        $this->authorizeApplication($productApplication);

        return view('seller.product_applications.show', compact('productApplication'));
    }

    /**
     * Show form to edit application (only if still pending)
     */
    public function edit(ProductApplication $productApplication)
    {
        $this->authorizeApplication($productApplication);

        if ($productApplication->status !== 'pending') {
            return redirect()->route('seller.product_applications.index')
                             ->with('error', 'You can only edit pending applications.');
        }

        return view('seller.product_applications.edit', compact('productApplication'));
    }

    /**
     * Update application
     */
    public function update(Request $request, ProductApplication $productApplication)
    {
        $this->authorizeApplication($productApplication);

        if ($productApplication->status !== 'pending') {
            return redirect()->route('seller.product_applications.index')
                             ->with('error', 'You can only update pending applications.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'sku'         => 'nullable|string|max:100|unique:product_applications,sku,' . $productApplication->id,
            'barcode'     => 'nullable|string|max:100|unique:product_applications,barcode,' . $productApplication->id,
            'inventory'   => 'required|integer|min:0',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $productApplication->update($validated);

        // Handle new images (optional)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/applications', 'public');
                ProductApplicationImage::create([
                    'product_application_id' => $productApplication->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('seller.product_applications.index')
                         ->with('message', 'Application updated successfully.');
    }

    /**
     * Delete product application
     */
    public function destroy(ProductApplication $productApplication)
    {
        $this->authorizeApplication($productApplication);

        $productApplication->delete();

        return redirect()->route('seller.product_applications.index')
                         ->with('message', 'Application deleted.');
    }

    /**
     * Ensure seller can only manage their own applications
     */
    private function authorizeApplication(ProductApplication $application)
    {
        if ($application->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
