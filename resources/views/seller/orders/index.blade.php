@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <h1 class="text-2xl font-bold mb-4">My Orders (View Only)</h1>

    @if(session('message'))
        <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <table class="w-full mt-6 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Order ID</th>
                <th class="px-4 py-2">Product Name</th>
                <th class="px-4 py-2">Quantity</th>
                <th class="px-4 py-2">Buyer Name</th>
                <th class="px-4 py-2">Buyer Phone</th>
                <th class="px-4 py-2">Shipping Address</th>
                <th class="px-4 py-2">Total Price</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderItems as $item)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $item->order_id }}</td>
                    <td class="px-4 py-2">{{ $item->product->title }}</td>
                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                    <td class="px-4 py-2">{{ $item->order->buyer_name }}</td>
                    <td class="px-4 py-2">{{ $item->order->buyer_phone }}</td>
                    <td class="px-4 py-2">{{ $item->order->shipping_address }}</td>
                    <td class="px-4 py-2">${{ number_format($item->order->total_price, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ $item->order->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
