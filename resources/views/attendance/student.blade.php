<x-app-layout>
<div class="container mx-auto p-6">
  <h1 class="text-2xl font-bold">{{ $class->name }} — My Attendance</h1>

  <div class="mt-4">
    <table class="table-auto w-full border-collapse">
      <thead class="bg-gray-100">
        <tr><th class="border px-4 py-2">Date</th><th class="border px-4 py-2">Status</th><th class="border px-4 py-2">Remarks</th></tr>
      </thead>
      <tbody>
        @forelse($records as $r)
          <tr>
            <td class="border px-4 py-2">{{ $r->attendance->date }}</td>
            <td class="border px-4 py-2">
              <span class="px-2 py-1 rounded {{ $r->status=='present'?'bg-green-100 text-green-700':'' }} {{ $r->status=='absent'?'bg-red-100 text-red-700':'' }} {{ $r->status=='late'?'bg-yellow-100 text-yellow-700':'' }} {{ $r->status=='excused'?'bg-blue-100 text-blue-700':'' }}">
                {{ ucfirst($r->status) }}
              </span>
            </td>
            <td class="border px-4 py-2">{{ $r->remarks }}</td>
          </tr>
        @empty
          <tr><td colspan="3" class="border px-4 py-4 text-center">No attendance records yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
</x-app-layout>
