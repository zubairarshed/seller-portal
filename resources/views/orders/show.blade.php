@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow-md">
    <h1 class="text-2xl font-bold mb-6">Order #{{ $order->id }}</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Buyer Information --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Buyer Information</h2>
        <p><strong>Name:</strong> {{ $order->buyer_name }}</p>
        <p><strong>Email:</strong> {{ $order->buyer_email }}</p>
        <p><strong>Phone:</strong> {{ $order->buyer_phone }}</p>
        <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Status:</strong>
            <span class="px-2 py-1 rounded {{ $order->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
    </div>

    {{-- Order Items --}}
    <div>
        <h2 class="text-xl font-semibold mb-2">Order Items</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Product</th>
                    <th class="border px-4 py-2 text-left">Seller</th>
                    <th class="border px-4 py-2 text-center">Quantity</th>
                    <th class="border px-4 py-2 text-right">Price</th>
                    <th class="border px-4 py-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($order->items as $item)
                    @php
                        $subtotal = $item->price * $item->quantity;
                        $grandTotal += $subtotal;
                    @endphp
                    <tr>
                        <td class="border px-4 py-2">{{ $item->product->title ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $item->seller->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="border px-4 py-2 text-right">${{ number_format($item->price, 2) }}</td>
                        <td class="border px-4 py-2 text-right">${{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-100">
                    <td colspan="4" class="border px-4 py-2 text-right font-bold">Total:</td>
                    <td class="border px-4 py-2 text-right font-bold">${{ number_format($grandTotal, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
