@extends('layouts.app')

@section('title', 'New Product Application')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Submit Product Application</h1>

    <form action="{{ route('seller.product_applications.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block font-semibold">Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div>
            <label class="block font-semibold">Price</label>
            <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">SKU</label>
                <input type="text" name="sku" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold">Barcode</label>
                <input type="text" name="barcode" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div>
            <label class="block font-semibold">Inventory</label>
            <input type="number" name="inventory" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block font-semibold">Images</label>
            <input type="file" name="images[]" multiple class="w-full">
        </div>

        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Submit Application
        </button>
    </form>
@endsection
