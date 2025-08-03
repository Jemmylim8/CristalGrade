<x-app-layout>
    <h1 class="text-xl font-bold mb-4">My Joined Classes</h1>

    @if ($classes->isEmpty())
        <p class="text-gray-600">You haven’t joined any classes yet.</p>
    @else
        <table class="table-auto w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Subject</th>
                    <th class="px-4 py-2 border">Section</th>
                    <th class="px-4 py-2 border">Faculty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $index => $class)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2">{{ $class->subject }}</td>
                        <td class="border px-4 py-2">{{ $class->section }}</td>
                        <td class="border px-4 py-2">{{ $class->faculty->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>
