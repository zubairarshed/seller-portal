@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Seller Dashboard</h1>

    <p>Welcome, {{ Auth::user()->name }}!</p>
@endsection
