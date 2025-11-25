<x-app-layout>
<div class="container mx-auto p-6">
  <a href="{{ route('attendance.index', $class->id) }}"
           class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-white/80 text-blue-700 hover:bg-white hover:text-black transition-all duration-200 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"/>
            </svg>
        </a>
  <h1 class="text-2xl font-bold">{{ $class->name }} — Attendance for {{ $attendance->date }}</h1>

  @if(session('success'))<div class="p-3 bg-green-100 text-green-800 rounded mb-4">{{ session('success') }}</div>@endif

  <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
    @csrf @method('PUT')
    <table class="table-auto w-full border-collapse mt-4">
      <thead class="bg-gray-100">
        <tr><th class="border px-4 py-2">Student</th><th class="border px-4 py-2">Status</th><th class="border px-4 py-2">Remarks</th></tr>
      </thead>
      <tbody>
        @foreach($records as $r)
          <tr>
            <td class="border px-4 py-2">{{ $r->student->name ?? $r->student->full_name }}</td>
            <td class="border px-4 py-2">
              <select name="records[{{ $r->student_id }}][status]" class="border rounded px-2 py-1">
                <option value="present" {{ $r->status==='present'?'selected':'' }}>Present</option>
                <option value="absent" {{ $r->status==='absent'?'selected':'' }}>Absent</option>
                <option value="late" {{ $r->status==='late'?'selected':'' }}>Late</option>
                <option value="excused" {{ $r->status==='excused'?'selected':'' }}>Excused</option>
              </select>
            </td>
            <td class="border px-4 py-2">
              <input type="text" name="records[{{ $r->student_id }}][remarks]" value="{{ $r->remarks }}" class="w-full border rounded p-1" />
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-4">
      <button class="bg-green-600 text-white px-4 py-2 rounded">Update Attendance</button>
    </div>
  </form>
</div>
</x-app-layout>
