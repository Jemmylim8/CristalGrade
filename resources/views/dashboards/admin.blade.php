<x-app-layout>
    <div class="p-6">
        <h1 class="text-3xl font-bold text-blue-700">Admin Dashboard</h1>
        <p class="mt-4 text-gray-600">Welcome, System Administrator. Here you will manage faculty accounts and system settings.</p>
        <div class="space-x-4 mt-6">
            <a href="{{ route('admin.users.create', ['role' => 'faculty']) }}" 
                 class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    ➕ Create Faculty
            </a>

            <a href="{{ route('admin.users.create', ['role' => 'student']) }}" 
                 class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                     ➕ Create Student
            </a>
        </div>

        <!-- 🔘 Logout button -->
        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Logout
            </button>
        </form>
    </div>
</x-app-layout>
