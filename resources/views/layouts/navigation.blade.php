<nav x-data="{
        open: false,
        profileOpen: false,
        grayscale: localStorage.getItem('grayscale') === 'true',
        dark: localStorage.getItem('darkMode') === 'true',
        apply() {
            document.documentElement.classList.toggle('grayscale', this.grayscale);
            document.documentElement.classList.toggle('dark', this.dark);
        }
     }"
     x-init="apply(); $watch('grayscale', v => { localStorage.setItem('grayscale', v); apply(); }); $watch('dark', v => { localStorage.setItem('darkMode', v); apply(); })"
     @keydown.escape.window="open = false; profileOpen = false"
     class="border-b border-[#DADDF4]/70 bg-white/75 pt-1 backdrop-blur-xl dark:border-white/10 dark:bg-[#14173D]/70">

    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[#4B4FE0]">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-[#4B4FE0] via-[#6A5CFF] to-[#7C8CFF] text-white shadow-lg shadow-[#4B4FE0]/30 transition duration-300 group-hover:rotate-6 group-hover:scale-105">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </span>
                    <span class="hidden text-lg font-extrabold tracking-tight text-[#171A44] dark:text-white sm:block">SME Nexus</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden items-center gap-1 sm:flex">
                    <a href="{{ route('dashboard') }}"
                       aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}"
                       class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#4B4FE0]
                              {{ request()->routeIs('dashboard')
                                    ? 'bg-[#4B4FE0]/10 text-[#4B4FE0] dark:bg-[#7C8CFF]/15 dark:text-[#AEB6FF]'
                                    : 'text-[#666B92] hover:bg-[#F6F7FF] hover:text-[#171A44] dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white' }}">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-3a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2">

                <!-- Dark Mode Toggle -->
                <button type="button" @click="dark = !dark"
                        :aria-pressed="dark"
                        :title="dark ? 'Mode Gelap: ON' : 'Mode Terang: ON'"
                        aria-label="Mode gelap/terang"
                        class="grid h-10 w-10 place-items-center rounded-xl ring-1 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#4B4FE0]"
                        :class="dark ? 'bg-[#171A44] text-white ring-[#171A44]' : 'bg-white text-[#666B92] ring-[#DADDF4] hover:text-[#171A44]'">
                    <svg x-show="!dark" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg x-show="dark" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Grayscale Toggle -->
                <button type="button" @click="grayscale = !grayscale"
                        :aria-pressed="grayscale"
                        :title="grayscale ? 'Mode Hitam Putih: ON' : 'Mode Hitam Putih: OFF'"
                        aria-label="Mode hitam putih"
                        class="grid h-10 w-10 place-items-center rounded-xl ring-1 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#4B4FE0]"
                        :class="grayscale ? 'bg-[#F6F7FF] text-[#171A44] ring-[#DADDF4] dark:bg-white/10 dark:text-white dark:ring-white/20' : 'bg-white text-[#666B92] ring-[#DADDF4] hover:text-[#171A44] dark:bg-transparent dark:text-gray-400 dark:ring-white/10 dark:hover:text-white'">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </button>

                <!-- Settings Dropdown -->
                <div class="relative" @click.outside="profileOpen = false">
                    <button @click="profileOpen = !profileOpen"
                            class="flex items-center gap-3 rounded-xl px-3 py-2 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#4B4FE0]"
                            :class="{ 'bg-[#F6F7FF] dark:bg-white/5': profileOpen }">
                        <!-- User Avatar -->
                        <div class="grid h-9 w-9 place-items-center rounded-lg bg-gradient-to-br from-[#4B4FE0] to-[#6A5CFF] text-sm font-bold text-white shadow-md">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden text-left md:block">
                            <div class="text-sm font-semibold text-[#171A44] dark:text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-[#666B92] dark:text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                        <svg class="h-4 w-4 text-[#666B92] transition-transform duration-200" :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="profileOpen"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-2 w-56 overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-[#DADDF4] dark:bg-[#14173D] dark:ring-white/10"
                         style="display: none;">
                        <div class="border-b border-[#DADDF4] bg-[#F6F7FF] px-4 py-3 dark:border-white/10 dark:bg-white/5">
                            <p class="text-sm font-semibold text-[#171A44] dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="truncate text-xs text-[#666B92] dark:text-gray-400">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#171A44] hover:bg-[#F6F7FF] dark:text-gray-300 dark:hover:bg-white/5">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profile') }}
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#171A44] hover:bg-[#F6F7FF] dark:text-gray-300 dark:hover:bg-white/5">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ __('Settings') }}
                            </a>
                        </div>
                        <div class="border-t border-[#DADDF4] py-1 dark:border-white/10">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Hamburger -->
                <button @click="open = !open"
                        class="grid h-10 w-10 place-items-center rounded-xl text-[#66692] ring-1 ring-[#DADDF4] transition hover:bg-[#F6F7FF] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#4B4FE0] dark:text-gray-400 dark:ring-white/10 dark:hover:bg-white/5 md:hidden"
                        :aria-expanded="open" aria-label="Menu">
                    <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-cloak class="border-t border-[#DADDF4] bg-white dark:border-white/10 dark:bg-[#14173D] md:hidden">
        <div class="space-y-1 px-4 py-3">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                      {{ request()->routeIs('dashboard')
                            ? 'bg-[#4B4FE0]/10 text-[#4B4FE0] dark:bg-[#7C8CFF]/15 dark:text-[#AEB6FF]'
                            : 'text-[#666B92] hover:bg-[#F6F7FF] dark:text-gray-300 dark:hover:bg-white/5' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-3a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" />
                </svg>
                {{ __('Dashboard') }}
            </a>
        </div>

        <div class="border-t border-[#DADDF4] px-4 py-3 dark:border-white/10">
            <div class="flex items-center gap-3 px-2 py-2">
                <div class="grid h-10 w-10 place-items-center rounded-lg bg-gradient-to-br from-[#4B4FE0] to-[#6A5CFF] text-sm font-bold text-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-[#171A44] dark:text-white">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-[#666B92] dark:text-gray-400">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="mt-2 space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm text-[#171A44] hover:bg-[#F6F7FF] dark:text-gray-300 dark:hover:bg-white/5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </a>

                <button @click="dark = !dark" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm text-[#171A44] hover:bg-[#F6F7FF] dark:text-gray-300 dark:hover:bg-white/5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span x-text="dark ? 'Mode Gelap: ON' : 'Mode Terang: ON'"></span>
                </button>

                <button @click="grayscale = !grayscale" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm text-[#171A44] hover:bg-[#F6F7FF] dark:text-gray-300 dark:hover:bg-white/5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    <span x-text="grayscale ? 'Mode Hitam Putih: ON' : 'Mode Hitam Putih: OFF'"></span>
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
