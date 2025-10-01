@extends('layouts.app')

@section('title', 'Manage Payouts')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Payouts Management</h1>

    @if(session('message'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-4">{{ session('message') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-red-100 text-red-700 rounded mb-4">{{ session('error') }}</div>
    @endif

    <!-- Export Buttons -->
    <div class="mb-4 space-x-3">
        <a href="{{ route('admin.payouts.export.csv') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Export CSV</a>
        <a href="{{ route('admin.payouts.export.pdf') }}" class="px-3 py-2 bg-red-600 text-white rounded">Export PDF</a>
    </div>

    <!-- Sellers Balances -->
    <h2 class="text-xl font-semibold mb-2">Seller Balances</h2>
    <table class="w-full bg-white shadow rounded mb-6">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Seller</th>
                <th class="px-4 py-2">Total Earned</th>
                <th class="px-4 py-2">Total Paid</th>
                <th class="px-4 py-2">Available</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $seller)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $seller->name }}</td>
                    <td class="px-4 py-2">${{ number_format($seller->balance->total_earned ?? 0, 2) }}</td>
                    <td class="px-4 py-2">${{ number_format($seller->balance->total_paid ?? 0, 2) }}</td>
                    <td class="px-4 py-2">${{ number_format($seller->balance->available_balance ?? 0, 2) }}</td>
                    <td class="px-4 py-2">
                        <form action="{{ route('admin.payouts.pay', $seller) }}" method="POST" class="flex space-x-2">
                            @csrf
                            <input type="number" name="amount" placeholder="Amount" step="0.01" min="0.01"
                                   class="border rounded px-2 py-1 w-24" required>
                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Pay</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Payout History -->
    <h2 class="text-xl font-semibold mb-2">Payout History</h2>
    <table class="w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Seller</th>
                <th class="px-4 py-2">Amount</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payouts as $payout)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $payout->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">{{ $payout->seller->name }}</td>
                    <td class="px-4 py-2">${{ number_format($payout->amount, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ $payout->status }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-2 text-center">No payouts yet.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
