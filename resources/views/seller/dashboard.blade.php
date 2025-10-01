@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
    @if(session('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
    
    <h1 class="text-2xl font-bold mb-6">Welcome, {{ auth()->user()->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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

        <!-- Total Earned -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">Total Earned</h2>
            <p class="text-3xl font-bold mt-2">${{ number_format($balance->total_earned ?? 0, 2) }}</p>
        </div>

        <!-- Available Balance -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">Available Balance</h2>
            <p class="text-3xl font-bold mt-2 text-green-600">
                ${{ number_format($balance->available_balance ?? 0, 2) }}
            </p>
        </div>

        <!-- Total Paid Out -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold">Total Paid Out</h2>
            <p class="text-3xl font-bold mt-2 text-blue-600">
                ${{ number_format($balance->total_paid ?? 0, 2) }}
            </p>
        </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white p-6 rounded shadow mt-8">
        <h2 class="text-lg font-semibold mb-4">Notifications</h2>

        @if(auth()->user()->unreadNotifications->isEmpty())
            <p class="text-gray-500">No new notifications.</p>
        @else
            <ul class="space-y-3">
                @foreach(auth()->user()->unreadNotifications as $notification)
                    <li class="p-3 border rounded bg-gray-50 flex justify-between items-center">
                        <div>
                            {{ $notification->data['message'] }}
                            <span class="block text-sm text-gray-400">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="text-blue-600 hover:underline text-sm">
                                Mark as Read
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
