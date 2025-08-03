<x-app-layout>
<div class="max-w-5xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📚 Classes</h1>
        <div>
            <a href="{{ route('dashboard') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">
                ⬅ Back to Dashboard
            </a>
            @if(auth()->user()->role === 'faculty' || auth()->user()->role === 'admin')
            <a href="{{ route('classes.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ➕ Create Class
            </a>
            @endif
        </div>
    </div>

    {{-- ✅ Show success message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Class list table --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 border">Class Name</th>
                    <th class="px-4 py-2 border">Subject</th>
                    <th class="px-4 py-2 border">Section</th>
                    <th class="px-4 py-2 border">Join Code</th>
                    <th class="px-4 py-2 border">Faculty</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    <tr class="text-gray-800">
                        <td class="px-4 py-2 border">{{ $class->name }}</td>
                        <td class="px-4 py-2 border">{{ $class->subject }}</td>
                        <td class="px-4 py-2 border">{{ $class->section }}</td>
                        <td class="px-4 py-2 border font-mono text-blue-600">{{ $class->join_code }}</td>
                        <td class="px-4 py-2 border">
                            {{ $class->faculty->name ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">No classes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>

