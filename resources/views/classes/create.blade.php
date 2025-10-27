

<x-app-layout>
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create a New Class</h1>

    {{--  Back to Classes --}}
    <a href="{{ route('classes.index') }}" 
       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 inline-block mb-4">
         Back to Class List
    </a>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <strong>There were some issues with your input:</strong>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ Class creation form --}}
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('classes.store') }}">
            @csrf

            {{-- Class Name --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Course Description</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" required
                    placeholder="e.g. Keyboarding 1"
                    >
            </div>

            {{-- Subject --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Course Code</label>
                <input type="text" name="subject" value="{{ old('subject') }}" 
                    class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" require
                    placeholder="e.g. ITE 359">
            </div>

            {{-- Section --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Section</label>
                <input type="text" name="section" value="{{ old('section') }}" 
                    class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" required
                    placeholder="e.g. 1 A-1ST LABORATORY">
            </div>
            <!-- //Schedule -->
            <div>
                <label for="schedule" class="block text-sm font-medium text-gray-700">Schedule</label>
                <input type="text" name="schedule" id="schedule"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"
                    placeholder="e.g. Mon & Wed 10:00–11:30 AM">
            </div>

            <div class="mb-4">
                <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                <input type="hidden" name="year_level" value="{{ $selectedYear }}">
                <p class="mb-4 text-gray-700 font-medium">
                    Creating class for <span class="font-bold">Year {{ $selectedYear }}</span>
                </p>    
            </div>

            {{-- Submit Button --}}
            <div class="mt-6">
                <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                     Create Class
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>

