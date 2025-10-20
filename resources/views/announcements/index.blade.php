<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Announcements</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Success message --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($announcements->isEmpty())
                    <p>No announcements yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($announcements as $announcement)
                            <div class="border rounded p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-lg font-medium">{{ $announcement->title }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $announcement->user->name ?? 'Staff' }} • {{ $announcement->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    {{-- Edit/Delete only for authoring faculty or admin --}}
                                    @if(auth()->user()->id === $announcement->user_id || auth()->user()->role === 'admin')
                                        <div class="flex space-x-2">
                                            <a href="{{ route('announcements.edit', $announcement->id) }}"
                                               class="text-xs px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded">
                                                Edit
                                            </a>

                                            <form action="{{ route('announcements.destroy', $announcement->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-xs px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                <p class="mt-2 text-gray-700">{{ $announcement->content }}</p>

                                @if($announcement->attachment_path)
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $announcement->attachment_path) }}"
                                           target="_blank"
                                           class="text-xs text-blue-600 hover:underline">
                                            View attachment
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
