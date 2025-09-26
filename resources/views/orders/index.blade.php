@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>

    @if($orders->isEmpty())
        <p>You haven’t placed any orders yet.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Order #</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Placed At</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t">
                            <td class="px-4 py-2">#{{ $order->id }}</td>
                            <td class="px-4 py-2">${{ number_format($order->total, 2) }}</td>
                            <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                            <td class="px-4 py-2">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('orders.show', $order->id) }}"
                                   class="text-indigo-600 hover:underline">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
