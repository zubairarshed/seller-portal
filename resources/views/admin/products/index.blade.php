@extends('layouts.app')

@section('title', 'Approved Products')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Approved Products</h1>

    <table class="w-full mt-6 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Seller</th>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Inventory</th>
                <th class="px-4 py-2">Images</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $product->seller->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $product->title }}</td>
                    <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                    <td class="px-4 py-2">{{ $product->inventory }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        @forelse($product->product_images as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                 class="w-16 h-16 object-cover rounded shadow">
                        @empty
                            <span class="text-gray-500">No images</span>
                        @endforelse
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-600">
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
