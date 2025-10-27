{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CristalGrade</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 to-blue-400">

    <div class="grid grid-cols-1 md:grid-cols-2 w-full max-w-6xl mx-6 bg-transparent">

        {{-- LEFT SIDE --}}
        <div class="flex flex-col justify-center items-center text-center px-6 space-y-6 relative">
            {{-- Powered by --}}
            <div class="absolute top-6 left-6 flex items-center space-x-2">
                <span class="text-xs font-bold text-gray-800">POWERED BY:</span>
                <img src="{{ asset('images/stallion.png') }}" alt="Stallion Logo" class="h-10">
            </div>

            {{-- Welcome Text --}}
            <div class="space-y-2 mt-20">
                <p class="text-white text-lg tracking-widest">– WELCOME –</p>
                <img src="{{ asset('images/logoSmall.png') }}" class="w-1668 h-618 mx-auto flex items-center">
                <p class="text-white text-sm">2024-2025</p>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="bg-white p-10 rounded-3xl shadow-lg relative">
            {{-- Top Logos --}}
            <div class="flex justify-between items-center mb-6">
                <img src="{{ asset('images/csd.png') }}" alt="Left Logo" class="w-16 h-16">
                <img src="{{ asset('images/cec.png') }}" alt="Right Logo" class="w-16 h-16">
            </div>

            {{-- Title --}}
            <h2 class="text-center text-lg font-semibold text-gray-800 mb-6">STUDENTS ACCESS MODULE</h2>

            {{-- Form --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Global success (e.g. password reset link) --}}
                @if (session('status'))
                    <div class="p-3 rounded-lg bg-green-50 border border-green-100 text-green-800 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Global error (invalid credentials) --}}
                @if ($errors->has('email') || $errors->has('password'))
                    <div class="p-3 rounded-lg bg-red-50 border border-red-100 text-red-800 text-sm">
                        {{ $errors->first() ?: 'Invalid credentials, please try again.' }}
                    </div>
                @endif

                {{-- Email --}}
                <div>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="GMAIL"
                        value="{{ old('email') }}"
                        class="w-full rounded-lg border border-indigo-400 focus:ring-2 focus:ring-indigo-500 px-4 py-3 bg-gray-100 text-gray-700 placeholder-gray-400"
                        required
                        autofocus
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="relative">
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="PASSWORD"
                        class="w-full rounded-lg border border-indigo-400 focus:ring-2 focus:ring-indigo-500 px-4 py-3 bg-gray-100 text-gray-700 placeholder-gray-400"
                        required
                    >
                    <button type="button" onclick="togglePassword()" 
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        👁️
                    </button>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Forgot Password --}}
                <div class="text-right">
                    <a href="{{ route('password.request') }}" class="text-sm text-cyan-500 hover:underline">
                        Forgot Password?
                    </a>
                </div>

                {{-- Buttons --}}
                <div class="space-y-3">
                    <button type="submit" class="w-full py-3 rounded-lg font-bold text-white bg-gradient-to-r from-blue-500 to-indigo-500 hover:opacity-90">
                        LOG-IN
                    </button>

                    <a href="{{ route('register') }}" class="block w-full text-center py-3 rounded-lg font-bold text-white bg-gradient-to-r from-indigo-500 to-blue-500 hover:opacity-90">
                        REGISTER
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- DEBUG BADGE — remove after you confirm the new view loads --}}
    <div id="cg-debug" class="fixed bottom-3 left-3 bg-white/90 text-xs text-gray-800 px-2 py-1 rounded shadow z-50">
        CRISTALGRADE NEW LOGIN
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
        // quick check if tailwind script loaded
        if (typeof window.tailwind === 'undefined') {
            // Not always available — just warn in console for debugging
            console.warn('Tailwind CDN may not be loaded.');
        }
    </script>
</body>
</html>
