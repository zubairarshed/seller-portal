@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Your Cart</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 border border-green-300 rounded p-3 mb-4">
            {{ session('success') }}
        </div>
    @endif
    {{-- Error message --}}
    @if(session('error'))
        <div class="bg-red-100 text-red-700 border border-red-300 rounded p-3 mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Image</th>
                        <th class="p-3 border">Product</th>
                        <th class="p-3 border">Price</th>
                        <th class="p-3 border">Quantity</th>
                        <th class="p-3 border">Total</th>
                        <th class="p-3 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php 
                            $total = $item['price'] * $item['quantity'];
                            $grandTotal += $total;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                            <td class="p-3 border font-medium">{{ $item['name'] }}</td>
                            <td class="p-3 border">${{ number_format($item['price'], 2) }}</td>
                            <td class="p-3 border">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" 
                                           name="quantity" 
                                           value="{{ $item['quantity'] }}" 
                                           min="1"
                                           class="w-16 border rounded px-2 py-1">
                                    <button type="submit" 
                                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="p-3 border">${{ number_format($total, 2) }}</td>
                            <td class="p-3 border">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Grand total + checkout button --}}
        <div class="flex justify-between items-center mt-6">
    <h2 class="text-xl font-semibold">
        Grand Total: ${{ number_format($grandTotal, 2) }}
    </h2>
    <div class="space-x-3">
        <a href="{{ route('home') }}" 
           class="bg-gray-600 text-white px-5 py-2 rounded hover:bg-gray-700">
            Add More Items
        </a>
        <a href="{{ route('checkout.index') }}" 
           class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">
            Proceed to Checkout
        </a>
    </div>
</div>

    @else
        <p class="text-gray-600">Your cart is empty.</p>
    @endif
</div>
@endsection
