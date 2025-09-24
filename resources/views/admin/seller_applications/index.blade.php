@extends('layouts.app')

@section('title', 'Seller Applications')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Pending Seller Applications</h1>

    @if(session('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
                <tr>
                    <td class="px-4 py-2 border">{{ $app->name }}</td>
                    <td class="px-4 py-2 border">{{ $app->email }}</td>
                    <td class="px-4 py-2 border">
                        <form action="{{ route('admin.seller_applications.approve', $app->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                        </form>

                        <form action="{{ route('admin.seller_applications.reject', $app->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Reject</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 border text-center">No pending applications.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
