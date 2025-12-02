<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    @if (session('success'))
    <div role="alert" class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-md">
        {{ session('success') }}
    </div>
    @endif
    <style>[x-cloak]{display:none!important;}</style>
    <div x-data="{ openModal: false, showSidebar: true }" x-cloak 
         class="min-h-screen p-8 flex gap-6 relative">

        {{-- Toggle Button for Announcements Sidebar --}}
        <button 
            @click="showSidebar = !showSidebar"
            class="absolute top-6 left-6 bg-[#EDEDED] hover:bg-blue-700 text-black hover:text-white  px-4 py-2 rounded shadow transition z-50 flex items-center gap-2"
            title="Toggle Announcements Sidebar">
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

        {{-- Main Content --}}
        <div class="flex-1 transition-all duration-300">
            
            <!-- Year Level Boxes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-16">
                @for ($year = 1; $year <= 4; $year++)
                    @php
                        $yearGradients = [
                            1 => '#CCE4FF',
                            2 => '#F5FFCC',
                            3 => '#C4FFD1',
                            4 => '#DAC8FF',
                        ];
                        $yearText = [
                            1 => '#3345AE',
                            2 => '#867731',
                            3 => '#317B46',
                            4 => '#6C349A',
                        ];
                    @endphp

                    <!-- Year Level Card -->
                    <div onclick="window.location='{{ route('faculty.yearLevel', $year) }}'"
                         class="rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 cursor-pointer 
                                bg-[#553FEE] p-6 ">
                        
                        <h2 class="text-xl text-center text-[#F1F1F1] font-bold mb-3 drop-shadow">
                            YEAR {{ $year }} 
                        </h2>
                        <p class ="text-center font-bold text-[#F1F1F1] mb-2" >COURSES</p>
                        

                        <!-- Subject Pills -->
                        <div class="flex flex-wrap gap-2">
                            @forelse ($classes->where('year_level', $year)->take(6) as $class)
                                <div style="background-color: {{ $yearGradients[$year] }}; color: {{ $yearText[$year] }};"
                                    class="px-3 py-2 text-sm font-semibold rounded-lg shadow">
                                    {{ strtoupper($class->subject) }} - {{ strtoupper($class->name) }}
                                </div>
                            @empty
                                <p class="text-black text-sm">- No classes yet.</p>
                            @endforelse
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Floating Create Button -->
            <!-- Floating Create Button -->
            <button @click="openModal = true"
                class="fixed bottom-6 right-6 bg-white hover:bg-blue-500 text-black hover:text-white rounded-full shadow-xl w-20 h-20 flex items-center justify-center transition z-50"
                title="Add Course">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke-width="2" 
                    stroke="currentColor" 
                    class="w-10 h-10">
                    <path stroke-linecap="round" 
                        stroke-linejoin="round" 
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>

            <!-- Year Level Modal -->
            <div x-show="openModal" x-transition.opacity x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div @click.away="openModal = false" class="bg-white rounded-lg shadow-lg p-6 w-80">
                    <h2 class="text-lg font-bold mb-4 text-center">Select Year Level</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @for ($year = 1; $year <= 4; $year++)
                            <a href="{{ route('classes.create') }}?year={{ $year }}"
                               class="block bg-[#3B82F6] hover:bg-[#2563EB] text-white py-3 rounded-lg text-center font-bold">
                                Year {{ $year }}
                            </a>
                        @endfor
                    </div>
                    <button @click="openModal = false"
                            class="mt-4 w-full bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-lg">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Auto-Remove Success Alert --}}
    <script>
        setTimeout(() => {
            const alert = document.querySelector('[role="alert"]');
            if (alert) alert.remove();
        }, 3000);
    </script>
</x-app-layout>
