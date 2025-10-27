<x-app-layout>
<div class="container mx-auto p-6">

    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('dashboard.faculty') }}"
           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
           Back
        </a>
        <h1 class="text-2xl font-bold uppercase">{{ $class->name }} – {{ $class->subject }}</h1>
        <h2 class="uppercase">Join Code: {{ $class->join_code }}<br>{{ $class->schedule }}</h2>

        @if(auth()->user()->role === 'faculty')
            <a href="{{ route('activities.create', $class->id) }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                + Add Activity
            </a>
        @endif
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(auth()->user()->role === 'faculty')
        {{-- MAIN FORM: Save Scores --}}
        <form id="saveScoresForm" method="POST" action="{{ route('scores.update', $class->id) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="table-auto border-collapse border w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Student</th>

                            @foreach($activities as $activity)
                                <th class="border px-4 py-2 align-top">
                                    <div class="flex flex-col items-center space-y-1">
                                        <div class="font-semibold">{{ $activity->name }}</div>
                                        <small class="text-gray-600">(Max: {{ $activity->total_score }})</small>

                                        <div class="flex space-x-1 mt-1">
                                            <a href="{{ route('activities.edit', [$class->id, $activity->id]) }}"
                                               class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                                                Edit
                                            </a>

                                            {{-- DELETE BUTTON --}}
                                            <button type="button"
                                                    onclick="deleteActivity({{ $class->id }}, {{ $activity->id }})"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($students as $student)
                            @php $sid = $student->id; @endphp
                            <tr>
                                <td class="border px-4 py-2 font-semibold">
                                    {{ $student->name ?? $student->full_name ?? 'Student' }}
                                    <button 
                                        type="button"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded ml-2"
                                        onclick="removeStudent({{ $class->id }}, {{ $student->id }})"
                                    >
                                        Remove
                                    </button>
                                </td>

                                @foreach($activities as $activity)
                                    @php
                                        $scoreValue = $scores[$sid][$activity->id] ?? '';
                                    @endphp
                                    <td class="border px-4 py-2 text-center">
                                        <input type="number"
                                               name="scores[{{ $sid }}][{{ $activity->id }}]"
                                               value="{{ old('scores.' . $sid . '.' . $activity->id, $scoreValue) }}"
                                               min="0"
                                               max="{{ $activity->total_score }}"
                                               class="w-20 border rounded p-1 text-center"/>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Save Scores
                </button>
            </div>
        </form>

        {{-- Hidden Forms --}}
        <form id="deleteActivityForm" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
        <form id="removeStudentForm" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

        {{-- JS SCRIPTS --}}
        <script>
            function deleteActivity(classId, activityId) {
                if (!confirm('Are you sure you want to delete this activity?')) return;

                const form = document.getElementById('deleteActivityForm');
                form.action = `/classes/${classId}/activities/${activityId}`;
                form.submit();
            }

            function removeStudent(classId, studentId) {
                if (!confirm('Are you sure you want to remove this student from the class?')) return;

                const form = document.getElementById('removeStudentForm');
                form.action = `/classes/${classId}/students/${studentId}`;
                form.submit();
            }
        </script>

    @else
        {{-- STUDENT READ-ONLY VIEW --}}
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Activity</th>
                        <th class="border px-4 py-2">Your Score</th>
                        <th class="border px-4 py-2">Due</th>
                    </tr>
                </thead>
                <tbody>
                    @php $myId = auth()->user()->id; @endphp
                    @foreach($activities as $activity)
                        <tr>
                            <td class="border px-4 py-2">{{ $activity->name }} - {{ $activity->type }}</td>
                            <td class="border px-4 py-2 text-center">{{ $scores[$myId][$activity->id] ?? '—' }} / {{ $activity->total_score }}</td>
                            <td class="border px-4 py-2 text-center">{{ $activity->due_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
</x-app-layout>
