@extends('layouts.app')

@section('title', 'Review Product Application')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Review Product Application</h1>

    <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-semibold mb-4">{{ $application->title }}</h2>

        <p class="mb-2"><strong>Seller:</strong> {{ $application->seller->name }} (ID: {{ $application->seller_id }})</p>
        <p class="mb-2"><strong>Description:</strong> {{ $application->description ?? 'N/A' }}</p>
        <p class="mb-2"><strong>Price:</strong> ${{ number_format($application->price, 2) }}</p>
        <p class="mb-2"><strong>SKU:</strong> {{ $application->sku ?? 'N/A' }}</p>
        <p class="mb-2"><strong>Barcode:</strong> {{ $application->barcode ?? 'N/A' }}</p>
        <p class="mb-2"><strong>Inventory:</strong> {{ $application->inventory }}</p>
        <p class="mb-4"><strong>Status:</strong> 
            <span class="capitalize px-2 py-1 rounded 
                @if($application->status === 'pending') bg-yellow-100 text-yellow-700
                @elseif($application->status === 'approved') bg-green-100 text-green-700
                @elseif($application->status === 'rejected') bg-red-100 text-red-700
                @endif">
                {{ $application->status }}
            </span>
        </p>

        <h3 class="text-lg font-semibold mb-2">Images</h3>
        <div class="flex space-x-4 mb-6">
            @forelse($application->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}" 
                     class="w-32 h-32 object-cover rounded shadow">
            @empty
                <p>No images uploaded.</p>
            @endforelse
        </div>

        @if($application->status === 'pending')
            <div class="flex space-x-4">
                <form action="{{ route('admin.product_applications.approve', $application) }}" method="POST" 
                      onsubmit="return confirm('Approve this product?')">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Approve
                    </button>
                </form>

                <form action="{{ route('admin.product_applications.reject', $application) }}" method="POST" 
                      onsubmit="return confirm('Reject this product?')">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Reject
                    </button>
                </form>

                <a href="{{ route('admin.product_applications.edit', $application) }}" 
                   class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Edit
                </a>
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.product_applications.index') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Back to Applications
        </a>
    </div>
@endsection
