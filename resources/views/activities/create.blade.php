<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Activity - {{ $class->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-6">

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('activities.store', $class->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Activity Name</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded px-3 py-2" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Type</label>
                        <select name="type" class="w-full border-gray-300 rounded px-3 py-2" required>
                            <option value="Quiz" {{ old('type')=='Quiz'?'selected':'' }}>Quiz</option>
                            <option value="Exam" {{ old('type')=='Exam'?'selected':'' }}>Exam</option>
                            <option value="Assignment" {{ old('type')=='Assignment'?'selected':'' }}>Assignment</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Total Score</label>
                        <input type="number" name="total_score" class="w-full border-gray-300 rounded px-3 py-2" min="1" value="{{ old('total_score') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Due Date (optional)</label>
                        <input type="date" name="due_date" class="w-full border-gray-300 rounded px-3 py-2" value="{{ old('due_date') }}">
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('classes.show', $class->id) }}" class="mr-3 px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add Activity</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
