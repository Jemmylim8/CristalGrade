<x-app-layout>
    <div class="p-6">
        <h1 class="text-3xl font-bold text-purple-700">Student Dashboard</h1>
        <p class="mt-4 text-gray-600">Welcome, Student. You can view your subjects, activities, and exam scores here.</p>

        <!-- 🔘 Logout button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>
</x-app-layout>

<x-app-layout>
    <h2 class="text-lg font-bold mb-4">Join a Class</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-2">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-2">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classes.join') }}" method="POST">
        @csrf
        <input type="text" name="join_code" placeholder="Enter class code"
               class="border p-2 rounded w-64">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Join</button>
    </form>
</x-app-layout>
