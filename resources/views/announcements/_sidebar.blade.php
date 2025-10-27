@php
$announcementsToShow = $sidebarAnnouncements ?? collect();
@endphp

<div x-data="{ showSidebar: true }" class="relative">

    <!-- Sidebar Content -->
    <div 
        x-show="showSidebar"
        x-transition
        class="bg-white rounded-xl shadow-lg p-5 mt-8 border border-gray-100"
    >
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-xl text-gray-800 tracking-tight">Announcements</h3>
            <a href="{{ route('announcements.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                View all
            </a>
        </div>

        <!-- No Announcements -->
        @if($announcementsToShow->isEmpty())
            <div class="bg-gray-50 text-gray-500 text-sm rounded-lg py-6 text-center border border-gray-200">
                No announcements yet.
            </div>
        @else
            <!-- Announcements List -->
            <div class="space-y-4">
                @foreach($announcementsToShow as $a)
                    <div class="p-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl shadow-md hover:shadow-lg transition duration-200">
                        <!-- Title -->
                        <h4 class="text-lg font-semibold text-yellow-300 leading-tight mb-1">
                            {{ Str::limit($a->title, 60) }}
                        </h4>

                        <!-- Meta Info -->
                        <div class="text-xs text-blue-100 font-medium mb-2">
                            {{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->diffForHumans() }}
                        </div>

                        <!-- Content -->
                        <p class="text-sm leading-relaxed text-blue-50">
                            {{ Str::limit($a->content, 140) }}
                        </p>

                        <!-- Attachment -->
                        @if($a->attachment_path)
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $a->attachment_path) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1 text-xs font-medium text-yellow-200 hover:text-white transition">
                                    View attachments
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Add Announcement Button -->
        @if(auth()->user()->role === 'faculty' || auth()->user()->role === 'admin')
            <div class="mt-6 flex justify-center">
                <a href="{{ route('announcements.create') }}"
                   class="flex items-center justify-center w-40 h-12 bg-yellow-500 hover:bg-white text-white hover:text-black rounded-full shadow-md hover:shadow-lg transition duration-200">
                    <span class="text-2xl font-bold leading-none">+</span>
                </a>
            </div>
        @endif
    </div>
</div>
