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
                        class="p-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl shadow-md hover:shadow-lg transition duration-200 cursor-pointer"
                    >
                        <h4 class="text-lg font-semibold text-yellow-300 leading-tight mb-1">
                            {{ Str::limit($a->title, 60) }}
                        </h4>
                        <div class="text-xs text-blue-100 font-medium mb-2">
                            {{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->diffForHumans() }}
                        </div>
                        <p class="text-sm leading-relaxed text-blue-50">
                            {{ Str::limit($a->content, 140) }}
                        </p>
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

                    <!-- Announcement Overlay -->
                    <div 
                        x-show="selected === {{ $a->id }}"
                        x-transition
                        x-cloak
                        class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4 overflow-y-auto"
                        @click.self="selected = null"
                    >
                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 shadow-2xl rounded-2xl p-8 border border-blue-400/60 backdrop-blur-sm">
                            <h2 class="text-2xl font-extrabold text-yellow-300 mb-2">{{ $a->title }}</h2>
                            <p class="text-sm text-blue-100 mb-3">
                                {{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->format('M d, Y h:i A') }}
                            </p>
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

        <!-- Create Announcement Button -->
        @if(auth()->user()->role === 'faculty' || auth()->user()->role === 'admin')
            <div class="mt-6 flex justify-center">
                <button 
                    @click="createAnnouncement = true"
                    class="flex items-center justify-center w-40 h-12 bg-yellow-500 hover:bg-white text-white hover:text-black rounded-full shadow-md hover:shadow-lg transition duration-200">
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
        class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4 overflow-y-auto"
        @click.self="createAnnouncement = false"
    >
        <div class="bg-blue-600 rounded-2xl shadow-2xl p-8 w-full h-full max-w-xl border border-blue-400">
            <!-- Success Message -->
            <div 
                x-show="success" 
                x-transition 
                class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded"
            >
                Announcement created successfully!
            </div>

            <h2 class="text-2xl font-bold text-white text-center mb-4">Create Announcement</h2>

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
    class="space-y-6 pt-2"
>
    <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Title</label>
                    <input type="text" name="title" required
                        class="w-full rounded-lg border border-gray-300 p-3.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 placeholder-gray-400">
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Content</label>
                    <textarea name="content" rows="6" required
                        class="w-full rounded-lg border border-gray-300 p-3.5 text-sm focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 resize-none placeholder-gray-400"></textarea>
                </div>

                <!-- Attachment -->
                <div>
                    <label class="block text-sm font-semibold text-yellow-200 mb-2">Attachment (optional)</label>
                    <input type="file" name="attachment"
                        class="w-full text-sm text-yellow-100 border border-white/70 rounded-lg cursor-pointer p-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                </div>

                <!-- Buttons -->
                <div class="pt-6 mt-4 flex justify-end gap-3 border-t border-blue-400/40">
                    <button type="button" 
                        @click="createAnnouncement = false"
                        class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition">
                        Cancel
                    </button>
                    <button type="submit"
                        x-bind:disabled="loading"
                        class="px-6 py-2.5 rounded-lg bg-yellow-400 text-black font-bold hover:bg-yellow-300 transition">
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
