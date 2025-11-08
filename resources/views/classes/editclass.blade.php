<x-app-layout>
@php
    // 🎨 Year-level color mapping (same palette from your dashboard)
    $yearColors = [
        1 => ['bg' => '#CCE4FF', 'text' => '#3345AE'],
        2 => ['bg' => '#F5FFCC', 'text' => '#867731'],
        3 => ['bg' => '#C4FFD1', 'text' => '#317B46'],
        4 => ['bg' => '#DAC8FF', 'text' => '#6C349A'],
    ];

    $yearColor = $yearColors[$class->year_level] ?? ['bg' => '#E5E7EB', 'text' => '#111827'];
@endphp

<div class="max-w-3xl mx-auto p-6">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-black text-center mb-8">Edit Class</h1>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6 border border-red-200">
            <strong class="block mb-1 font-semibold">There were some issues with your input:</strong>
            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Form --}}
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 shadow-xl rounded-2xl p-8 border border-blue-500">
        <form method="POST" action="{{ route('classes.update', $class->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Class Name --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Course Description</label>
                <input type="text" name="name" value="{{ old('name', $class->name) }}" 
                    class="w-full rounded-md border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 placeholder-gray-400"
                    required>
            </div>

            {{-- Section --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Section</label>
                <input type="text" name="section" value="{{ old('section', $class->section) }}" 
                    class="w-full rounded-md border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 placeholder-gray-400">
            </div>

            {{-- Subject --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Subject</label>
                <input type="text" name="subject" value="{{ old('subject', $class->subject) }}" 
                    class="w-full rounded-md border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 placeholder-gray-400">
            </div>

            {{-- Schedule --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Schedule</label>
                <input type="text" name="schedule" value="{{ old('schedule', $class->schedule) }}" 
                    class="w-full rounded-md border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 placeholder-gray-400">
            </div>

            {{-- Year Level --}}
            <div>
                <label for="year_level" class="block text-sm font-semibold text-yellow-200 mb-2">Year Level</label>
                <input type="hidden" name="year_level" value="{{ $class->year_level }}">
                <p class="text-lg font-semibold text-yellow-100">
                    Editing class for 
                    <span style="background-color: {{ $yearColor['bg'] }}; color: {{ $yearColor['text'] }};"
                        class="font-bold px-4 py-2 rounded-md shadow-md text-xl">
                        Year {{ $class->year_level }}
                    </span>
                </p>    
            </div>

            {{-- Buttons --}}
            <div class="pt-4 flex justify-end gap-3 border-t border-blue-400/40 mt-6">
                <button type="submit" 
                    class="px-5 py-2 bg-yellow-400 hover:bg-yellow-300 text-black font-bold rounded-lg shadow transition">
                    Save Changes
                </button>
                <a href="{{ route('classes.index') }}" 
                    class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        background: linear-gradient(to bottom right, #1e3a8a, #2563eb);
        min-height: 100vh;
    }
</style>
</x-app-layout>
