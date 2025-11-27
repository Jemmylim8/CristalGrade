<x-app-layout>
@php
    // 🎨 Year level color mapping
    $yearColors = [
        1 => ['bg' => '#CCE4FF', 'text' => '#3345AE'],
        2 => ['bg' => '#F5FFCC', 'text' => '#867731'],
        3 => ['bg' => '#C4FFD1', 'text' => '#317B46'],
        4 => ['bg' => '#DAC8FF', 'text' => '#6C349A'],
    ];

    $yearColor = $yearColors[$selectedYear] ?? ['bg' => '#E5E7EB', 'text' => '#111827'];
@endphp

<div class="max-w-3xl mx-auto p-6">

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100/90 text-red-800 px-5 py-4 rounded-xl mb-6 border border-red-300 shadow-sm">
            <div class="flex items-start gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-.01-10a9 9 0 100 18 9 9 0 000-18z" />
                </svg>
                <div>
                    <p class="font-semibold mb-1">Please correct the following:</p>
                    <ul class="list-disc pl-5 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Create Class Form --}}
    <div class="bg-blue-600 shadow-2xl rounded-2xl p-8 border border-blue-400/60 backdrop-blur-sm">
        <form method="POST" action="{{ route('classes.store') }}" class="space-y-6">
            @csrf

            {{-- Back Button --}}
            <div class="mb-4 flex justify-start">
                <a href="{{ route('dashboard') }}" 
                    class="w-11 h-11 flex items-center justify-center rounded-full border-2 border-white text-white hover:bg-white hover:text-blue-700 transition shadow-md hover:scale-105 duration-150"
                    title="Back To Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        class="w-6 h-6" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <!-- Page Title -->
            <h1 class="text-3xl font-extrabold text-center text-white tracking-wide mb-8 drop-shadow">
                Create a New Class
            </h1>

            {{-- Course Description --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Course Description</label>
                <input type="text" name="name" 
                       value="{{ old('name') }}"
                       required
                       class="w-full rounded-lg border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 text-gray-800 placeholder-gray-400 shadow-sm"
                       placeholder="e.g. Keyboarding 1">
            </div>

            {{-- Course Code --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Course Code</label>
                <input type="text" name="subject" 
                       value="{{ old('subject') }}"
                       required
                       class="w-full rounded-lg border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 text-gray-800 placeholder-gray-400 shadow-sm"
                       placeholder="e.g. ITE 359">
            </div>

            {{-- Section --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Section</label>
                <input type="text" name="section" 
                       value="{{ old('section') }}"
                       required
                       class="w-full rounded-lg border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 text-gray-800 placeholder-gray-400 shadow-sm"
                       placeholder="e.g. 1 A-1st Laboratory">
            </div>

            {{-- Schedule --}}
            <div>
                <label for="schedule" class="block text-sm font-semibold text-yellow-200 mb-2">Schedule</label>
                <input type="text" name="schedule" id="schedule"
                       value="{{ old('schedule') }}"
                       class="w-full rounded-lg border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 text-gray-800 placeholder-gray-400 shadow-sm"
                       placeholder="e.g. Mon & Wed 10:00–11:30 AM">
            </div>

            {{-- Year Level --}}
            <div>
                <label for="year_level" class="block text-sm font-semibold text-yellow-200 mb-2">Year Level</label>
                <input type="hidden" name="year_level" value="{{ $selectedYear }}">
                <p class="text-lg font-semibold text-yellow-100">
                    Creating class for 
                    <span style="background-color: {{ $yearColor['bg'] }}; color: {{ $yearColor['text'] }};"
                        class="font-bold px-4 py-2 rounded-md shadow-md text-xl">
                        Year {{ $selectedYear }}
                    </span>
                </p>    
            </div>

            {{-- Submit --}}
            <div class="pt-6 flex justify-end gap-3 border-t border-blue-400/40 mt-8">
                <button type="submit"
                        class="px-6 py-2.5 bg-yellow-400 hover:bg-yellow-300 text-black font-bold rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-150"
                        title="Create Class">
                    Create Class
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #1d4ed8 100%);
        min-height: 100vh;
        color-scheme: light;
    }
</style>
</x-app-layout>
