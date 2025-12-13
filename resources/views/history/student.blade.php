<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="container mx-auto p-6 space-y-6">
        

        <h1 class="text-2xl font-bold mb-6">My Score History</h1>
        <a href="{{ url()->previous() }}"
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase">Updated At</th>
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


            <!-- Pagination -->
            @if($history->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $history->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>