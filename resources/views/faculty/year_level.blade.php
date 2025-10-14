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
                                <div class="flex flex-col">
                                    <span class="font-semibold text-gray-800">{{ $class->name }}</span>
                                    <span class="text-sm text-gray-500">Section: {{ $class->section ?? 'N/A' }}</span>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('classes.show', $class->id) }}" 
                                    class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600">
                                        Open
                                    </a>

                                    <a href="{{ route('classes.edit', $class->id) }}" 
                                    class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
