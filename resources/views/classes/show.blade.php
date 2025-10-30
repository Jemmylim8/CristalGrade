<x-app-layout>
<div class="container mx-auto p-6">

    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('dashboard') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
           Back
        </a>

        <h1 class="text-2xl font-bold uppercase">{{ $class->name }} – {{ $class->subject }}</h1>
        <h2 class="uppercase">Join Code: {{ $class->join_code }}<br>{{ $class->schedule }}</h2>

        @if(auth()->user()->role === 'faculty')
            <a href="{{ route('activities.create', $class->id) }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Add Activity
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
        {{-- FACULTY VIEW --}}
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
                                        <strong class="text-blue-600 font-mono">{{ $activity->code ?? '----' }}</strong>

                                        {{-- Lock Toggle Button --}}
                                        <button 
                                            type="button"
                                            class="lock-btn px-3 py-1 rounded text-white 
                                                {{ $activity->is_locked ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}"
                                            data-id="{{ $activity->id }}"
                                            data-locked="{{ $activity->is_locked }}">
                                            {{ $activity->is_locked ? '🔒' : '🔓' }}
                                        </button>

                                        <small class="text-gray-600">(Max: {{ $activity->total_score }})</small>

                                        <div class="flex space-x-1 mt-1">
                                            <a href="{{ route('activities.edit', [$class->id, $activity->id]) }}"
                                               class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                                                Edit
                                            </a>

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
                                        onclick="removeStudent({{ $class->id }}, {{ $student->id }})">
                                        Remove
                                    </button>
                                </td>

                                @foreach($activities as $activity)
                                    @php $scoreValue = $scores[$sid][$activity->id] ?? ''; @endphp
                                    <td class="border px-4 py-2 text-center">
                                        <input type="number"
                                               name="scores[{{ $sid }}][{{ $activity->id }}]"
                                               value="{{ old('scores.' . $sid . '.' . $activity->id, $scoreValue) }}"
                                               min="0"
                                               max="{{ $activity->total_score }}"
                                               class="w-20 border rounded p-1 text-center" />
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Save Scores
                </button>
            </div>
        </form>

        {{-- Hidden Forms --}}
        <form id="deleteActivityForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
        <form id="removeStudentForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>

    @else
        {{-- STUDENT VIEW --}}
        <div class="mb-4">
            <label for="activityCode" class="font-semibold">Enter Activity Code:</label>
            <input type="password" id="activityCode" class="border rounded p-1 ml-2" placeholder="e.g. 0052" maxlength="4">
        </div>

        <form id="studentScoreForm" method="POST" action="{{ route('scores.update', $class->id) }}">
            @csrf
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
                            @php $myScore = $scores[$myId][$activity->id] ?? ''; @endphp
                            <tr data-activity-id="{{ $activity->id }}"
                                data-activity-code="{{ $activity->code }}"
                                data-locked="{{ $activity->is_locked }}">
                                <td class="border px-4 py-2">{{ $activity->name }} - {{ $activity->type }}</td>

                                <td class="border px-4 py-2 text-center">
                                    @if(!$activity->is_locked)
                                        <input type="number"
                                               name="scores[{{ $myId }}][{{ $activity->id }}]"
                                               value="{{ $myScore }}"
                                               min="0"
                                               max="{{ $activity->total_score }}"
                                               class="score-input w-20 border rounded p-1 text-center hidden" />
                                        <span class="score-display">{{ $myScore ?: '—' }}</span>
                                    @else
                                        {{ $myScore ?: '—' }}
                                    @endif
                                    / {{ $activity->total_score }}
                                </td>

                                <td class="border px-4 py-2 text-center">{{ $activity->due_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded hidden" id="saveBtn">
                    Save Scores
                </button>
            </div>
        </form>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const codeInput = document.getElementById('activityCode');
            const rows = document.querySelectorAll('tr[data-activity-id]');
            const saveBtn = document.getElementById('saveBtn');

            codeInput.addEventListener('input', () => {
                const enteredCode = codeInput.value.trim();
                let valid = false;

                rows.forEach(row => {
                    const correctCode = row.dataset.activityCode;
                    const locked = row.dataset.locked === '1';
                    const scoreInput = row.querySelector('.score-input');
                    const scoreDisplay = row.querySelector('.score-display');

                    if (!locked && enteredCode === correctCode) {
                        scoreInput.classList.remove('hidden');
                        scoreDisplay.classList.add('hidden');
                        valid = true;
                    } else if (scoreInput) {
                        scoreInput.classList.add('hidden');
                        scoreDisplay.classList.remove('hidden');
                    }
                });

                saveBtn.classList.toggle('hidden', !valid);
            });
        });
        </script>
    @endif

</div>
</x-app-layout>

{{-- JS SCRIPTS for Faculty --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".lock-btn");

    buttons.forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            try {
                const res = await fetch(`/activities/${id}/toggle-lock`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                });
                const data = await res.json();

                btn.dataset.locked = data.is_locked;
                const activityId = btn.dataset.id;
                const inputs = document.querySelectorAll(`input[name^="scores["][name$="[${activityId}]"]`);

                if (data.is_locked) {
                    btn.textContent = "🔒";
                    btn.classList.remove("bg-green-500","hover:bg-green-600");
                    btn.classList.add("bg-red-500","hover:bg-red-600");
                    inputs.forEach(i => { i.disabled = true; i.classList.add("bg-gray-200","cursor-not-allowed"); });
                } else {
                    btn.textContent = "🔓";
                    btn.classList.remove("bg-red-500","hover:bg-red-600");
                    btn.classList.add("bg-green-500","hover:bg-green-600");
                    inputs.forEach(i => { i.disabled = false; i.classList.remove("bg-gray-200","cursor-not-allowed"); });
                }
            } catch (err) { console.error("Error toggling lock:", err); }
        });
    });
});
document.querySelectorAll(".lock-btn").forEach(btn => {
    if (btn.dataset.locked == 1) {
        const id = btn.dataset.id;
        document.querySelectorAll(`input[name^="scores["][name$="[${id}]"]`)
            .forEach(i => { i.disabled = true; i.classList.add("bg-gray-200","cursor-not-allowed"); });
    }
});
function deleteActivity(cid, aid){
    if(!confirm("Delete this activity?"))return;
    const f=document.getElementById("deleteActivityForm");
    f.action=`/classes/${cid}/activities/${aid}`;f.submit();
}
function removeStudent(cid,sid){
    if(!confirm("Remove this student?"))return;
    const f=document.getElementById("removeStudentForm");
    f.action=`/classes/${cid}/students/${sid}`;f.submit();
}
</script>
