<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Announcement
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Title</label>
                        <input type="text" name="title" value="{{ old('title', $announcement->title) }}" class="form-input w-full rounded border-gray-300" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Content</label>
                        <textarea name="content" rows="5" class="form-input w-full rounded border-gray-300" required>{{ old('content', $announcement->content) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Attachment (optional)</label>
                        <input type="file" name="attachment" class="form-input w-full border-gray-300">
                        @if($announcement->attachment_path)
                            <p class="text-sm mt-2">
                                Current: <a href="{{ asset('storage/'.$announcement->attachment_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                    View file
                                </a>
                            </p>
                        @endif
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('announcements.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
