<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Card -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 space-y-6">
                <!-- Title -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 tracking-wide">
                        {{ __('PASSWORD RESET') }}
                    </h2>
                </div>

                <!-- Info Text -->
                <div class="mb-6 text-sm text-gray-600 text-center px-2">
                    {{ __('Enter your email address and we will send you a password reset link.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('EMAIL')" class="sr-only" />
                        <x-text-input 
                            id="email" 
                            class="block w-full px-4 py-3.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-gray-700 placeholder-gray-400" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            placeholder="EMAIL"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="space-y-3 pt-2">
                        <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-500 to-indigo-500 hover:opacity-90 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-[1.02] shadow-lg uppercase tracking-wide">
                            {{ __('Send Reset Link') }}
                        </button>
                        <!-- Back to Login -->
                        <div class="text-center pt-2">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{ __('Back to Login') }}
                        </a>
                    </div>
                    </div>
                </form>
            </div>

            <!-- Footer Text -->
            <div class="text-center mt-6 text-white text-sm opacity-90">
                {{ __('CristalGrade™ 2025') }}
            </div>
        </div>
    </div>
</x-guest-layout>