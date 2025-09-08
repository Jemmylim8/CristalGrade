<x-app-layout>
<div class="container mx-auto p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold uppercase">{{ $class->name }} – {{$class->subject}}</h1>
        <h2 class="uppercase">Join Code: {{$class->join_code}}<br>{{$class->schedule}}</h2>
        
        

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
        <form method="POST" action="{{ route('scores.update', $class->id) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="table-auto border-collapse border w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Student</th>
                            @foreach($activities as $activity)
                                <th class="border px-4 py-2">
                                    {{ $activity->name }}<br>
                                    <small class="text-gray-600">(Max: {{ $activity->total_score }})</small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                // Must match DB column scores.student_id
                                $sid = $student->id;
                            @endphp
                            <tr>
                                <td class="border px-4 py-2 font-semibold">{{ $student->name ?? $student->full_name ?? 'Student' }}</td>

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
    @else


 <!--STUDENT  -->


        {{-- Student view (read-only) --}}
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
                            <td class="border px-4 py-2">{{ $activity->name }}-{{ $activity->type}}</td>
                            <td class="border px-4 py-2 text-center">{{ $scores[$myId][$activity->id] ?? '—' }} / {{ $activity->total_score }}</td>
                            <td class="border px-4 py-2 text-center">{{ $activity->due_date}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
</x-app-layout>
