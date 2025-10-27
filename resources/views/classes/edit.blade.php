<x-app-layout>
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        ✏️ Edit Activity – {{ $activity->name }}
    </h1>

    {{-- 🔙 Back to Class --}}
    <a href="{{ route('classes.show', $class->id) }}" 
       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 inline-block mb-4">
        ← Back to Class
    </a>

    {{-- 🚨 Validation Errors --}}
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

    {{-- ✏️ Edit Activity Form --}}
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('activities.update', [$class->id, $activity->id]) }}">
            @csrf
            @method('PUT')

            {{-- Activity Name --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Activity Name</label>
                <input type="text" name="name" value="{{ old('name', $activity->name) }}"
                       class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            {{-- Type --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Type</label>
                <select name="type"
                        class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                    <option value="Quiz" {{ $activity->type == 'Quiz' ? 'selected' : '' }}>Quiz</option>
                    <option value="Exam" {{ $activity->type == 'Exam' ? 'selected' : '' }}>Exam</option>
                    <option value="Assignment" {{ $activity->type == 'Assignment' ? 'selected' : '' }}>Assignment</option>
                </select>
            </div>

            {{-- Total Score --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Total Score</label>
                <input type="number" name="total_score" min="1"
                       value="{{ old('total_score', $activity->total_score) }}"
                       class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>

            {{-- Due Date --}}
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Due Date</label>
                <input type="date" name="due_date"
                       value="{{ old('due_date', $activity->due_date ? date('Y-m-d', strtotime($activity->due_date)) : '') }}"
                       class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- Submit --}}
            <div class="mt-6">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update Activity
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
