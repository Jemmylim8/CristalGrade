<nav x-data="{ open: false }" class="bg-transparent backdrop-blur-sm border-b border-transparent">
    <!-- Primary Navigation Menu -->
    <div class="max-w-8xl mx-auto px-6 sm:px-8 lg:px-10 relative">
        <div class="flex items-center justify-between h-16">

            <!-- Left Logo -->
            <div class="flex items-center shrink-0">
                <img src="{{ asset('images/csd.png') }}" alt="Left Logo" class="w-14 h-14">
            </div>

            <!-- Center Logo (CristalGrade) -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/cristalgrades.png') }}" 
                        alt="CristalGrade Logo" 
                        class="h-28 hover:opacity-80 transition duration-300 ease-in-out">
                </a>
            </div>

            <!-- Right Side (Profile Dropdown) -->
            <div class="hidden sm:flex sm:items-center space-x-3">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-gray-100 hover:text-white focus:outline-none transition space-x-3"
                        >
                            <div class="flex flex-col items-end text-right">
                                <span class="font-extrabold uppercase text-sm tracking-wide">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    {{ Auth::user()->email }}
                                </span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <img 
                                    src="{{ Auth::user()->profile_photo 
                                           ? asset('uploads/profile/' . Auth::user()->profile_photo)
                                        : asset('images/profile.png') }}"
                                    class="w-10 h-10 rounded-full object-cover"
                                    alt="User Avatar"
                                />

                                <svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger for Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-transparent backdrop-blur-md">
        <div class="pt-2 pb-3 flex justify-center">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings -->
        <div class="pt-4 pb-1 border-t border-transparent flex flex-col items-center">
            <div class="px-4 text-center">
                <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 text-center">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>