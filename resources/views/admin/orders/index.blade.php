@extends('layouts.app')

@section('title', 'All Orders')

@section('content')
    <h1 class="text-2xl font-bold mb-4">All Orders</h1>

    @if(session('message'))
        <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Seller Filter -->
    <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-4">
        <label for="seller" class="mr-2 font-semibold">Filter by Seller:</label>
        <select name="seller" id="seller" class="border rounded px-2 py-1">
            <option value="">All Sellers</option>
            @foreach($sellers as $seller)
                <option value="{{ $seller->id }}" {{ request('seller') == $seller->id ? 'selected' : '' }}>
                    {{ $seller->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Filter
        </button>
    </form>

    <table class="w-full mt-2 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Order ID</th>
                <th class="px-4 py-2">Seller</th>
                <th class="px-4 py-2">Buyer</th>
                <th class="px-4 py-2">Total Price</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $order->id }}</td>
                    <td class="px-4 py-2">{{ $order->seller->name }}</td>
                    <td class="px-4 py-2">{{ $order->buyer_name }}</td>
                    <td class="px-4 py-2">${{ number_format($order->total_price, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                           class="text-indigo-600 hover:underline">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
