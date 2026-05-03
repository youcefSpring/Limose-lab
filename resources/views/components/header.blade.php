<header id="header" class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4 sm:px-6 py-3 glass border-b border-black/5 dark:border-white/5 transition-all duration-300 lg:left-64 {{ app()->getLocale() === 'ar' ? 'lg:right-64' : '' }}">
    <!-- Hamburger menu -->
    <button type="button" 
            id="hamburger" 
            onclick="toggleSidebar()"
            class="p-2 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 transition-colors"
            aria-label="{{ __('Toggle menu') }}"
            aria-controls="sidebar"
            aria-expanded="false">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Spacer -->
    <div class="w-10 lg:hidden"></div>

    <!-- Right side actions -->
    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Language Switcher -->
        <div class="relative" x-data="{ open: false }">
            <button type="button" 
                    @click="open = !open" 
                    @click.outside="open = false"
                    class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-colors"
                    aria-label="{{ __('Select language') }}"
                    :aria-expanded="open">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                </svg>
                <span class="hidden sm:inline text-sm font-medium uppercase">{{ app()->getLocale() }}</span>
                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} top-full mt-2 w-40 glass-card rounded-xl shadow-lg overflow-hidden z-50"
                 style="display: none;">
                @foreach(['en' => 'English', 'fr' => 'Français', 'ar' => 'العربية'] as $code => $label)
                    <a href="{{ route('locale.switch', $code) }}" 
                       class="flex items-center gap-2 px-4 py-2.5 hover:bg-black/5 dark:hover:bg-white/5 transition-colors {{ app()->getLocale() === $code ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                        <span class="text-sm">{{ $label }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Theme Switcher -->
        <button type="button" 
                onclick="toggleTheme()" 
                class="p-2 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-colors" 
                title="{{ __('Toggle theme') }}"
                aria-label="{{ __('Toggle dark mode') }}">
            <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
            <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </button>

        <!-- User Menu -->
        <div class="relative" x-data="{ open: false }">
            <button type="button" 
                    @click="open = !open" 
                    @click.outside="open = false"
                    class="flex items-center gap-2 px-2 py-1.5 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-colors"
                    :aria-expanded="open">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent-amber to-accent-coral flex items-center justify-center text-white text-sm font-medium">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <span class="hidden md:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} top-full mt-2 w-56 glass-card rounded-xl shadow-lg overflow-hidden z-50"
                 style="display: none;">
                <div class="px-4 py-3 border-b border-black/5 dark:border-white/5">
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm">{{ __('Profile') }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-accent-rose hover:bg-accent-rose/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-sm">{{ __('Logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>