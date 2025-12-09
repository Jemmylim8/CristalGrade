<x-app-layout>
    <a href="{{ route('dashboard') }}"
       class="w-16 h-16 flex items-center justify-center rounded-full border-2 border-white/80 text-white bg-blue-700 hover:bg-white hover:text-blue-700 transition-all duration-200 shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z"/>
        </svg>
    </a>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Profile Photo Upload Section (Centered) -->
            <h3 class="text-2xl font-semibold text-gray-900 mb-6 text-center">
                    {{ __('Profile Photo') }}
                </h3>
                
                <div class="flex flex-col items-center gap-6">
                    <!-- Profile Photo with Edit Icon -->
                    <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                        @csrf
                        <div class="relative group cursor-pointer">
                            <input type="file" name="profile_photo" id="photoInput" 
                                accept="image/*"
                                class="hidden"
                                onchange="document.getElementById('photoForm').submit()">
                            
                            <label for="photoInput" class="cursor-pointer">
                                @if(Auth::user()->profile_photo)
                                    <img 
                                        src="{{ asset('uploads/profile/' . Auth::user()->profile_photo) }}"
                                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-md group-hover:border-blue-500 transition-all duration-200"
                                        alt="User Avatar"
                                    />
                                @else
                                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center border-4 border-gray-200 shadow-md group-hover:border-blue-700 transition-all duration-200">
                                        <span class="text-4xl font-bold text-white">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                                
                                <!-- Edit Icon Overlay -->
                                <div class="absolute bottom-0 right-0 bg-blue-600 rounded-full p-2.5 shadow-lg group-hover:bg-blue-700 transition-all duration-200 border-4 border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </div>
                            </label>
                        </div>
                    </form>

                    <p class="text-sm text-gray-600 text-center max-w-md">
                        {{ __('Click the photo to upload a new one. JPG. Max size 2MB.') }}
                    </p>
                </div>
            
            <!-- Profile Information Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
                <header class="mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900">
                        {{ __('Profile Information') }}
                    </h3>
                    <p class="mt-2 text-base text-gray-500">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-medium text-base mb-2" />
                        <x-text-input id="name" name="name" type="text" 
                            class="block w-full rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 text-base py-4 px-5 focus:border-blue-500 focus:ring-0 focus:bg-white transition-all duration-200"
                            :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium text-base mb-2" />
                        <x-text-input id="email" name="email" type="email" 
                            class="block w-full rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 text-base py-4 px-5 focus:border-blue-500 focus:ring-0 focus:bg-white transition-all duration-200"
                            :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-3">
                                <p class="text-base text-gray-800">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification"
                                        class="underline text-base text-blue-600 hover:text-blue-800">
                                        {{ __('Click here to re-send verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-base text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium text-base rounded-lg transition-colors duration-200">
                            {{ __('Save') }}
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-base text-green-600 font-medium">
                                {{ __('Saved.') }}
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Update Password Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
                <header class="mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900">
                        {{ __('Update Password') }}
                    </h3>
                    <p class="mt-2 text-base text-gray-500">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700 font-medium text-base mb-2" />
                        <x-text-input id="update_password_current_password" name="current_password" type="password"
                            class="block w-full rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 text-base py-4 px-5 focus:border-blue-500 focus:ring-0 focus:bg-white transition-all duration-200"
                            autocomplete="current-password" />
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
                    </div>

                    <div>
                        <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700 font-medium text-base mb-2" />
                        <x-text-input id="update_password_password" name="password" type="password"
                            class="block w-full rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 text-base py-4 px-5 focus:border-blue-500 focus:ring-0 focus:bg-white transition-all duration-200"
                            autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
                    </div>

                    <div>
                        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium text-base mb-2" />
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                            type="password" 
                            class="block w-full rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 text-base py-4 px-5 focus:border-blue-500 focus:ring-0 focus:bg-white transition-all duration-200"
                            autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium text-base rounded-lg transition-colors duration-200">
                            {{ __('Save') }}
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-base text-green-600 font-medium">
                                {{ __('Saved.') }}
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Delete Account Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <header class="mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900">
                        {{ __('Delete Account') }}
                    </h3>
                    <p class="mt-2 text-base text-gray-500">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                    </p>
                </header>

                <button type="button" x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-medium text-base rounded-lg transition-colors duration-200">
                    {{ __('Delete Account') }}
                </button>

                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
                        @csrf
                        @method('delete')

                        <div class="text-center mb-6">
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ __('Delete Account?') }}
                            </h2>

                            <p class="text-base text-gray-600 max-w-md mx-auto">
                                {{ __('This action cannot be undone. All your data will be permanently removed from our servers forever.') }}
                            </p>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="password" value="{{ __('Confirm your password') }}" class="text-gray-700 font-medium text-base mb-2" />
                            <x-text-input id="password" name="password" type="password"
                                class="block w-full rounded-xl border-2 border-gray-200 bg-gray-50 text-gray-900 text-base py-4 px-5 focus:border-red-500 focus:ring-0 focus:bg-white transition-all duration-200"
                                placeholder="{{ __('Enter your password') }}" />
                            <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')"
                                class="w-full sm:w-auto px-8 py-3 bg-white border-2 border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold text-base rounded-xl transition-all duration-200">
                                {{ __('Cancel') }}
                            </button>

                            <button type="submit"
                                class="w-full sm:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold text-base rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                {{ __('Yes, Delete My Account') }}
                            </button>
                        </div>
                    </form>
                </x-modal>
            </div>

        </div>
    </div>
</x-app-layout>