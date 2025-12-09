<x-app-layout>
    <div class="container mx-auto p-6 space-y-6">
        
<<<<<<< HEAD
        <!-- Header Section with Back Button -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">My Score History</h1>
            
            <!-- Back to Class Button (Same Design as View History) -->
            <a href="{{ route('classes.show', $classId) }}"
               class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-600 hover:to-blue-700 text-white font-semibold">
                Back to Class
            </a>
        </div>

        <!-- History Table -->
        <div class="bg-white shadow-xl rounded-2xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Activity</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Old Score</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">New Score</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Updated By</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($history as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    {{ $item->activity->title ?? $item->component }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-red-100 text-red-700 font-bold">
                                        {{ $item->old_score ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-green-100 text-green-700 font-bold">
                                        {{ $item->new_score }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $item->faculty->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ $item->created_at->format('M d, Y - h:i A') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">No history records found.</p>
                                        <p class="text-sm text-gray-400">Score changes will appear here once they occur.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
=======
        <h1 class="text-2xl font-bold mb-6">My Score History</h1>
        <a href="{{ route('classes.show', $classId) }}"
           class="px-4 py-2 bg-blue-800 text-white rounded-lg hover:bg-indigo-500">
            Back to Class
        </a>

        <div class="bg-white shadow rounded-lg overflow-x-auto mt-4">
        
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Activity</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Old Score</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">New Score</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Updated By</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($history as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm">{{ $item->activity?->title ?? $item->component ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-red-600 font-semibold">{{ $item->old_score ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-green-600 font-semibold">{{ $item->new_score ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm">{{ $item->faculty?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $item->created_at?->format('M d, Y - h:i A') ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                No history records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($history->count())
                <div class="mt-4">
                    {{ $history->links() }}
                </div>
            @endif
>>>>>>> d5eca81dbacd335e76f890d4ba955cee1455ca66

            <!-- Pagination -->
            @if($history->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>