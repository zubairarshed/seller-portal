@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="flex flex-col items-center">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4 w-full max-w-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Display current order/cart summary --}}
    @if(!empty($cart))
        <div class="bg-gray-100 p-4 rounded mb-6 w-full max-w-lg">
            <h2 class="font-semibold text-lg mb-2">Your Order</h2>
            <ul class="divide-y divide-gray-300">
                @php $total = 0; @endphp
                @foreach($cart as $id => $details)
                    @php
                        $subtotal = $details['price'] * $details['quantity'];
                        $total += $subtotal;
                    @endphp
                    <li class="py-2 flex justify-between">
                        <span>{{ $details['name'] }} ({{ $details['price'] }} × {{ $details['quantity'] }})</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="mt-2 font-bold flex justify-between">
                <span>Total:</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>
        </div>
    @else
        <div class="bg-yellow-100 p-4 rounded mb-6 w-full max-w-lg text-center">
            Your cart is empty.
        </div>
    @endif

    {{-- Checkout form --}}
    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4 w-full max-w-lg">
        @csrf

        <div>
            <label class="block font-medium">Full Name</label>
            <input type="text" name="name" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium">Phone</label>
            <input type="text" name="phone" required
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium">Address</label>
            <textarea name="address" required
                      class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <button type="submit"
                class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700 w-full">
            Place Order
        </button>
    </form>
</div>
@endsection
