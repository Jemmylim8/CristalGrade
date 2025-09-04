<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-[#553FEE] to-[#288FD9] p-6">
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-5xl mx-auto">
            <h1 class="text-2xl font-bold mb-4">Year Level {{ $year_level }}</h1>

            <a href="{{ route('classes.create', ['year_level' => $year_level]) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                + Create Class
            </a>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @forelse($classes as $class)
                    <div class="bg-gray-100 p-4 rounded shadow">
                        <p class="font-semibold uppercase">{{ $class->subject }} - {{ $class->name }}</p>
                        <div class="mt-2 flex space-x-2">
                            <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-sm">Open</a>
                            <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-sm">Edit</a>
                            <form action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-gray-600">No classes in this year level yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
