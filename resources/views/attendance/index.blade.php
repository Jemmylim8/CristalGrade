<x-app-layout>
<div class="container mx-auto p-6">
  <div class="flex items-center justify-between mb-4">
    <a href="{{ route('classes.show', $class->id) }}"
           class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-white/80 text-blue-700 hover:bg-white hover:text-black transition-all duration-200 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"/>
            </svg>
        </a>
    <h1 class="text-2xl font-bold">{{ $class->name }} — Attendance</h1>
    <div class="flex items-center gap-2">
      <input type="date" id="attendanceDate" value="{{ now()->toDateString() }}" class="border rounded p-2">
      <button id="takeBtn" class="bg-blue-600 text-white px-4 py-2 rounded">Take Attendance</button>
      <a href="{{ route('pdf.attendance', $class->id) }}" class="bg-gray-700 text-white px-3 py-2 rounded">Export PDF</a>
    </div>
  </div>

  @if(session('success'))<div class="p-3 bg-green-100 text-green-800 rounded mb-4">{{ session('success') }}</div>@endif

  <div id="takeArea" style="display:none">
    <form method="POST" action="{{ route('attendance.store', $class->id) }}">
      @csrf
      <input type="hidden" name="date" id="formDate" value="{{ now()->toDateString() }}" />
      <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-4 py-2">Student</th>
              <th class="border px-4 py-2">Status</th>
              <th class="border px-4 py-2">Remarks</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $student)
              <tr>
                <td class="border px-4 py-2">{{ $student->name ?? $student->full_name }}</td>
                <td class="border px-4 py-2">
                  <select name="records[{{ $student->id }}][status]" class="border rounded px-2 py-1">
                    <option value="present">Present</option>
                    <option value="absent" selected>Absent</option>
                    <option value="late">Late</option>
                    <option value="excused">Excused</option>
                  </select>
                </td>
                <td class="border px-4 py-2">
                  <input type="text" name="records[{{ $student->id }}][remarks]" class="w-full border rounded p-1" />
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save Attendance</button>
      </div>
    </form>
  </div>

  <div class="mt-6">
    <h2 class="font-semibold mb-2">Previous Sessions</h2>
    <ul>
      @foreach($sessions as $s)
        <li class="py-2">
          <a class="text-blue-600 hover:underline" href="{{ route('attendance.show', [$class->id, $s->id]) }}">
            {{ $s->date }} — recorded by {{ $s->creator?->name ?? '—' }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</div>

<script>
document.getElementById('takeBtn').addEventListener('click', () => {
  document.getElementById('takeArea').style.display = 'block';
  const d = document.getElementById('attendanceDate').value;
  document.getElementById('formDate').value = d;
});
</script>
</x-app-layout>
