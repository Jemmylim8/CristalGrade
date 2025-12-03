<x-app-layout>
<div class="max-w-5xl mx-auto p-6 space-y-6">

    <!-- Back Button -->
    <a href="{{ route('attendance.index', $class->id) }}"
        class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-blue-600 text-blue-600 
               hover:bg-blue-600 hover:text-white transition-all duration-200 shadow-md"
               title="Back To Create Attendance">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"/>
        </svg>
    </a>

    <!-- Title -->
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
        {{ $class->name }}
        <span class="text-blue-700 text-3xl font-bold">
            — Attendance for {{ $attendance->date }}
        </span>
    </h1>
    <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST"
      onsubmit="return confirm('Delete this attendance?');">
    @csrf
    @method('DELETE')
    <button class="text-red-600 hover:underline">Delete</button>
</form>

    <!-- Success Message -->
    @if(session('success'))
        <div class="p-4 bg-green-100 text-green-800 rounded-xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
        @csrf
        @method('PUT')

        <!-- Table Wrapper -->
        <div class="overflow-x-auto rounded-2xl border border-gray-300 shadow-sm bg-white/70">
            <table class="w-full text-left">
                <thead class="bg-gray-200/90 text-gray-800 rounded-t-2xl">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wide text-center">Student</th>
                        <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wide text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wide text-center">Remarks</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($records as $r)
                    <tr class="border-b border-gray-200 hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 font-bold text-center text-gray-900 text-sm">
                            {{ $r->student->name ?? $r->student->full_name }}
                        </td>

                        <td class="px-6 py-4">

                            <!-- Colored Select Using Alpine.js -->
                            <div 
                                x-data="{ 
                                    v: '{{ $r->status }}', 
                                    color() {
                                        return {
                                            present: 'bg-green-100 text-green-700 border-green-300',
                                            absent: 'bg-red-100 text-red-700 border-red-300',
                                            late: 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                            excused: 'bg-blue-100 text-blue-700 border-blue-300'
                                        }[this.v];
                                    }
                                }"
                            >

                                <select 
                                    name="records[{{ $r->student_id }}][status]"
                                    x-model="v"
                                    :class="color()"
                                    class="px-3 py-2 w-full rounded-lg border bg-gray-100 text-gray-800 transition font-medium"
                                >
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="late">Late</option>
                                    <option value="excused">Excused</option>
                                </select>

                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <input 
                                type="text"
                                name="records[{{ $r->student_id }}][remarks]"
                                value="{{ $r->remarks }}"
                                placeholder="Add remark..."
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700 
                                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            />
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Save Button -->
        <div class="pt-4">
            <button 
                class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold 
                       rounded-xl shadow-lg transition-all hover:scale-[1.02] active:scale-95">
                Update Attendance
            </button>
        </div>

    </form>
</div>
</x-app-layout>
