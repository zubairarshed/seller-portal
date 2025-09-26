@extends('layouts.app')

@section('title', 'Edit Product Application')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Product Application</h1>

    <form action="{{ route('seller.product_applications.update', $productApplication) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">Title</label>
            <input type="text" name="title" value="{{ old('title', $productApplication->title) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $productApplication->description) }}</textarea>
        </div>

        <div>
            <label class="block font-semibold">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $productApplication->price) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $productApplication->sku) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold">Barcode</label>
                <input type="text" name="barcode" value="{{ old('barcode', $productApplication->barcode) }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block font-semibold">Inventory</label>
            <input type="number" name="inventory" value="{{ old('inventory', $productApplication->inventory) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Upload More Images</label>
            <input type="file" name="images[]" multiple class="w-full">
        </div>

        <h3 class="font-semibold">Existing Images</h3>
        <div class="flex space-x-4">
            @foreach($productApplication->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-24 h-24 object-cover rounded shadow">
            @endforeach
        </div>

        <div class="mt-6">
            <a href="{{ route('seller.product_applications.index') }}" 
            class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back</a>
        
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Update Application
            </button>
        </div>
    </form>
@endsection
