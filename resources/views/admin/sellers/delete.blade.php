@extends('layouts.app')

@section('title', 'Delete Sellers')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Delete Sellers</h1>

    @if(session('message'))
        <div class="mb-4 p-2 bg-green-200 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $seller)
                <tr>
                    <td class="border px-4 py-2">{{ $seller->id }}</td>
                    <td class="border px-4 py-2">{{ $seller->name }}</td>
                    <td class="border px-4 py-2">{{ $seller->email }}</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('admin.seller_destroy', $seller->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this seller?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
