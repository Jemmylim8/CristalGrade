<x-app-layout>
    <div class="container mx-auto p-6 space-y-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Score History</h1>

            <a href="{{ route('classes.show', $classId) }}"
               class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-600 hover:to-blue-700 text-white font-semibold">
                Back to Class
            </a>
        </div>
        @if(auth()->user()->role === 'faculty')
        <!-- HISTORY TABLE -->
        <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Student
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Activity
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Old Score
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            New Score
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Updated By
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Date
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                    @forelse ($history as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->student->name }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->activity->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-red-600 font-semibold">
                                {{ $item->old_score }}
                            </td>
                            <td class="px-4 py-3 text-sm text-green-600 font-semibold">
                                {{ $item->new_score }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->faculty->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y - h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                No history records found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
                <div class="mt-4">
                    {{ $history->links() }}
                </div>

            </table>
        </div>
        @endif
        @if(auth()->user()->role === 'student')
         <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Student
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Activity
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Old Score
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            New Score
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Updated By
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Date
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                    @forelse ($history as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->student->name }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->activity->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-red-600 font-semibold">
                                {{ $item->old_score }}
                            </td>
                            <td class="px-4 py-3 text-sm text-green-600 font-semibold">
                                {{ $item->new_score }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ $item->faculty->name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y - h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                No history records found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
                <div class="mt-4">
                    {{ $history->links() }}
                </div>

            </table>
        </div>
        @endif
    </div>
</x-app-layout>
