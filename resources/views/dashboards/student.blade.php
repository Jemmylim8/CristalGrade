<x-app-layout>
    <div x-data="{ openModal: false }" x-cloak class="min-h-screen p-8">

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
                        // Pastel randoms
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
                            <div>{{strtoupper($class->subject)}}</div>
                        </div>

                        <!-- Footer with Details -->
                        <div class="px-5 py-3 text-sm font-bold text-gray-700" style="background-color: {{ $footerBg }};">                          
                            <div>{{ $class->section ?? 'N/A' }}</div> 
                            <div>{{ $class->schedule ?? 'TBA' }}</div>
                            <div>{{ $class->faculty?->name ?? '—' }}</div>
                            
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Floating Join Button -->
        <button @click="openModal = true"
            class="fixed bottom-6 right-6 bg-[#3B82F6] hover:bg-[#2563EB] text-white rounded-full shadow-xl w-16 h-16 flex items-center justify-center text-4xl transition">
            +
        </button>

        <!-- Join Class Modal -->
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
    </div>
</x-app-layout>
