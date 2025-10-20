@php
$announcementsToShow = $sidebarAnnouncements ?? collect();
@endphp

<div class="bg-white rounded-lg shadow p-4">
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold text-lg">Announcements</h3>
        <a href="{{ route('announcements.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
    </div>

    @if($announcementsToShow->isEmpty())
        <p class="text-sm text-gray-500">No announcements yet.</p>
    @else
        <div class="space-y-3">
            @foreach($announcementsToShow as $a)
                <div class="border rounded p-3">
                    <div class="text-sm font-medium">{{ Str::limit($a->title, 60) }}</div>
                    <div class="text-xs text-gray-500">{{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->diffForHumans() }}</div>
                    <p class="text-sm text-gray-700 mt-2">{{ Str::limit($a->content, 140) }}</p>
                    @if($a->attachment_path)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $a->attachment_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline">View attachment</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if(auth()->user()->role === 'faculty' || auth()->user()->role === 'admin')
        <div class="mt-4">
            <a href="{{ route('announcements.create') }}" class="block text-center bg-green-500 hover:bg-green-600 text-white text-sm px-3 py-2 rounded">+ New Announcement</a>
        </div>
    @endif
</div>
