<x-app-layout>
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $class->name }}  </h1>
    Join Code:  {{ $class->join_code}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Scores Form -->
    <form id="scores-form" action="{{ url('/classes/'.$class->id.'/activities/scores') }}" method="POST">
        @csrf

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Student Name</th>

                        @forelse($activities as $activity)
                            <th class="px-4 py-2 text-center">
                                {{ $activity->name }}<br>
                                <small>Max: {{ $activity->total_score }}</small>
                            </th>
                        @empty
                            <th class="px-4 py-2 text-center">No Activities Yet</th>
                        @endforelse

                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($students as $student)
                        <tr>
                            <td class="px-4 py-2">{{ $student->name }}</td>

                            @foreach($activities as $activity)
                                @php
                                    // Try to get existing score (from separate scores table or pivot if you used pivot)
                                    // Adjust this read to your system; this example tries scores table first:
                                    $existingScore = \App\Models\Score::where('activity_id', $activity->id)
                                                ->where('student_id', $student->id)
                                                ->value('score');
                                @endphp

                                <td class="px-2 py-1 text-center">
                                    <input type="number"
                                           name="scores[{{ $activity->id }}][{{ $student->id }}]"
                                           value="{{ $existingScore ?? '' }}"
                                           min="0"
                                           max="{{ $activity->total_score }}"
                                           class="w-16 text-center border rounded px-1 py-0.5">
                                </td>
                            @endforeach

                            <td class="px-4 py-2 text-center">
                                <!-- Remove button triggers a hidden form submitted outside the scores form -->
                                <button type="button"
                                        onclick="document.getElementById('remove-student-{{ $student->id }}').submit();"
                                        class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end gap-3">
            
            <a href="{{ route('activities.create', $class->id) }}"
               class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
               Add Activity
            </a>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Save Scores
            </button>
        </div>
    </form>

    <!-- Hidden remove forms: outside the main scores form to avoid nesting -->
    @foreach($students as $student)
        <form id="remove-student-{{ $student->id }}"
              action="{{ route('classes.students.remove', ['class' => $class->id, 'student' => $student->id]) }}"
              method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>
</x-app-layout>
