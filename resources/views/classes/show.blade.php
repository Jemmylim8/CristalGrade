<x-app-layout>
<div class="container mx-auto p-6 space-y-6">
<script src="https://cdn.tailwindcss.com"></script>
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6 bg-gradient-to-r from-blue-700 via-blue-600 to-blue-800 text-white p-6 rounded-2xl shadow-xl">
        {{-- Back Button --}}
        <a href="{{ route('dashboard') }}"
           class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-white/80 text-white hover:bg-white hover:text-blue-700 transition-all duration-200 shadow-md"
           title="Back To Dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"/>
            </svg>
        </a>

        {{-- Title Section --}}
        <div class="text-center flex-1 px-4">
            <h1 class="text-3xl font-extrabold uppercase tracking-wider drop-shadow-sm">
                {{ $class->name }}
                <span class="font-semibold text-blue-200">– {{ $class->subject }}</span>
            </h1>

            {{-- Schedule --}}
            <div class="mt-2 text-blue-100 font-medium tracking-wide flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block mr-1 opacity-90"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                </svg>
                {{ $class->schedule }}
            </div>

            {{-- Join Code --}}
<div class="mt-3 bg-white/15 backdrop-blur-md inline-block px-4 py-1.5 rounded-full shadow-sm border border-white/10">
    <span class="text-blue-100 font-semibold uppercase tracking-wide">Join Code:</span>
    <span class="font-bold text-yellow-300 ml-1">{{ $class->join_code }}</span>
</div>

{{-- Add spacing BELOW (mt-4) --}}
<div class="mt-4">
    @if(auth()->user()->role === 'faculty')
        <a href="{{ route('attendance.index', $class->id) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-500 hover:bg-green-700 text-white text-sm font-medium rounded-lg backdrop-blur-md shadow-md border border-white/20 transition-all duration-200 hover:scale-105 active:scale-95"
           title="Attendance">
            Attendance
        </a>
    @endif

    @if(auth()->user()->role === 'student')
        <a href="{{ route('attendance.student', $class->id) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 text-sm font-semibold rounded-lg shadow-md transition-all duration-200 hover:scale-105 active:scale-95"
           title="View Attendance">
            Attendance
        </a>
    @endif
</div>

            
        </div>

        {{-- Add Activity (Faculty Only) --}}
        @if(auth()->user()->role === 'faculty')
            <a href="{{ route('activities.create', $class->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white w-16 h-16 flex items-center justify-center rounded-2xl shadow-2xl transition-transform hover:scale-110"
               title="Add Activity">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2.5" stroke="currentColor" class="w-9 h-9">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        @endif
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded-md shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- ============================= --}}
    {{-- FACULTY VIEW (EDITABLE TABLE) --}}
    {{-- ============================= --}}
    @if(auth()->user()->role === 'faculty')
    <div class="bg-white shadow-xl rounded-2xl p-4 border border-gray-100">
        <form id="saveScoresForm" method="POST" action="{{ route('scores.update', $class->id) }}">
            @csrf

           <div class="overflow-x-auto">
    <div class="max-h-[600px] overflow-y-auto relative rounded-lg custom-scrollbar">
        <table class="table-auto border-collapse border w-full">
            <thead class="sticky top-0 bg-gray-100 shadow z-10">
                <tr>
                    <th class="border px-4 py-3 text-left font-semibold">Student</th>
                    @foreach($activities as $activity)
                    <th class="border px-4 py-2 align-top relative">
                        <div class="flex flex-col items-center space-y-1">
                            <div class="font-semibold text-gray-800">{{ $activity->name }}</div>
                            <div class=" text-gray-600">{{ $activity->type }}</div>

                            <strong class="text-blue-600 font-mono">{{ $activity->code ?? '----' }}</strong>

                            {{-- Dropdown --}}
                            <div x-data="{ open: false }" class="absolute top-1 right-1 inline-block">
                                <button 
                                    type="button"
                                    @click="open = !open"
                                    class="text-blue-500 hover:text-blue-700 transition rounded-full p-1 hover:bg-blue-100 focus:outline-none"
                                    title="Options">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="5" r="2"/>
                                        <circle cx="12" cy="12" r="2"/>
                                        <circle cx="12" cy="19" r="2"/>
                                    </svg>
                                </button>

                                <div x-show="open" @click.outside="open=false" x-cloak
                                     class="absolute right-0 mt-2 w-24 bg-white border border-gray-200 rounded-md shadow-lg z-50 text-center">
                                    <a href="{{ route('activities.edit', [$class->id, $activity->id]) }}"
                                       class="block w-full text-center px-3 py-2 text-sm text-blue-600 hover:bg-blue-100">
                                        Edit
                                    </a>
                                    <button type="button"
                                            onclick="deleteActivity({{ $class->id }}, {{ $activity->id }})"
                                            class="block w-full text-center px-3 py-2 text-sm text-red-600 hover:bg-red-100">
                                        Delete
                                    </button>
                                </div>
                            </div>

                            {{-- Lock --}}
                            <button 
                                type="button"
                                class="lock-btn px-3 py-1 rounded text-white {{ $activity->is_locked ? 'bg-red-500' : 'bg-green-500' }}"
                                data-id="{{ $activity->id }}"
                                data-locked="{{ $activity->is_locked ? 1 : 0 }}"
                                title="Toggle">
                                {{ $activity->is_locked ? 'Locked' : 'Unlocked' }}
                            </button>

                            <small class="text-gray-600">(Max: {{ $activity->total_score }})</small>
                        </div>
                    </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="bg-white">
                @foreach($students as $student)
                @php $sid = $student->id; @endphp
                <tr class="hover:bg-gray-50 transition group">
                    <td class="border px-4 py-2 font-semibold">
                        <div class="flex items-center justify-between gap-3">
                            <!-- Left side: Image + Name -->
                            <div class="flex items-center gap-3">
                                <img 
                                    src="{{ $student->profile_photo 
                                           ? asset('uploads/profile/' . $student->profile_photo)
                                        : asset('images/profile.png') }}"
                                    class="w-8 h-8 rounded-full object-cover flex-shrink-0"
                                    alt="User Avatar"
                                />
                                <span>{{ $student->name ?? $student->full_name ?? 'Student' }}</span>
                            </div>
                            
                            <!-- Right side: Dropdown -->
                            <div x-data="{ open: false }" class="relative inline-block">
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-gray-500 hover:text-blue-600 rounded-full p-1 hover:bg-gray-100 focus:outline-none"
                                    title="Options">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="5" r="2"/>
                                        <circle cx="12" cy="12" r="2"/>
                                        <circle cx="12" cy="19" r="2"/>
                                    </svg>
                                </button>

                                <div x-show="open" @click.outside="open=false" x-cloak
                                    class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-xl text-center z-50">
                                    <button type="button"
                                            onclick="removeStudent({{ $class->id }}, {{ $student->id }})"
                                            class="flex items-center justify-center gap-2 w-full px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors rounded-md">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>

                    @foreach($activities as $activity)
                    @php $scoreValue = $scores[$sid][$activity->id] ?? ''; @endphp
                    <td class="border px-4 py-2 text-center">
                        <input type="number"
                               name="scores[{{ $sid }}][{{ $activity->id }}]"
                               value="{{ $scoreValue }}"
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
</div>

            {{-- Save Button --}}
            <div class="mt-6 text-center">
                <button type="submit"
                        class="bg-blue-600 hover:bg-green-600 text-white flex items-center justify-center mx-auto gap-2 px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105"
                        title="Save">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75 11.25 15 15 9.75M21 12A9 9 0 113 12a9 9 0 0118 0Z"/>
                    </svg>
                    <span class="font-semibold">Save Scores</span>
                </button>
            </div>
            <a href="{{ route('pdf.scores', $class->id) }}"
   class="px-4 py-2 bg-red-600 hover:bg-red-800 text-white rounded-xl shadow-md transition"
   title="Export PDF">
   Export Scores PDF
</a>
        </form>

        <form id="deleteActivityForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
        <form id="removeStudentForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
    </div>
    @endif

   {{-- ============================ --}}
{{-- ============================ --}}
{{-- STUDENT VIEW (SINGLE CODE INPUT) --}}
{{-- ============================ --}}
@if(auth()->user()->role === 'student')

<div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-blue-700 mb-4">Your Grades</h2>

    {{-- Single Activity Code Input --}}
    <div class="mb-4 flex items-center space-x-2">
        <label for="activityCode" class="font-semibold">Enter Activity Code:</label>
        <input type="password" id="activityCode" class="border rounded p-1 w-32" placeholder="e.g. 0052" maxlength="4">
    </div>

    <form id="studentScoreForm" method="POST" action="{{ route('scores.update', $class->id) }}">
        @csrf
        <div class="overflow-x-auto">
            <table class="table-auto border-collapse border w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left font-semibold">Activity</th>
                        <th class="border px-4 py-2 text-center font-semibold">Score</th>
                        <th class="border px-4 py-2 text-center font-semibold">Total</th>
                        <th class="border px-4 py-2 text-center font-semibold">Date</th>
                        <th class="border px-4 py-2 text-center font-semibold">Due</th>
                    </tr>
                </thead>

                <tbody>
                    @php $myId = auth()->user()->id; @endphp
                    @foreach($activities as $activity)
                        @php $myScore = $scores[$myId][$activity->id] ?? ''; @endphp
                        <tr data-activity-id="{{ $activity->id }}"
                            data-activity-code="{{ $activity->code }}"
                            data-locked="{{ $activity->is_locked ? 1 : 0 }}">
                            <td class="border px-4 py-2 font-semibold">{{ $activity->name }}({{$activity->type}})</td>
                            <td class="border px-4 py-2 text-center">
                                <input type="number"
                                       name="scores[{{ $myId }}][{{ $activity->id }}]"
                                       value="{{ $myScore }}"
                                       min="0"
                                       max="{{ $activity->total_score }}"
                                       class="score-input w-20 border rounded p-1 text-center bg-gray-100 cursor-not-allowed"
                                       readonly
                                       style="display: none;">
                                <span class="score-display">{{ $myScore ?: '—' }}</span>
                            </td>
                            <td class="border px-4 py-2 text-center">{{ $activity->total_score }}</td>
                            <td class="border px-4 py-2 text-center">{{ $activity->created_at->toDateString(); }}</td>
                            <td class="border px-4 py-2 text-center">{{ $activity->due_date ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" id="saveBtn" class="bg-blue-600 hover:bg-green-600 text-white px-6 py-2 rounded shadow-md hidden">
                Save Scores
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const codeInput = document.getElementById("activityCode");
    const rows = document.querySelectorAll("tr[data-activity-id]");
    const saveBtn = document.getElementById("saveBtn");

    codeInput.addEventListener("input", () => {
        const enteredCode = codeInput.value.trim();
        let valid = false;

        rows.forEach(row => {
            const correctCode = row.dataset.activityCode;
            const locked = row.dataset.locked === "1";
            const input = row.querySelector(".score-input");
            const display = row.querySelector(".score-display");

            if (!locked && enteredCode === correctCode) {
                input.style.display = "inline-block";
                input.readOnly = false;
                input.classList.remove("bg-gray-100","cursor-not-allowed");
                input.classList.add("bg-white","border-blue-400");
                display.style.display = "none";
                valid = true;
            } else {
                input.style.display = "none";
                input.readOnly = true;
                input.classList.add("bg-gray-100","cursor-not-allowed");
                input.classList.remove("bg-white","border-blue-400");
                display.style.display = "inline";
            }
        });

        saveBtn.style.display = valid ? "inline-block" : "none";
    });
});
</script>
@endif



</div>
</x-app-layout>

{{-- Scrollbar --}}
<style>
.custom-scrollbar::-webkit-scrollbar { width: 10px; height: 10px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: linear-gradient(180deg,#3b82f6,#2563eb); border-radius: 8px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg,#2563eb,#1d4ed8); }
</style>

{{-- JS --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Faculty lock buttons
    const buttons = document.querySelectorAll(".lock-btn");
    buttons.forEach(btn => {
        const id = btn.dataset.id;
        const inputs = document.querySelectorAll(`input[name^="scores["][name$="[${id}]"]`);
        updateLockState(btn, inputs, btn.dataset.locked === "1");

        btn.addEventListener("click", async () => {
            const res = await fetch(`/activities/${id}/toggle-lock`, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
            });

            const data = await res.json();
            updateLockState(btn, inputs, data.is_locked);
        });
    });

    function updateLockState(btn, inputs, locked) {
        btn.dataset.locked = locked ? "1" : "0";
        btn.classList.toggle("bg-red-500", locked);
        btn.classList.toggle("bg-green-500", !locked);
        btn.textContent = locked ? "Locked" : "Unlocked";

        inputs.forEach(i => {
            i.disabled = locked;
            i.classList.toggle("bg-gray-100", locked);
            i.classList.toggle("cursor-not-allowed", locked);
        });
    }

    // Student unlock feature
    document.querySelectorAll(".unlock-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const row = btn.closest("tr");
            const input = row.querySelector(".score-input");
            const codeInput = row.querySelector(".unlock-code");
            const enteredCode = codeInput.value.trim();
            const correctCode = input.dataset.activityCode;

            if (!correctCode) {
                alert("This activity cannot be unlocked.");
                return;
            }

            if (enteredCode === correctCode) {
                input.readOnly = false;
                input.classList.remove("bg-gray-100", "cursor-not-allowed");
                input.classList.add("bg-white", "border-blue-400");
                alert("Activity unlocked! You can now edit your score.");
            } else {
                alert("Incorrect code. Try again.");
            }

            codeInput.value = "";
        });
    });
});

function deleteActivity(cid, aid) {
    if (!confirm("Delete this activity?")) return;
    const f = document.getElementById("deleteActivityForm");
    f.action = `/classes/${cid}/activities/${aid}`;
    f.submit();
}

function removeStudent(cid, sid) {
    if (!confirm("Remove this student?")) return;
    const f = document.getElementById("removeStudentForm");
    f.action = `/classes/${cid}/students/${sid}`;
    f.submit();
}
</script>
