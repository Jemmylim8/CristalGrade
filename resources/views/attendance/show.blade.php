<x-app-layout>
<div class="container mx-auto p-6">
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
