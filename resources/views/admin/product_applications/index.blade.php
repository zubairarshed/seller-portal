@extends('layouts.app')

@section('title', 'All Product Applications')

@section('content')
    <h1 class="text-2xl font-bold mb-4">All Product Applications</h1>

    @if(session('message'))
        <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <table class="w-full mt-6 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Seller Name</th>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $app->seller_id }}</td>
                    <td class="px-4 py-2">{{ $app->seller->name }}</td>
                    <td class="px-4 py-2">{{ $app->title }}</td>
                    <td class="px-4 py-2">${{ number_format($app->price, 2) }}</td>
                    <td class="px-4 py-2 capitalize">{{ $app->status }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.product_applications.show', $app) }}"
                           class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                           Review
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center">No applications found.</td>
                </tr>
            @endforelse 
        </tbody>
    </table>
@endsection
