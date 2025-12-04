{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CristalGrade - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 to-blue-400">

    <div class="grid grid-cols-1 md:grid-cols-2 w-full max-w-6xl mx-6 gap-6">

        {{-- LEFT SIDE --}}
        <div class="flex flex-col justify-center items-center text-center px-6 space-y-6 relative">
            {{-- Powered by --}}
            <div class="absolute top-6 left-6 flex items-center space-x-2">
                <span class="text-xs font-bold text-gray-800">POWERED BY:</span>
                <img src="{{ asset('images/stallion.png') }}" alt="Stallion Logo" class="h-10">
            </div>

            {{-- Welcome Text --}}
            <div class="space-y-2 mt-20">
                <p class="text-white text-lg tracking-widest font-semibold">– WELCOME –</p>
                <img src="{{ asset('images/logoSmall.png') }}" class="w-1668 h-618 mx-auto flex items-center" alt="CristalGrade Logo">
                <p class="text-white text-sm font-medium">Academic Year 2025-2026</p>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="bg-white p-10 rounded-3xl shadow-lg flex flex-col justify-center items-center space-y-6">
            {{-- Top Logos --}}
            <div class="flex justify-between items-center w-full mb-6">
                <img src="{{ asset('images/csd.png') }}" alt="Left Logo" class="w-16 h-16">
                <img src="{{ asset('images/cec.png') }}" alt="Right Logo" class="w-16 h-16">
            </div>

            {{-- Title --}}
            <h2 class="text-center text-xl font-semibold text-gray-800 mb-4">Welcome!</h2>
            <p class="text-center text-gray-600 mb-6">Access your student portal for grades, notifications, and more.</p>

            {{-- Learn More Button --}}
            <a href="https://sites.google.com/cec.edu.ph/stallion-dynamics/home"
                class="block w-full py-3 rounded-lg font-bold text-white text-center bg-gradient-to-r from-indigo-500 to-blue-500 hover:opacity-90 mb-4">
                LEARN MORE
            </a>

            {{-- Login & Register Buttons --}}
            <div class="space-y-4 w-full">
                <a href="{{ route('login') }}" 
                    class="block w-full py-3 rounded-lg font-bold text-white text-center bg-gradient-to-r from-blue-500 to-indigo-500 hover:opacity-90">
                    LOGIN
                </a>

                <a href="{{ route('register') }}" 
                    class="block w-full py-3 rounded-lg font-bold text-white text-center bg-gradient-to-r from-indigo-500 to-blue-500 hover:opacity-90">
                    REGISTER
                </a>
            </div>
        </div>
    </div>

    {{-- Debug badge --}}
    <div id="cg-debug" class="fixed bottom-3 left-3 bg-white/90 text-xs text-gray-800 px-2 py-1 rounded shadow z-50">
        CRISTALGRADE WELCOME PAGE
    </div>
</body>
</html>
