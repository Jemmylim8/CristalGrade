<x-app-layout>
    <div class="p-6">
        <h1 class="text-3xl font-bold text-green-700">Faculty Dashboard</h1>
        <p class="mt-4 text-gray-600">Welcome, Faculty Member. You can create classes, manage subjects, and input student scores here.</p>

        <!-- 🔘 Logout button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>
</x-app-layout>
