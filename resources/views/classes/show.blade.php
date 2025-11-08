<x-app-layout>
<div class="container mx-auto p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6 bg-gradient-to-r from-blue-700 via-blue-600 to-blue-800 text-white p-6 rounded-2xl shadow-xl">
        {{-- Back Button --}}
        <a href="{{ route('dashboard') }}"
           class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-white/80 text-white hover:bg-white hover:text-blue-700 transition-all duration-200 shadow-md">
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

            {{-- Schedule (middle) --}}
            <div class="mt-2 text-blue-100 font-medium tracking-wide flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block mr-1 opacity-90"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Z" />
                </svg>
                {{ $class->schedule }}
            </div>

            {{-- Join Code (below) --}}
            <div class="mt-3 bg-white/15 backdrop-blur-md inline-block px-4 py-1.5 rounded-full shadow-sm border border-white/10">
                <span class="text-blue-100 font-semibold uppercase tracking-wide">Join Code:</span>
                <span class="font-bold text-yellow-300 ml-1">{{ $class->join_code }}</span>
            </div>
        </div>


        {{-- Add Activity Button --}}
        @if(auth()->user()->role === 'faculty')
            <a href="{{ route('activities.create', $class->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white w-16 h-16 flex items-center justify-center rounded-2xl shadow-2xl transition-transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2.5" stroke="currentColor" class="w-9 h-9">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        @endif
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded-md shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- FACULTY TABLE --}}
    @if(auth()->user()->role === 'faculty')
    <div class="bg-white shadow-xl rounded-2xl p-4 border border-gray-100">
        <form id="saveScoresForm" method="POST" action="{{ route('scores.update', $class->id) }}">
            @csrf

            {{-- Scrollable Table --}}
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
                                        <strong class="text-blue-600 font-mono">{{ $activity->code ?? '----' }}</strong>

                                        {{-- Dropdown Button --}}
                                        <div x-data="{ open: false }" class="absolute top-1 right-1 inline-block">
                                            <button 
                                                type="button"
                                                @click="open = !open"
                                                class="text-blue-500 hover:text-blue-700 transition rounded-full p-1 hover:bg-blue-100 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="20" height="20" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icon-tabler-dots-vertical">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                </svg>
                                            </button>

                                            {{-- Dropdown Menu --}}
                                            <div x-show="open" @click.outside="open = false" x-cloak
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

                                        {{-- Lock Toggle --}}
                                        <button 
                                            type="button"
                                            class="lock-btn px-3 py-1 rounded text-white flex items-center justify-center
                                                {{ $activity->is_locked ? 'bg-red-500 hover:bg-green-600' : 'bg-red-500 hover:bg-green-600' }}"
                                            data-id="{{ $activity->id }}"
                                            data-locked="{{ $activity->is_locked ? 1 : 0 }}"
                                            title="{{ $activity->is_locked ? 'Locked' : 'Unlocked' }}">
                                            @if($activity->is_locked)
                                                Locked
                                            @else
                                                Unlocked
                                            @endif
                                        </button>

                                        <small class="text-gray-600">(Max: {{ $activity->total_score }})</small>
                                    </div>
                                </th>
                                @endforeach
                            </tr>
                        </thead>

                        {{-- Students --}}
                        <tbody class="bg-white">
                            @foreach($students as $student)
                            @php $sid = $student->id; @endphp
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="border px-4 py-2 font-semibold flex justify-between items-center relative">
                                    <span>{{ $student->name ?? $student->full_name ?? 'Student' }}</span>

                                    {{-- Dropdown Button --}}
                                    <div x-data="{ open: false }" class="relative inline-block">
                                        <button
                                            type="button"
                                            @click="open = !open"
                                            class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-gray-600 hover:text-blue-600 rounded-full p-1 hover:bg-blue-100 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="20" height="20" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icon-tabler-dots-vertical">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            </svg>
                                        </button>

                                        {{-- Dropdown Menu --}}
                                        <div x-show="open" @click.outside="open = false" x-cloak
                                             class="absolute right-0 mt-2 w-28 bg-white border border-gray-200 rounded-md shadow-lg z-50 text-center">
                                            <button type="button"
                                                    onclick="removeStudent({{ $class->id }}, {{ $student->id }})"
                                                    class="block w-full px-3 py-2 text-sm text-red-600 hover:bg-red-100">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
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
            </div>

            {{-- Save Button --}}
            <div class="mt-6 text-center">
                <button type="submit"
                        class="bg-blue-600 hover:bg-green-600 text-white flex items-center justify-center mx-auto gap-2 px-6 py-3 rounded-xl shadow-md transition transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span class="font-semibold">Save Scores</span>
                </button>
            </div>
        </form>

        {{-- Hidden forms --}}
        <form id="deleteActivityForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
        <form id="removeStudentForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
    </div>
    @endif
</div>
</x-app-layout>

{{-- Scrollbar Styles --}}
{{-- Scrollbar Styles --}}
<style>
.custom-scrollbar::-webkit-scrollbar { width: 10px; height: 10px; }
.custom-scrollbar::-webkit-scrollbar-button { display: none; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #3b82f6, #2563eb); border-radius: 8px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #2563eb, #1d4ed8); }
</style>


{{-- Scripts --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".lock-btn");
    buttons.forEach(btn => {
        const id = btn.dataset.id;
        const inputs = document.querySelectorAll(`input[name^="scores["][name$="[${id}]"]`);
        updateLockState(btn, inputs, btn.dataset.locked === "1");

        btn.addEventListener("click", async () => {
            try {
                const res = await fetch(`/activities/${id}/toggle-lock`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                });
                const data = await res.json();
                updateLockState(btn, inputs, data.is_locked);
            } catch (err) {
                console.error("Error toggling lock:", err);
            }
        });
    });

    function updateLockState(btn, inputs, locked) {
        btn.dataset.locked = locked ? "1" : "0";
        if (locked) {
            btn.classList.replace("bg-green-500", "bg-red-500");
            btn.innerHTML = "Locked";
            inputs.forEach(i => { i.disabled = true; i.classList.add("bg-gray-100", "cursor-not-allowed"); });
        } else {
            btn.classList.replace("bg-red-500", "bg-green-500");
            btn.innerHTML = "Unlocked";
            inputs.forEach(i => { i.disabled = false; i.classList.remove("bg-gray-100", "cursor-not-allowed"); });
        }
    }
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
