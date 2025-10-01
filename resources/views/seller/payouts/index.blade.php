@extends('layouts.app')

@section('title', 'My Payouts')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Payouts</h1>

    <!-- Current Balance -->
    <div class="mb-6 p-4 bg-white shadow rounded">
        <p><strong>Total Earned:</strong> ${{ number_format($balance->total_earned ?? 0, 2) }}</p>
        <p><strong>Total Paid:</strong> ${{ number_format($balance->total_paid ?? 0, 2) }}</p>
        <p><strong>Available Balance:</strong> ${{ number_format($balance->available_balance ?? 0, 2) }}</p>
    </div>

    <!-- Payout History -->
    <h2 class="text-xl font-semibold mb-2">Payout History</h2>
    <table class="w-full bg-white shadow rounded mb-6">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payouts as $payout)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $payout->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">${{ number_format($payout->amount, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ $payout->status }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-4 py-2 text-center">No payouts yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Order Items (Earnings / Refunds) -->
    <h2 class="text-xl font-semibold mb-2">Earnings & Order History</h2>
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Order ID</th>
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderItems as $item)
                <tr class="border-b">
                    <td class="px-4 py-2">#{{ $item->order_id }}</td>
                    <td class="px-4 py-2">{{ $item->product->title ?? 'N/A' }}</td>
                    <td class="px-4 py-2">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ $item->order->status }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-2 text-center">No sales yet.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
