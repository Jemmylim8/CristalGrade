<x-app-layout>
<div class="container mx-auto p-8 space-y-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between bg-white/20 backdrop-blur-md p-5 rounded-2xl shadow-lg border border-white/10">
        
        <!-- Back Button -->
        <a href="{{ route('classes.show', $class->id) }}"
           class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-white/80 text-white hover:text-blue-700 hover:bg-white bg-blue-700 transition-all duration-200 shadow-md"
           title="Back to Class">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"/>
            </svg>
        </a>

        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-900">
            {{ $class->name }} <span class="text-blue-700">— Attendance</span>
        </h1>

        <!-- Controls -->
        <div class="flex items-center gap-3">
            <input type="date" id="attendanceDate"
                   value="{{ now()->toDateString() }}"
                   class="px-3 py-2 rounded-xl border border-gray-300 bg-gray-100 text-gray-700 focus:ring-blue-500 focus:border-blue-500" />

            <button id="takeBtn"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-md transition"
                title="Take Attendance">
                Take Attendance
            </button>

            <a href="{{ route('pdf.attendance', $class->id) }}"
               class="px-4 py-2 bg-red-600 hover:bg-red-800 text-white rounded-xl shadow-md transition"
               title="Export PDF">
                Export PDF
            </a>
        </div>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- TAKE ATTENDANCE AREA -->
    <div id="takeArea" class="hidden mt-6">

    <form method="POST" action="{{ route('attendance.store', $class->id) }}"
          class="bg-white/40 backdrop-blur-lg rounded-2xl p-8 shadow-xl border border-gray-300/40 space-y-6">

        @csrf
        <input type="hidden" name="date" id="formDate">

        <!-- Table Wrapper -->
        <div class="overflow-x-auto rounded-2xl border border-gray-300 shadow-sm bg-white/70">
            <table class="w-full text-left">
                <thead class="bg-gray-200/90 text-gray-800 rounded-t-2xl">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wide text-center">Students</th>
                        <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wide text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-sm uppercase tracking-wide text-center">Remarks</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($students as $student)
                    <tr class="border-b border-gray-200 hover:bg-gray-50/70 transition">
                        <td class="px-6 py-4 font-bold text-center text-gray-900 text-sm">
                            {{ $student->name ?? $student->full_name }}
                        </td>

                        <td class="px-6 py-4">
                              <div x-data="{ 
                                      v: 'absent',
                                      color() {
                                          return {
                                              present: 'bg-green-100 text-green-700 border-green-300',
                                              absent: 'bg-red-100 text-red-700 border-red-300',
                                              late: 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                              excused: 'bg-blue-100 text-blue-700 border-blue-300'
                                          }[this.v];
                                      }
                                  }"
                                  x-init="v = 'absent'"
                              >

                                  <select 
                                      name="records[{{ $student->id }}][status]"
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
                            <input type="text"
                                   name="records[{{ $student->id }}][remarks]"
                                   placeholder="Add remark..."
                                   class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-700 
                                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"/>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Save Button -->
        <div class="pt-4">
            <button type="submit"
                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold 
                           rounded-xl shadow-lg transition-all hover:scale-[1.02] active:scale-95">
                Save Attendance
            </button>
        </div>

    </form>
</div>


    <!-- PREVIOUS SESSIONS -->
    <div class="mt-6 bg-white/40 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-gray-200">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Previous Sessions</h2>

    <div class="space-y-3">
        @foreach($sessions as $s)
            <a href="{{ route('attendance.show', [$class->id, $s->id]) }}"
               class="flex items-center justify-between w-full px-5 py-3 
                      bg-white/70 hover:bg-blue-100 text-gray-800 
                      rounded-xl shadow-sm border border-gray-300
                      transition-all duration-200 hover:scale-[1.01] active:scale-95">

                <span class="font-semibold">
                    {{ $s->date }}
                </span>

                <span class="text-sm text-gray-600">
                    recorded by <span class="font-medium">{{ $s->creator?->name ?? '—' }}</span>
                </span>

            </a>
        @endforeach
    </div>
</div>


</div>

<!-- SCRIPT -->
<script>
document.getElementById('takeBtn').addEventListener('click', () => {
    document.getElementById('takeArea').classList.remove('hidden');
    document.getElementById('formDate').value = document.getElementById('attendanceDate').value;
});
</script>

</x-app-layout>
