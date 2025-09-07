@extends('layouts.base')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-white">
    <!-- logo placeholder -->
    <img src="{{ asset('images/logo-placeholder.png') }}" alt="Logo" class="h-24 w-24 mb-4">
    <h1 class="text-4xl font-extrabold">CristalGrade</h1>
    <p class="mt-2 text-gray-600">Smart Grading & Performance Monitoring System</p>

    <div class="flex gap-4 mt-8">
        <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl">Login</a>
        <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-100 rounded-xl">Register</a>
    </div>
</div>
@endsection
