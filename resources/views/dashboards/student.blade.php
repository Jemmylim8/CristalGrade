<x-app-layout>
    
    @if (session('left_success'))
    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow">
        {{ session('left_success') }}
    </div>
@endif
    <div x-data="{ openModal: false, showSidebar: true }" class="min-h-screen p-8 flex gap-8 relative">

        {{-- Toggle Button for Announcements Sidebar --}}
        <button 
            @click="showSidebar = !showSidebar"
            class="absolute top-6 left-6 bg-[#EDEDED] hover:bg-blue-700 text-black hover:text-white  px-4 py-2 rounded shadow transition z-50 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M2.625 6.75a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875 0A.75.75 0 0 1 8.25 6h12a.75.75 0 0 1 0 1.5h-12a.75.75 0 0 1-.75-.75ZM2.625 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0ZM7.5 12a.75.75 0 0 1 .75-.75h12a.75.75 0 0 1 0 1.5h-12A.75.75 0 0 1 7.5 12Zm-4.875 5.25a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875 0a.75.75 0 0 1 .75-.75h12a.75.75 0 0 1 0 1.5h-12a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
            </svg>
        </button>
    
        {{-- Announcements Sidebar --}}
        <div 
            x-show="showSidebar"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 -translate-x-4"
            class="w-80 flex-shrink-0 p-1 z-40">
            @include('announcements._sidebar')
        </div>

        {{-- Main Content: Courses --}}
        <div class="flex-1 relative transition-all duration-300 pt-20">
            <h1 class="text-3xl font-extrabold mb-8 text-gray-800">
                My Courses
            </h1>

            @if ($classes->isEmpty())
                <div class="bg-white rounded-2xl shadow p-8 text-center">
                    <p class="text-gray-600 mb-6">You haven’t joined any classes yet.</p>
                    <button 
                        type="button"
                        @click="openModal = true"
                        class="inline-flex items-center px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg transition">
                        Join a Class
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
@foreach ($classes as $class)
    @php
        $pastels = ['#FFE5EC', '#E5F4FF', '#FFF6CC', '#E8FFD5', '#F3E8FF'];
        $footerBg = $pastels[array_rand($pastels)];
    @endphp

    <div class="relative">
        <!-- Dropdown Menu (Moved OUTSIDE anchor) -->
        <div x-data="{ open: false }" class="absolute top-3 right-3 z-50">
            <!-- Dots Icon -->
            <button 
                type="button"
                @click.stop="open = !open"
                class="text-gray-600 hover:text-gray-800 transition rounded-full p-1 hover:bg-gray-100">
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

            <!-- Dropdown -->
            <div 
                x-show="open"
                @click.away="open = false"
                x-transition
                class="absolute right-0 mt-2 w-28 bg-white border border-gray-200 rounded-lg shadow-md">
                <form id="leaveClassForm{{ $class->id }}" 
                      action="{{ url('/classes/' . $class->id . '/students/' . auth()->id()) }}" 
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to leave this class?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="block w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                        Leave Class
                    </button>
                </form>
            </div>
        </div>

        <!-- Clickable Card -->
        <a href="{{ route('classes.show', $class->id) }}" 
           class="block bg-[#CCE4FF] rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden">

            <!-- Card Content -->
            <div class="p-6 mb-2">
                <div class="text-xl font-extrabold text-[#3345AE] mb-2 uppercase">
                    {{ $class->name }}
                </div>
                <div class="text-gray-700 font-medium uppercase">
                    {{ $class->subject }}
                </div>
            </div>

            <!-- Footer -->
            <div class="px-3 py-3 text-sm font-bold text-gray-700" style="background-color: {{ $footerBg }};">
                <div>{{ $class->section ?? 'N/A' }}</div>
                <div>{{ $class->schedule ?? 'TBA' }}</div>
                <div>{{ $class->faculty?->name ?? '—' }}</div>
            </div>
        </a>
    </div>
@endforeach
</div>

            @endif  

            {{-- Floating Join Button --}}
            <button 
                type="button"
                @click="openModal = true"
                class="fixed bottom-6 right-6 bg-white hover:bg-blue-500 text-black hover:text-white rounded-full shadow-xl w-16 h-16 flex items-center justify-center text-4xl transition z-50">
                +
            </button>

            {{-- Join Class Modal --}}
            <div 
                x-show="openModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div 
                    @click.away="openModal = false" 
                    class="bg-white rounded-lg shadow-lg p-6 w-80">
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
                    <button 
                        type="button"
                        @click="openModal = false"
                        class="mt-4 w-full bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-lg">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
