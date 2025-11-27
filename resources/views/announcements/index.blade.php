<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Announcements</h1>

            <!-- Back Button -->
            <a href="{{ route('dashboard') }}"
               class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-md"
               title="Back to Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     class="w-6 h-6">
                    <path fill-rule="evenodd"
                          d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"
                          clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <!-- Announcements -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($announcements->isEmpty())
                <p class="text-gray-600">No announcements yet.</p>
            @else
                <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3" 
                     x-data="{ selected: null }"
                     @keydown.escape.window="selected = null">
                     
                    @foreach($announcements as $a)
                        <!-- Announcement Card -->
                        <div 
                            @click="selected = {{ $a->id }}"
                            class="relative p-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl shadow-md hover:shadow-lg transition duration-200 cursor-pointer">

                            <!-- Dropdown Menu -->
                            @if(auth()->user()->id === $a->user_id || auth()->user()->role === 'admin')
                                <div x-data="{ open: false }" class="absolute top-3 right-3">
                                    <button 
                                        @click.stop="open = !open"
                                        class="text-blue-100 hover:text-white transition rounded-full p-1 hover:bg-blue-500/30"
                                        title="Options">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            width="22" height="22" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icon-tabler-dots-vertical">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown List -->
                                    <div 
                                        x-show="open"
                                        @click.away="open = false"
                                        x-transition
                                        class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-md z-50 py-2">

                                        <!-- Edit -->
                                        <a href="{{ route('announcements.edit', $a->id) }}"
                                           class="flex items-center gap-2 px-3 py-2 text-sm text-yellow-600 hover:bg-yellow-50 rounded-md transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                 viewBox="0 0 24 24" class="w-4 h-4">
                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 
                                                0l-1.157 1.157 3.712 3.712 
                                                1.157-1.157a2.625 2.625 0 0 0 
                                                0-3.712ZM19.513 8.199l-3.712-3.712-12.15 
                                                12.15a5.25 5.25 0 0 
                                                0-1.32 2.214l-.8 2.685a.75.75 
                                                0 0 0 .933.933l2.685-.8a5.25 
                                                5.25 0 0 0 2.214-1.32L19.513 
                                                8.2Z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('announcements.destroy', $a->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="flex items-center gap-2 w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 24 24" class="w-4 h-4">
                                                    <path fill-rule="evenodd" 
                                                          d="M16.5 4.478v.227a48.816 
                                                          48.816 0 0 1 3.878.512.75.75 
                                                          0 1 1-.256 1.478l-.209-.035-1.005 
                                                          13.07a3 3 0 0 1-2.991 
                                                          2.77H8.084a3 3 0 0 
                                                          1-2.991-2.77L4.087 
                                                          6.66l-.209.035a.75.75 
                                                          0 0 1-.256-1.478A48.567 
                                                          48.567 0 0 1 7.5 
                                                          4.705v-.227c0-1.564 
                                                          1.213-2.9 2.816-2.951a52.662 
                                                          52.662 0 0 1 3.369 
                                                          0c1.603.051 2.815 
                                                          1.387 2.815 
                                                          2.951Z" 
                                                          clip-rule="evenodd" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <!-- Title & Summary -->
                            <h4 class="text-lg font-semibold text-yellow-300 mb-1">{{ Str::limit($a->title, 60) }}</h4>
                            <div class="text-xs text-blue-100 mb-2">
                                {{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->diffForHumans() }}
                            </div>
                            <p class="text-sm text-blue-50">{{ Str::limit($a->content, 140) }}</p>

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

                        <!-- Overlay (No Close Button) -->
                        <div 
                            x-show="selected === {{ $a->id }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4"
                            x-cloak
                            @click.self="selected = null">

                            <div class="p-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl shadow-2xl max-w-xl w-full">
                                <!-- Content -->
                                <h2 class="text-2xl font-extrabold text-yellow-300 mb-2">{{ $a->title }}</h2>
                                <p class="text-sm text-blue-100 mb-3">{{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->format('M d, Y h:i A') }}</p>
                                <p class="text-base leading-relaxed text-blue-50 mb-4">{{ $a->content }}</p>

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
        </div>
    </div>
</x-app-layout>
