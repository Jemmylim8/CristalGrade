<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Faculty Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @for ($year = 1; $year <= 4; $year++)
                @php
                    $colors = [
                        1 => 'border-blue-300 bg-blue-50 hover:bg-blue-100',
                        2 => 'border-green-300 bg-green-50 hover:bg-green-100',
                        3 => 'border-yellow-300 bg-yellow-50 hover:bg-yellow-100',
                        4 => 'border-orange-300 bg-orange-50 hover:bg-orange-100',
                    ];
                @endphp

                <div class="rounded-xl border {{ $colors[$year] }} p-6 shadow-sm hover:shadow-lg transition transform hover:-translate-y-1">
                    <h2 class="text-lg font-semibold mb-4 text-gray-700">
                        Year {{ $year }}
                    </h2>

                    <ul class="space-y-2 mb-4">
                        @forelse ($classes->where('year_level', $year)->take(3) as $class)
                            <li class="text-sm text-gray-600">{{ $class->subject }} - {{ $class->section }}</li>
                        @empty
                            <li class="text-gray-400 text-sm italic">No classes yet.</li>
                        @endforelse
                    </ul>

                    <div class="flex space-x-2">
                        <a href="{{ route('classes.create') }}?year={{ $year }}"
                           class="px-3 py-1.5 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow">
                            + Create Class
                        </a>
                        <a href="#"
                           class="px-3 py-1.5 text-sm text-blue-600 hover:text-blue-700">
                            View All
                        </a>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</x-app-layout>
