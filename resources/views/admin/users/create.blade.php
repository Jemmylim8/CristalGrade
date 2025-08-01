<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New User (Faculty or Student)') }}
        </h2>
    </x-slot>
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
            <strong>There were some issues with your input:</strong>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700">Name</label>
                    <input type="text" name="name" class="w-full border rounded p-2" required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full border rounded p-2" required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full border rounded p-2" required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Role</label>
                    <select name="role"class="w-full border rounded p-2" required>
                        <option value="faculty" {{ (isset($role) && $role == 'faculty') ? 'selected' : '' }}>Faculty</option>
                        <option value="student" {{ (isset($role) && $role == 'student') ? 'selected' : '' }}>Student</option>
                    </select>
                     @error('role')
                     <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                     @enderror
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Create User
                </button>
            </form>
            <div class="mt-4">
                <a href="{{ route('admin.dashboard') }}" 
                 class="inline-block px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md">
                 ← Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
