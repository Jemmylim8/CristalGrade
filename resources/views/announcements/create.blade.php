<x-app-layout>

       <div class="mb-4">
            <a href="{{ route('announcements.index') }}"
            class="w-12 h-12 flex items-center justify-center rounded-full border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-md">
            
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-blue-500 border border-gray-200 rounded-xl p-6">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <h2 class="font-bold text-3xl text-center text-white">Create Announcement</h2>
                <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8 bg-transparent px-6 py-6 rounded-x1">
                    @csrf

                    {{-- Title --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-yellow-300">Title</label>
                        <input type="text" name="title" required
                            value="{{ old('title') }}"
                            class="w-full border-gray-300 focus:ring-0 focus:border-blue-500 rounded-md p-3 text-sm shadow-sm" />
                        @error('title')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Content --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-white">Content</label>
                        <textarea name="content" rows="6" required
                                class="w-full border-gray-300 focus:ring-0 focus:border-blue-500 rounded-md p-3 text-sm shadow-sm resize-none">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Attachment --}}
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-yellow-200">Attachment (optional)</label>
                        <input type="file" name="attachment"
                            class="w-full text-sm text-yellow-200 border border-white rounded-md cursor-pointer focus:outline-none focus:border-blue-500 p-2" />
                        @error('attachment')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ url()->previous() }}"
                        class="px-5 py-2 text-sm font-bold bg-yellow-400 hover:bg-yellow-200 text-gray-700 hover:text-gray-800 rounded-lg transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-5 py-2 text-sm font-bold bg-blue-600 hover:bg-blue-300 text-white hover:text-gray-700 rounded-lg transition">
                            Post
                        </button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</x-app-layout>
