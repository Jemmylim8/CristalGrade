@php
$announcementsToShow = $sidebarAnnouncements ?? collect();
@endphp

<div x-data="{ showSidebar: true, selected: null }" class="relative" @keydown.escape.window="selected = null">

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
            <!-- Announcements List (scrollable clean scrollbar) -->
            <div class="space-y-4 max-h-[420px] overflow-y-auto pr-2 custom-scrollbar">
                @foreach($announcementsToShow as $a)
                    <div 
                        @click="selected = {{ $a->id }}"
                        class="p-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl shadow-md hover:shadow-lg transition duration-200 cursor-pointer"
                    >
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

                    <!-- Overlay Modal -->
                    <div 
                        x-show="selected === {{ $a->id }}"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4 overflow-y-auto"
                        x-cloak
                        @click.self="selected = null"
                    >
                        <div class="p-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl shadow-2xl max-w-xl w-full">
                            <!-- Content -->
                            <h2 class="text-2xl font-extrabold text-yellow-300 mb-2">{{ $a->title }}</h2>
                            <p class="text-sm text-blue-100 mb-3">{{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->format('M d, Y h:i A') }}</p>
                            <p class="text-base leading-relaxed text-blue-50 mb-4 whitespace-pre-line">{{ $a->content }}</p>

                            @if($a->attachment_path)
                                <a href="{{ asset('storage/' . $a->attachment_path) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-1 text-sm font-medium text-yellow-200 hover:text-white underline transition">
                                    View Attachment
                                </a>
                            @endif
                        </div>
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

<!-- Clean Custom Scrollbar (no gradient) -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.35);
    }
</style>
