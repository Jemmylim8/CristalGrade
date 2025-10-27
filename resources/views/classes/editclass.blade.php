<x-app-layout>
<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Edit Class</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('classes.update', $class->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Class Name</label>
            <input type="text" name="name" value="{{ old('name', $class->name) }}" 
                   class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Section</label>
            <input type="text" name="section" value="{{ old('section', $class->section) }}" 
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Subject</label>
            <input type="text" name="subject" value="{{ old('subject', $class->subject) }}" 
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Schedule</label>
            <input type="text" name="schedule" value="{{ old('schedule', $class->schedule) }}" 
                   class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label for="year_level" class="block text-gray-700 font-medium">Year Level</label>
            <input type="hidden" name="year_level" value="{{ $class->year_level }}">
            <p class="mt-1 text-gray-700">
                Editing class for <span class="font-semibold">Year {{ $class->year_level }}</span>
            </p>
        </div>


        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Save Changes
        </button>
        <a href="{{ route('classes.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Cancel
        </a>
    </form>
</div>
</x-app-layout>
