<x-app-layout>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif
    <!-- Back Button -->
    <a href="{{ route('classes.show', $class->id) }}"
        class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-white/80 
               text-white hover:text-blue-700 hover:bg-white bg-blue-700 transition-all duration-200 shadow-md ml-6 mt-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" />
        </svg>
    </a>
    
    <div class="container mx-auto p-6">

        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
            {{ $class->name }}
            <span class="text-blue-700">— My Attendance</span>
        </h1>

        <!-- Table Wrapper -->
        <div class="overflow-x-auto rounded-2xl border border-gray-300 shadow-sm bg-white/70 mt-6">
            <table class="w-full text-left border-collapse">

                <thead class="bg-gray-200/90 text-gray-800 rounded-t-2xl">
                    <tr>
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wide text-center border-b">Date</th>
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wide text-center border-b">Status</th>
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wide text-center border-b">Remarks</th>
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wide text-center border-b">Excuse</th>
                        <th class="px-6 py-4 text-sm font-semibold uppercase tracking-wide text-left border-b">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $r)
                        <tr class="border-b border-gray-200 hover:bg-gray-50/70 transition">

                            <!-- Date -->
                            <td class="px-6 py-4 text-blue-700 font-bold text-center">
                                {{ $r->attendance->date }}
                            </td>

                            <!-- Status badge -->
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-lg text-sm font-semibold
                                    {{ $r->status=='present' ? 'bg-green-100 text-green-700 border border-green-300' : '' }}
                                    {{ $r->status=='absent' ? 'bg-red-100 text-red-700 border border-red-300' : '' }}
                                    {{ $r->status=='late' ? 'bg-yellow-100 text-yellow-700 border border-yellow-300' : '' }}
                                    {{ $r->status=='excused' ? 'bg-blue-100 text-blue-700 border border-blue-300' : '' }} "
                                >
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>

                            <!-- Remarks -->
                            <td class="px-6 py-4 text-gray-700 text-center">
                                {{ $r->remarks }}
                            </td>

                            <!-- Excuse upload -->
                             
                            <td class="px-6 py-4 text-center">
                        @if($r->excuse_file)
                            <div class="flex flex-col items-center space-y-1">
                                <a href="{{ asset('storage/' . $r->excuse_file) }}" target="_blank" class="text-blue-600 underline text-sm">
                                    View Excuse
                                </a>

                                <!-- Edit (replace) -->
                                <form action="{{ route('attendance.uploadExcuse', $r->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                                    @csrf
                                    <input type="file" name="excuse_file" accept=".pdf,.jpg,.jpeg,.png" required class="mb-1 text-xs">
                                    <button type="submit" class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-400">
                                        Replace
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('attendance.deleteExcuse', $r->id) }}" method="POST" class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-500"
                                        onclick="return confirm('Are you sure you want to delete this excuse file?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @elseif($r->status=='absent' || $r->status=='excused')
                            <!-- Upload new -->
                            <form action="{{ route('attendance.uploadExcuse', $r->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                                @csrf
                                
                                <input type="file" name="excuse_file" accept=".pdf,.jpg,.jpeg,.png" required class="mb-1">
                                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500 text-sm">
                                    Upload
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td>
                    {{$r->excuse_status}}
                    </td>   

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-600">
                                No attendance records yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</x-app-layout>
