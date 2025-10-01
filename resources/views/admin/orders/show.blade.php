@extends('layouts.app')

@section('title', "Order #{$order->id}")

@section('content')
    <h1 class="text-2xl font-bold mb-4">Order #{{ $order->id }}</h1>

    <p><strong>Seller:</strong> @foreach($order->items->pluck('seller')->unique('id') as $seller)
                            <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded text-sm mr-1">
                                {{ $seller->name }}
                            </span>
                        @endforeach</p>
    <p><strong>Buyer:</strong> {{ $order->buyer_name }}</p>
    <p><strong>Email:</strong> {{ $order->buyer_email }}</p>
    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
    <p><strong>Status:</strong> <span class="capitalize">{{ $order->status }}</span></p>
    <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>

    <h2 class="text-lg font-semibold mt-6 mb-2">Products</h2>
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2">Quantity</th>
                <th class="px-4 py-2">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $item->product->title }}</td>
                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                    <td class="px-4 py-2">${{ number_format($item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6 flex space-x-3">
        @if(in_array($order->status, ['pending', 'completed']))
            {{-- Cancel --}}
            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Cancel Order</button>
            </form>

            {{-- Complete (only show if still pending) --}}
            @if($order->status === 'pending')
                <form action="{{ route('admin.orders.complete', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Complete Order</button>
                </form>
            @endif

            {{-- Refund --}}
            <form action="{{ route('admin.orders.refund', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Refund Order</button>
            </form>
        @endif

        <a href="{{ route('admin.orders.index') }}" 
        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to Orders</a>
    </div>

@endsection
