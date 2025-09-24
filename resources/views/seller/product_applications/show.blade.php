@extends('layouts.app')

@section('title', $productApplication->title)

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $productApplication->title }}</h1>

    <p class="mb-2"><strong>Description:</strong> {{ $productApplication->description ?? 'N/A' }}</p>
    <p class="mb-2"><strong>Price:</strong> ${{ number_format($productApplication->price, 2) }}</p>
    <p class="mb-2"><strong>SKU:</strong> {{ $productApplication->sku ?? 'N/A' }}</p>
    <p class="mb-2"><strong>Barcode:</strong> {{ $productApplication->barcode ?? 'N/A' }}</p>
    <p class="mb-2"><strong>Inventory:</strong> {{ $productApplication->inventory }}</p>
    <p class="mb-4"><strong>Status:</strong> <span class="capitalize">{{ $productApplication->status }}</span></p>

    <h2 class="text-lg font-semibold mb-2">Images</h2>
    <div class="flex space-x-4">
        @forelse($productApplication->images as $image)
            <img src="{{ asset('storage/' . $image->image_path) }}" 
                 class="w-32 h-32 object-cover rounded shadow">
        @empty
            <p>No images uploaded.</p>
        @endforelse
    </div>

    <div class="mt-6">
        <a href="{{ route('seller.product_applications.index') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back</a>
    </div>
@endsection
