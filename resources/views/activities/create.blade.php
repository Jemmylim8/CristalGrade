<x-app-layout>
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

    {{-- Add Activity Form --}}
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 shadow-2xl rounded-2xl p-8 border border-blue-400/50 backdrop-blur-sm">
        {{--  Back Button --}}
        <div class="mb-4 flex justify-start">
            <a href="{{ route('classes.show', $class->id) }}" 
                class="w-11 h-11 flex items-center justify-center rounded-full border-2 border-white text-white hover:bg-white hover:text-blue-700 transition shadow-md hover:scale-105 duration-150"
                title="Back to Class">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    class="w-6 h-6" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        {{--  Page Title --}}
        <h1 class="text-3xl font-extrabold text-center text-white tracking-wide mb-8 drop-shadow">
            Add New Activity – {{ $class->name }}
        </h1>

        <form method="POST" action="{{ route('activities.store', $class->id) }}" class="space-y-6">
            @csrf

            {{-- Activity Name --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Activity Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-lg border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 text-gray-800 placeholder-gray-400 shadow-sm"
                    placeholder="e.g. Quiz #1">
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Type</label>
                <select name="type" required
                    class="w-full rounded-lg border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 text-gray-800 shadow-sm">
                    <option value="Quiz" {{ old('type')=='Quiz' ? 'selected' : '' }}>Quiz</option>
                    <option value="Exam" {{ old('type')=='Exam' ? 'selected' : '' }}>Exam</option>
                    <option value="Assignment" {{ old('type')=='Assignment' ? 'selected' : '' }}>Assignment</option>
                </select>
            </div>

            {{-- Total Score --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Total Score</label>
                <input type="number" name="total_score" min="1" value="{{ old('total_score') }}" required
                    class="w-full rounded-lg border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 text-gray-800 placeholder-gray-400 shadow-sm"
                    placeholder="e.g. 100">
            </div>

            {{-- Due Date --}}
            <div>
                <label class="block text-sm font-semibold text-yellow-200 mb-2">Due Date (optional)</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}"
                    class="w-full rounded-lg border border-blue-300 p-3 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 bg-white/90 text-gray-800 shadow-sm">
            </div>

            {{-- Submit Buttons --}}
            <div class="pt-6 flex justify-end gap-3 border-t border-blue-400/40 mt-8">
                <button type="submit"
                    class="px-6 py-2.5 bg-yellow-400 hover:bg-yellow-300 text-black font-bold rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-150"
                    title="Add Activity">
                    Add Activity
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
