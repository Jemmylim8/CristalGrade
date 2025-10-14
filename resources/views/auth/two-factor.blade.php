{{-- resources/views/auth/two-factor.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CristalGrade - Two-Factor Authentication</title>
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
            <h2 class="text-center text-lg font-semibold text-gray-800 mb-6">TWO-FACTOR AUTHENTICATION</h2>

            {{-- Description --}}
            <p class="text-gray-600 mb-6 text-center">We sent a 6-digit code to your email. Please enter it below:</p>

            {{-- Global errors --}}
            @if ($errors->any())
                <div class="p-3 rounded-lg bg-red-50 border border-red-100 text-red-800 text-sm mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('two-factor.store') }}" class="space-y-4">
                @csrf

                <input type="text" name="two_factor_code" placeholder="Enter 6-digit code"
                    class="w-full rounded-lg border border-indigo-400 focus:ring-2 focus:ring-indigo-500 px-4 py-3 bg-gray-100 text-gray-700 placeholder-gray-400"
                    required
                >

                <button type="submit" 
                    class="w-full py-3 rounded-lg font-bold text-white bg-gradient-to-r from-blue-500 to-indigo-500 hover:opacity-90">
                         Verify Code
                </button>
            </form>

            {{-- Back to Login --}}
            <div class="mt-6 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="inline-block w-full py-3 rounded-lg font-bold text-white bg-gray-500 hover:bg-gray-600">
                         Back to Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Debug badge --}}
    <div id="cg-debug" class="fixed bottom-3 left-3 bg-white/90 text-xs text-gray-800 px-2 py-1 rounded shadow z-50">
        CRISTALGRADE TWO-FACTOR
    </div>
</body>
</html>
