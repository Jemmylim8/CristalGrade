<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Year {{ $year_level }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-medium mb-4">Your Classes</h3>

                @if($classes->isEmpty())
                    <p>No classes found for this year.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($classes as $class)
                            <li class="flex justify-between items-center py-2">
                                <span>{{ $class->name }}</span>
                                <a href="{{ route('classes.show', $class->id) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600">
                                    Open Class
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
