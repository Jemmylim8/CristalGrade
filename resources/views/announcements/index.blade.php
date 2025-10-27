<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Page Header -->
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

        <!-- Announcements Container -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Announcements List --}}
            @if($announcements->isEmpty())
                <p class="text-gray-600">No announcements yet.</p>
            @else
                <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($announcements as $a)
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

                            <!-- Edit/Delete Buttons (for authorized users) -->
@if(auth()->user()->id === $a->user_id || auth()->user()->role === 'admin')
    <div class="mt-3 flex gap-2">

        {{-- Edit Button --}}
        <a href="{{ route('announcements.edit', $a->id) }}" 
           class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-600 transition duration-300 shadow-sm"
           title="Edit Announcement">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
            </svg>
        </a>

        {{-- Delete Button --}}
        <form action="{{ route('announcements.destroy', $a->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this announcement?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-100 hover:bg-red-500 hover:text-white text-red-600 transition duration-300 shadow-sm"
                    title="Delete Announcement">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>

    </div>
@endif

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
