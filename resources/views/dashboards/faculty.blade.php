<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Faculty Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @for ($year = 1; $year <= 4; $year++)
                @php
                    $colors = [
                        1 => 'bg-blue-100 border-blue-300',
                        2 => 'bg-green-100 border-green-300',
                        3 => 'bg-yellow-100 border-yellow-300',
                        4 => 'bg-orange-100 border-orange-300',
                    ];
                @endphp

                <!-- Entire Year Box is Clickable -->
                <a href="{{ url('/faculty/year/' . $year) }}" class="block">
                    <div class="rounded-2xl border-2 {{ str_replace('bg-', 'border-', $colors[$year]) }} bg-white p-5 shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
                        <h2 class="text-xl font-bold mb-4 text-gray-800">Year {{ $year }}</h2>

                        <!-- Subject Rectangles -->
                        <div class="flex flex-wrap gap-2">
                            @forelse ($classes->where('year_level', $year)->take(6) as $class)
                                <div class="px-3 py-2 text-sm font-medium text-gray-700 rounded-md shadow-sm border {{ $colors[$year] }}">
                                    {{ strtoupper($class->subject) }} - {{ strtoupper($class->name) }}
                                </div>
                            @empty
                                <p class="text-gray-400 text-sm italic">No classes yet.</p>
                            @endforelse
                        </div>

                        <!-- Create Button at bottom -->
                        <div class="mt-4">
                            <a href="{{ route('classes.create') }}?year={{ $year }}"
                               class="inline-flex items-center px-3 py-1.5 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow">
                                ➕ Create Class
                            </a>
                        </div>
                    </div>
                </a>
            @endfor
        </div>
    </div>
</x-app-layout>
