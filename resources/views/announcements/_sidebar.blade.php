@php
$announcementsToShow = $sidebarAnnouncements ?? collect();
@endphp

<div 
    x-data="{ 
        showSidebar: true, 
        selected: null, 
        createAnnouncement: false, 
        loading: false, 
        success: false 
    }" 
    class="relative" 
    @keydown.escape.window="selected = null; createAnnouncement = false"
>
    <!-- Sidebar Content -->
    <div 
        x-show="showSidebar"
        x-transition
        class="bg-white rounded-xl shadow-lg p-5 mt-8 border border-gray-100"
    >
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-xl text-gray-800 tracking-tight">CSD BULLETIN BOARD</h3>
            <a href="{{ route('announcements.index') }}" 
               class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                View all
            </a>
        </div>

        <!-- Empty State -->
        @if($announcementsToShow->isEmpty())
            <div class="bg-gray-50 text-gray-500 text-sm rounded-lg py-6 text-center border border-gray-200">
                No announcements yet.
            </div>
        @else
            <!-- Announcements List -->
<div class="space-y-4 max-h-[420px] overflow-y-auto pr-2 custom-scrollbar">
    @foreach($announcementsToShow as $a)
        <div 
            @click="selected = {{ $a->id }}"
            class="p-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl shadow-md hover:shadow-lg transition duration-200 cursor-pointer flex gap-4 overflow-hidden"
        >
            <!-- Left Content -->
            <div class="flex-1 min-w-0 overflow-hidden">
                <h4 class="text-lg font-semibold text-yellow-300 leading-tight mb-1 break-words overflow-wrap-break-word">
                    {{ Str::limit($a->title, 60) }}
                </h4>
                <div class="text-xs text-blue-100 font-medium mb-2 truncate">
                    {{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->diffForHumans() }}
                </div>
                <p class="text-sm leading-relaxed text-blue-50 break-words overflow-hidden">
                    {{ Str::limit($a->content, 140) }}
                </p>
                @if($a->attachment_path)
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $a->attachment_path) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-1 text-xs font-medium text-yellow-200 hover:text-white transition truncate">
                            View attachments
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Right Image -->
            <img 
                src="{{ $a->user->profile_photo 
                       ? asset('uploads/profile/' . $a->user->profile_photo)
                    : asset('images/profile.png') }}"
                class="w-10 h-10 rounded-full object-cover flex-shrink-0 self-start border-2 border-blue-400"
                alt="User Avatar"
            />
        </div>

        <!-- Announcement Overlay -->
        <div 
            x-show="selected === {{ $a->id }}"
            x-transition
            x-cloak
            class="fixed inset-0 bg-black/60 flex items-center justify-center z-[9999] p-4"
            @click.self="selected = null"
            style="overflow-y: auto;"
        >
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 shadow-2xl rounded-2xl p-8 border border-blue-400/60 backdrop-blur-sm relative max-w-2xl w-full my-8 overflow-hidden">
                <!-- User Info with Avatar -->
                <div class="flex items-center gap-3 mb-4">
                    <img 
                        src="{{ $a->user->profile_photo 
                               ? asset('uploads/profile/' . $a->user->profile_photo)
                            : asset('images/profile.png') }}"
                        class="w-12 h-12 rounded-full object-cover border-2 border-yellow-300 flex-shrink-0"
                        alt="User Avatar"
                    />
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-semibold text-yellow-300 break-words">{{ $a->user->name ?? 'Staff' }}</h3>
                        <p class="text-xs text-blue-100 truncate">{{ $a->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>

                <!-- Title -->
                <h2 class="text-2xl font-extrabold text-white mb-4 break-words word-break">{{ $a->title }}</h2>
                
                <!-- Content - Full text displayed with proper word wrapping -->
                <div class="text-base leading-relaxed text-blue-50 mb-4 whitespace-pre-line break-words overflow-hidden" style="word-wrap: break-word; overflow-wrap: break-word;">
                    {{ $a->content }}
                </div>

                <!-- Attachment -->
                @if($a->attachment_path)
                    <div class="mt-6 pt-4 border-t border-blue-400/40">
                        <a href="{{ asset('storage/' . $a->attachment_path) }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 hover:bg-yellow-300 text-black font-semibold rounded-lg transition break-all">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                            </svg>
                            <span class="truncate">View Attachment</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
        @endif

        <!-- Create Announcement Button -->
        @if(auth()->user()->role === 'faculty' || auth()->user()->role === 'admin')
            <div class="mt-6 flex justify-center">
                <button 
                    @click="createAnnouncement = true"
                    class="flex items-center justify-center w-40 h-12 bg-yellow-500 hover:bg-yellow-400 text-white hover:text-black rounded-full shadow-md hover:shadow-lg transition duration-200"
                    title="Add Announcement">
                    <span class="text-2xl font-bold leading-none">+</span>
                </button>
            </div>
        @endif
    </div>

    <!-- Create Announcement Overlay -->
    <div 
        x-show="createAnnouncement"
        x-transition
        x-cloak
        class="fixed inset-0 bg-black/60 flex items-center justify-center z-[9999] p-4"
        @click.self="createAnnouncement = false"
    >
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-2xl p-8 w-full max-w-xl max-h-[90vh] overflow-y-auto border border-blue-400">
            <!-- Close Button -->
            <button 
                @click="createAnnouncement = false"
                class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 text-white transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Success Message -->
            <div 
                x-show="success" 
                x-transition 
                class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded-lg"
            >
                Announcement created successfully!
            </div>

            <h2 class="text-2xl font-bold text-white text-center mb-6">Create Announcement</h2>

            <!-- Form -->
            <form 
                x-ref="form"
                @submit.prevent="
                    loading = true;
                    let form = new FormData($refs.form);
                    fetch('{{ route('announcements.store') }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: form
                    })
                    .then(res => res.ok ? res.text() : Promise.reject(res))
                    .then(() => { 
                        loading = false;
                        success = true;
                        $refs.form.reset();
                        setTimeout(() => success = false, 2500);
                        createAnnouncement = false;
                        window.location.reload();
                    })
                    .catch(() => { 
                        loading = false; 
                        alert('Something went wrong while posting.');
                    })"
                enctype="multipart/form-data"
                class="space-y-6"
            >
                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Title</label>
                    <input type="text" name="title" required
                        class="w-full rounded-lg border border-gray-300 p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 placeholder-gray-400">
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Content</label>
                    <textarea name="content" rows="6" required
                        class="w-full rounded-lg border border-gray-300 p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 resize-none placeholder-gray-400"></textarea>
                </div>

                <!-- Attachment -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Attachment (optional)</label>
                    <input type="file" name="attachment"
                        class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer p-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-yellow-300">
                </div>

                <!-- Buttons -->
                <div class="pt-6 mt-4 flex justify-end gap-3 border-t border-blue-400/40">
                    <button type="button" 
                        @click="createAnnouncement = false"
                        class="px-5 py-2.5 rounded-lg bg-white/20 text-white hover:bg-white/30 font-medium transition">
                        Cancel
                    </button>
                    <button type="submit"
                        x-bind:disabled="loading"
                        class="px-6 py-2.5 rounded-lg bg-yellow-400 text-black font-bold hover:bg-yellow-300 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!loading">Post</span>
                        <span x-show="loading" class="animate-pulse">Posting...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 8px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(0, 0, 0, 0.35);
}
</style>