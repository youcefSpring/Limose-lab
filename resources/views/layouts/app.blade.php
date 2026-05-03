<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar']) ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'RLMS') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
        @if(app()->getLocale() === 'ar')
            <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
        @endif

        <!-- Styles (Tailwind CDN) -->
        <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                corePlugins: {
                    preflight: true,
                },
                theme: {
                    extend: {
                        fontFamily: {
                            'outfit': ['Outfit', 'sans-serif'],
                            'mono': ['Space Mono', 'monospace'],
                            'arabic': ['Cairo', 'sans-serif'],
                        },
                        colors: {
                            'surface': {
                                900: '#0a0a0f',
                                800: '#12121a',
                                700: '#1a1a25',
                                600: '#252532',
                            },
                            'accent': {
                                amber: '#f59e0b',
                                coral: '#f97316',
                                rose: '#f43f5e',
                                violet: '#8b5cf6',
                                cyan: '#06b6d4',
                                emerald: '#10b981',
                            }
                        }
                    }
                }
            }
        </script>
        <style>
            * { font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', sans-serif" : "'Outfit', sans-serif" }}; }

            .dark body {
                background: #0a0a0f;
            }

            body {
                background: #f8fafc;
            }

            .dark .glass {
                background: rgba(26, 26, 37, 0.8);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .glass {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            .dark .glass-card {
                background: linear-gradient(135deg, rgba(37, 37, 50, 0.9), rgba(26, 26, 37, 0.6));
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .glass-card {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.8));
                backdrop-filter: blur(10px);
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.1);
            }

            .glow-amber { box-shadow: 0 0 40px -10px rgba(245, 158, 11, 0.4); }
            .glow-violet { box-shadow: 0 0 40px -10px rgba(139, 92, 246, 0.4); }
            .glow-cyan { box-shadow: 0 0 40px -10px rgba(6, 182, 212, 0.4); }
            .glow-emerald { box-shadow: 0 0 40px -10px rgba(16, 185, 129, 0.4); }
            .glow-rose { box-shadow: 0 0 40px -10px rgba(244, 63, 94, 0.4); }

            .nav-item { position: relative; }
            .nav-item.active::before {
                content: '';
                position: absolute;
                {{ app()->getLocale() === 'ar' ? 'right' : 'left' }}: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 3px;
                height: 24px;
                background: linear-gradient(180deg, #f59e0b, #f97316);
                border-radius: {{ app()->getLocale() === 'ar' ? '4px 0 0 4px' : '0 4px 4px 0' }};
            }

            .sidebar { transition: transform 0.3s ease; }
            .sidebar-overlay { transition: opacity 0.3s ease, visibility 0.3s ease; }

            .hamburger-line { transition: all 0.3s ease; }
            .hamburger.active .hamburger-line:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
            .hamburger.active .hamburger-line:nth-child(2) { opacity: 0; }
            .hamburger.active .hamburger-line:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 3px; }
            .dark ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
        </style>

        @stack('styles')
    </head>
    <body class="min-h-screen text-zinc-800 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-outfit' }}">
        <!-- Mobile Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden opacity-0 invisible" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        @include('layouts.navigation')

        <!-- Header (spans full width) -->
        <header class="fixed top-0 left-0 right-0 lg:left-64 z-30 flex items-center justify-between px-4 sm:px-6 py-3 glass border-b border-black/5 dark:border-white/5">
                    <!-- Left: Hamburger + Title -->
                    <div class="flex items-center gap-3">
                        <button id="hamburger" class="hamburger lg:hidden p-2 rounded-lg hover:bg-black/5 dark:hover:bg-white/5" onclick="toggleSidebar()">
                            <div class="w-5 h-5 flex flex-col justify-center gap-1.5">
                                <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
                                <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
                                <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
                            </div>
                        </button>
                        <span class="text-xl font-semibold tracking-tight lg:hidden">{{ config('app.name', 'RLMS') }}</span>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <!-- Language Switcher -->
                        <div class="relative" x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                                <span class="hidden sm:inline text-sm font-medium uppercase">{{ app()->getLocale() }}</span>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} top-full mt-2 w-40 glass-card rounded-xl shadow-lg overflow-hidden z-50" style="display: none;">
                                @foreach(['en' => 'English', 'fr' => 'Français', 'ar' => 'العربية'] as $code => $label)
                                    <a href="{{ route('locale.switch', $code) }}" data-turbo="false" class="flex items-center gap-2 px-4 py-2.5 hover:bg-black/5 dark:hover:bg-white/5 transition-colors {{ app()->getLocale() === $code ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                                        <span class="text-sm">{{ $label }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Theme Switcher -->
                        <button type="button" onclick="toggleTheme()" class="p-2 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-colors" title="{{ __('messages.Toggle theme') }}">
                            <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="flex items-center gap-2 px-2 py-1.5 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-accent-amber to-accent-coral flex items-center justify-center text-white text-sm font-medium">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="hidden md:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} top-full mt-2 w-56 glass-card rounded-xl shadow-lg overflow-hidden z-50" style="display: none;">
                                <div class="px-4 py-3 border-b border-black/5 dark:border-white/5">
                                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-sm">{{ __('messages.Profile') }}</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-accent-rose hover:bg-accent-rose/10 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span class="text-sm">{{ __('messages.Logout') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <main id="main-content" class="flex-1 p-4 sm:p-6 lg:p-8 mt-16">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 glass-card rounded-xl border-l-4 border-accent-emerald">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-emerald mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 glass-card rounded-xl border-l-4 border-accent-rose">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-rose mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="mb-6 p-4 glass-card rounded-xl border-l-4 border-accent-amber">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-amber mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm">{{ session('warning') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    {{ $slot }}
                </main>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

        <script>
            // Initialize theme
            function initializeTheme() {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                }
            }
            initializeTheme();

            function toggleTheme() {
                const html = document.documentElement;
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }

            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                const hamburger = document.getElementById('hamburger');

                if (window.innerWidth >= 1024) {
                    return;
                }

                sidebar.classList.toggle('-translate-x-full');
                @if(app()->getLocale() === 'ar')
                    sidebar.classList.toggle('translate-x-full');
                @endif

                if (hamburger) hamburger.classList.toggle('active');

                if (sidebar.classList.contains('-translate-x-full') || sidebar.classList.contains('translate-x-full')) {
                    overlay.classList.add('opacity-0', 'invisible');
                    overlay.classList.remove('opacity-100', 'visible');
                } else {
                    overlay.classList.remove('opacity-0', 'invisible');
                    overlay.classList.add('opacity-100', 'visible');
                }
            }
        </script>
        @stack('scripts')
    </body>
</html>