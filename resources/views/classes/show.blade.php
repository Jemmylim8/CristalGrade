<x-app-layout>
    <h1 class="text-xl font-bold mb-4">{{ $class->subject }} - {{ $class->section }}</h1>
    <p class="mb-4">Join Code: <strong>{{ $class->join_code }}</strong></p>

    <h2 class="text-lg font-bold mb-2">Enrolled Students</h2>

    @if ($students->isEmpty())
        <p class="text-gray-600">No students have joined yet.</p>
    @else
        <table class="table-auto w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $index => $student)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2">{{ $student->name }}</td>
                        <td class="border px-4 py-2">{{ $student->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    <a href="{{ route('classes.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-3 py-1 rounded">
        Back to Classes
    </a>
</x-app-layout>
