@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <p>Welcome, {{ Auth::user()->name }}!</p>
@endsection
