@extends('layouts.app')

@section('title', 'My Product Applications')

@section('content')
    <h1 class="text-2xl font-bold mb-4">My Product Applications</h1>

    <a href="{{ route('seller.product_applications.create') }}"
       class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
        + New Application
    </a>

    @if(session('message'))
        <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <table class="w-full mt-6 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $app->title }}</td>
                    <td class="px-4 py-2">${{ number_format($app->price, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ $app->status }}</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('seller.product_applications.show', $app) }}"
                           class="text-indigo-600 hover:underline">View</a>
                        @if($app->status === 'pending')
                            <a href="{{ route('seller.product_applications.edit', $app) }}"
                               class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('seller.product_applications.destroy', $app) }}" 
                                  method="POST" onsubmit="return confirm('Delete this application?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-3 text-center">No applications found.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
