<x-app-layout>
    <div x-data="{ openModal: false, showAnnouncements: false }" x-cloak class="min-h-screen p-8">

        {{-- Button to open Announcements --}}
        <button @click="showAnnouncements = true"
                class="fixed top-6 left-6 z-50 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            Announcements
        </button>

        {{-- Main Content: Courses --}}
        <div class="grid grid-cols-1 gap-6 lg:gap-8">
            <h1 class="text-2xl font-extrabold mb-6 text-gray-800">My Courses</h1>

            @if ($classes->isEmpty())
                <div class="bg-white rounded-2xl shadow p-6 text-center">
                    <p class="text-gray-600 mb-4">You haven’t joined any classes yet.</p>
                    <button @click="openModal = true"
                            class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                        Join a Class
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($classes as $class)
                        @php
                            $pastels = ['#FFE5EC', '#E5F4FF', '#FFF6CC', '#E8FFD5', '#F3E8FF'];
                            $footerBg = $pastels[array_rand($pastels)];
                        @endphp

                        <a href="{{ route('classes.show', $class->id) }}"
                           class="block bg-[#CCE4FF] rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden">
                            <!-- Card Body -->
                            <div class="p-5 mb-3">
                                <div class="mt-1 text-xl text center font-extrabold text-[#3345AE]">
                                    {{ strtoupper($class->name) }}
                                </div>
                                <div>{{ strtoupper($class->subject) }}</div>
                            </div>

                            <!-- Footer -->
                            <div class="px-5 py-3 text-sm font-bold text-gray-700"
                                 style="background-color: {{ $footerBg }};">
                                <div>{{ $class->section ?? 'N/A' }}</div>
                                <div>{{ $class->schedule ?? 'TBA' }}</div>
                                <div>{{ $class->faculty?->name ?? '—' }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Floating Join Button --}}
            <button @click="openModal = true"
                    class="fixed bottom-6 right-6 bg-[#3B82F6] hover:bg-[#2563EB] text-white rounded-full shadow-xl w-16 h-16 flex items-center justify-center text-4xl transition">
                +
            </button>
        </div>

        {{-- Join Class Modal --}}
        <div x-show="openModal" x-transition.opacity
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="openModal = false" class="bg-white rounded-lg shadow-lg p-6 w-80">
                <h2 class="text-lg font-bold mb-4 text-center">Join a Class</h2>
                <form method="POST" action="{{ route('classes.join') }}">
                    @csrf
                    <input type="text" name="join_code" placeholder="Enter Class Code"
                           class="w-full border-gray-300 rounded-lg p-2 mb-4" required>
                    <button type="submit"
                            class="w-full bg-[#3B82F6] hover:bg-[#2563EB] text-white py-2 rounded-lg font-bold">
                        Join
                    </button>
                </form>
                <button @click="openModal = false"
                        class="mt-4 w-full bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-lg">
                    Cancel
                </button>
            </div>
        </div>

        {{-- Announcements Drawer --}}
        <div x-show="showAnnouncements"
             x-transition:enter="transition transform duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition transform duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 w-80 bg-white shadow-xl z-50 overflow-y-auto">

            <div class="p-4 flex justify-between items-center border-b">
                <h3 class="font-semibold text-lg">Announcements</h3>
                <button @click="showAnnouncements = false"
                        class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <div class="p-4 space-y-3">
                @if($announcements->isEmpty())
                    <p class="text-gray-500">No announcements yet.</p>
                @else
                    @foreach($announcements as $a)
                        <div class="border rounded p-3">
                            <div class="text-sm font-medium">{{ Str::limit($a->title, 60) }}</div>
                            <div class="text-xs text-gray-500">{{ $a->user->name ?? 'Staff' }} • {{ $a->created_at->diffForHumans() }}</div>
                            <p class="text-sm text-gray-700 mt-1">{{ Str::limit($a->content, 140) }}</p>

                            @if($a->attachment_path)
                                <a href="{{ asset('storage/' . $a->attachment_path) }}" target="_blank"
                                   class="text-xs text-blue-600 hover:underline mt-1 block">
                                    View attachment
                                </a>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Overlay for drawer --}}
        <div x-show="showAnnouncements" @click="showAnnouncements = false"
             x-transition.opacity
             class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    </div>
</x-app-layout>
