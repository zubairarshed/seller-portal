@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Products</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-white rounded shadow p-4">
            @if($product->product_images->count())
                <div class="flex space-x-2 mb-2">
                    @foreach($product->product_images as $img)
                        <img src="{{ asset('storage/' . $img->image_path) }}"
                            alt="Product image"
                            class="w-24 h-24 object-cover rounded shadow">
                    @endforeach
                </div>
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded mb-2">
                    <span>No Image</span>
                </div>
            @endif

                <h2 class="font-semibold text-lg">{{ $product->title }}</h2>
                <p class="text-gray-700 mb-1">Price: ${{ number_format($product->price, 2) }}</p>
                <p class="text-sm text-gray-500 mb-3">Seller: {{ $product->seller->name }}</p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex space-x-2">
                    @csrf
                    <button type="submit"
                            class="px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Add to Cart
                    </button>
                </form>
            </div>
        @endforeach
    </div>
@endsection
