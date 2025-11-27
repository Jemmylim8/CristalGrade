<x-app-layout>

    <!-- Back Button -->
    <a href="{{ route('dashboard') }}"
        class="w-16 h-16 flex items-center justify-center rounded-full border-2 border-white/80 bg-blue-700 text-white hover:bg-white hover:text-blue-700 transition-all duration-200 shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" />
        </svg>
    </a>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- PAGE TITLE -->
            <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-10 tracking-tight">
                Profile Settings
            </h2>

            <!-- ========================== -->
            <!-- ⭐ PROFILE INFORMATION CARD -->
            <!-- ========================== -->
            <div class="bg-white shadow-xl rounded-2xl p-10 mb-10 border border-gray-200">
                <header class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">Profile Information</h3>
                    <p class="mt-2 text-gray-600">
                        Update your name, email, or account details.
                    </p>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Name" class="font-medium text-gray-900" />
                        <x-text-input id="name" name="name" type="text"
                            class="mt-2 w-full rounded-xl border-gray-300 bg-gray-300 px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                            :value="old('name', $user->name)" required autocomplete="name" />
                        <x-input-error class="mt-1" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" value="Email" class="font-medium text-gray-900" />
                        <x-text-input id="email" name="email" type="email"
                            class="mt-2 w-full rounded-xl border-gray-300 bg-gray-300 px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                            :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-1" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="mt-3">
                                <p class="text-gray-700">
                                    Your email is unverified.
                                    <button form="send-verification"
                                        class="underline text-blue-600 hover:text-blue-800 font-medium">
                                        Re-send verification email.
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-1 font-medium text-green-600">
                                        A new verification link has been sent!
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Save -->
                    <div class="flex items-center gap-4">
                        <button type="submit"
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-md font-semibold transition">
                            Save
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show:true }" x-show="show" x-transition
                                x-init="setTimeout(() => show=false, 2000)"
                                class="text-green-600 font-medium">
                                Saved.
                            </p>
                        @endif
                    </div>
                </form>

                <!-- Profile Photo Upload -->
                <div class="mt-10 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900">Profile Photo</h3>

                    <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="profile_photo"
                            class="block w-full text-gray-700
                                   file:mr-4 file:px-6 file:py-3
                                   file:rounded-lg file:border-0
                                   file:bg-blue-50 file:text-blue-700
                                   hover:file:bg-blue-100 cursor-pointer" required>

                        <button type="submit"
                            class="mt-4 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition">
                            Upload
                        </button>
                    </form>
                </div>
            </div>

            <!-- ========================== -->
            <!-- 🔐 UPDATE PASSWORD CARD -->
            <!-- ========================== -->
            <div class="bg-white shadow-xl rounded-2xl p-10 mb-10 border border-gray-200 backdrop-blur-xl">

                <header class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        Update Password
                    </h2>
                    <p class="mt-2 text-gray-600">
                        Use a strong and unique password for better security.
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="space-y-7">
                    @csrf
                    @method('put')

                    <!-- Current Password -->
                    <div>
                        <x-input-label for="update_password_current_password" value="Current Password" class="font-medium text-gray-900" />

                        <div x-data="{ show: false }" class="relative">
                            <input :type="show ? 'text' : 'password'"
                                id="update_password_current_password"
                                name="current_password"
                                required autocomplete="current-password"
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-200 px-4 py-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">

                            <!-- Toggle -->
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-700 hover:text-gray-900">

                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 
                                        2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 
                                        0-8.268-2.943-9.542-7z" />
                                </svg>

                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                                        0-8.268-2.943-9.543-7a9.97 
                                        9.97 0 012.277-4.396M9.88 
                                        9.88a3 3 0 104.24 4.24" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        <x-input-error class="mt-1" :messages="$errors->updatePassword->get('current_password')" />
                    </div>

                    <!-- New Password -->
                    <div>
                        <x-input-label for="update_password_password" value="New Password" class="font-medium text-gray-900" />

                        <div x-data="{ show: false }" class="relative">
                            <input :type="show ? 'text' : 'password'"
                                id="update_password_password" name="password" required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-200 px-4 py-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-700 hover:text-gray-900">

                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 
                                        0 8.268 2.943 9.542 7-1.274 4.057-5.065 
                                        7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                                        0-8.268-2.943-9.543-7a9.97 
                                        9.97 0 012.277-4.396M9.88 
                                        9.88a3 3 0 104.24 4.24" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        <x-input-error class="mt-1" :messages="$errors->updatePassword->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="update_password_password_confirmation" value="Confirm Password" class="font-medium text-gray-900" />

                        <div x-data="{ show: false }" class="relative">
                            <input :type="show ? 'text' : 'password'"
                                id="update_password_password_confirmation"
                                name="password_confirmation" required
                                class="mt-2 w-full rounded-xl border-gray-300 bg-gray-200 px-4 py-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500">

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-700 hover:text-gray-900">

                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 
                                        0 8.268 2.943 9.542 7-1.274 4.057-5.065 
                                        7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                                        0-8.268-2.943-9.543-7a9.97 
                                        9.97 0 012.277-4.396M9.88 
                                        9.88a3 3 0 104.24 4.24" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        <x-input-error class="mt-1" :messages="$errors->updatePassword->get('password_confirmation')" />
                    </div>

                    <!-- Save -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit"
                            class="px-7 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition">
                            Save Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show:true }" x-show="show" x-transition x-cloak
                                x-init="setTimeout(() => show=false, 2500)"
                                class="text-green-600 font-medium">
                                Saved.
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- ========================== -->
            <!-- ❌ DELETE ACCOUNT CARD -->
            <!-- ========================== -->
            <div class="bg-white shadow-xl rounded-2xl p-10 border border-gray-200">
                <header class="mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Delete Account</h3>
                    <p class="mt-2 text-gray-600">
                        Once your account is deleted, all of its data will be permanently lost.
                    </p>
                </header>

                <x-danger-button x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition">
                    Delete Account
                </x-danger-button>

                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')

                        <h2 class="text-xl font-semibold text-gray-900">
                            Confirm Account Deletion
                        </h2>

                        <p class="mt-1 text-gray-600">
                            This action is permanent. Please enter your password to continue.
                        </p>

                        <div class="mt-6">
                            <div x-data="{ show: false }" class="relative w-3/4">
                                <input :type="show ? 'text' : 'password'"
                                    id="password"
                                    name="password"
                                    required
                                    class="w-full rounded-xl border-gray-300 bg-gray-300 px-4 py-3 text-gray-700 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Password">

                                <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-3 flex items-center text-gray-700 hover:text-gray-900">

                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 
                                            0 8.268 2.943 9.542 7-1.274 
                                            4.057-5.065 7-9.542 7-4.477 
                                            0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                                            0-8.268-2.943-9.543-7a9.97 
                                            9.97 0 012.277-4.396M9.88 
                                            9.88a3 3 0 104.24 4.24" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>

                            <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <x-secondary-button x-on:click="$dispatch('close')"
                                class="px-8 py-3 bg-gray-200 hover:bg-gray-300 rounded-xl font-semibold text-gray-800 transition">
                                Cancel
                            </x-secondary-button>

                            <x-danger-button
                                class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition">
                                Delete Account
                            </x-danger-button>
                        </div>
                    </form>
                </x-modal>
            </div>

        </div>
    </div>
</x-app-layout>