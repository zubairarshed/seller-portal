@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
    @if(session('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
    
    <h1 class="text-2xl font-bold mb-6">Welcome, {{ auth()->user()->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Products Uploaded -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">Products Uploaded</h2>
            <p class="text-3xl font-bold mt-2">{{ $productsCount }}</p>
        </div>

        <!-- Orders Received -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">Orders Received</h2>
            <p class="text-3xl font-bold mt-2">{{ $ordersCount }}</p>
        </div>

        <!-- Earnings -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">Earnings</h2>
            <p class="text-3xl font-bold mt-2">${{ number_format($earnings, 2) }}</p>
        </div>
    </div>
@endsection
