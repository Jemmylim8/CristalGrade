<x-app-layout>
    @if (session('success'))
    <div role="alert" class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-md">
        {{ session('success') }}
    </div>
@endif
    <div x-data="{ openModal: false }" x-cloak 
         class="min-h-screen p-8 flex justify-center">

        <!-- Main White Container -->
        <div >

            <!-- Year Level Boxes Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
                                <p class="text-white-100 text-sm italic">No classes yet.</p>
                            @endforelse
                        </div>
                    </div>
                @endfor
            </div>
        

        <!-- Floating Create Button -->
        <button @click="openModal = true"
            class="fixed bottom-6 right-6 bg-[#3B82F6] hover:bg-[#2563EB] text-white rounded-full shadow-xl w-16 h-16 flex items-center justify-center text-4xl transition">
            +
        </button>

        <!-- Year Level Modal -->
        <div x-show="openModal" x-transition.opacity
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
    
    <script>
        setTimeout(() => {
            const alert = document.querySelector('[role="alert"]');
            if (alert) alert.remove();
        }, 3000);
    </script>

</x-app-layout>
