@extends('layouts.app')

@section('title', 'Edit Product Application')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Product Application</h1>

    <form action="{{ route('admin.product_applications.update', $application->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">Title</label>
            <input type="text" name="title" value="{{ old('title', $application->title) }}"
                   class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-semibold">Description</label>
            <textarea name="description" class="w-full border p-2 rounded" required>{{ old('description', $application->description) }}</textarea>
        </div>

        <div>
            <label class="block font-semibold">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $application->price) }}"
                   class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-semibold">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $application->sku) }}"
                   class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-semibold">Barcode</label>
            <input type="text" name="barcode" value="{{ old('barcode', $application->barcode) }}"
                   class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-semibold">Inventory</label>
            <input type="number" name="inventory" value="{{ old('inventory', $application->inventory) }}"
                   class="w-full border p-2 rounded" required>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Update
            </button>
            <a href="{{ route('admin.product_applications.show', $application->id) }}"
               class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                Cancel
            </a>
        </div>
    </form>
@endsection
