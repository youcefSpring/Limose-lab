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

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
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
                background-image:
                    radial-gradient(ellipse 80% 50% at 20% -20%, rgba(245, 158, 11, 0.08), transparent),
                    radial-gradient(ellipse 60% 40% at 80% 100%, rgba(139, 92, 246, 0.06), transparent);
            }

            body {
                background: #f8fafc;
                background-image:
                    radial-gradient(ellipse 80% 50% at 20% -20%, rgba(245, 158, 11, 0.1), transparent),
                    radial-gradient(ellipse 60% 40% at 80% 100%, rgba(139, 92, 246, 0.08), transparent);
                transition: background 0.3s ease;
            }

            .dark .glass {
                background: rgba(26, 26, 37, 0.6);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }

            .glass {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(0, 0, 0, 0.05);
                transition: background 0.3s ease;
            }

            .dark .glass-card {
                background: linear-gradient(135deg, rgba(37, 37, 50, 0.8), rgba(26, 26, 37, 0.4));
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .glass-card {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 250, 252, 0.6));
                backdrop-filter: blur(10px);
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .glow-amber { box-shadow: 0 0 40px -10px rgba(245, 158, 11, 0.4); }
            .glow-violet { box-shadow: 0 0 40px -10px rgba(139, 92, 246, 0.4); }
            .glow-cyan { box-shadow: 0 0 40px -10px rgba(6, 182, 212, 0.4); }
            .glow-emerald { box-shadow: 0 0 40px -10px rgba(16, 185, 129, 0.4); }
            .glow-rose { box-shadow: 0 0 40px -10px rgba(244, 63, 94, 0.4); }

            .stat-card:hover { transform: translateY(-4px); }

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

            .dark .table-row:hover { background: rgba(255,255,255,0.02); }
            .table-row:hover { background: rgba(0,0,0,0.02); }

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

        <!-- Additional Styles -->
        @stack('styles')
    </head>
    <body class="min-h-screen text-zinc-800 dark:text-white overflow-x-hidden {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-outfit' }}">
        <div class="flex">
            <!-- Mobile Overlay -->
            <div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 bg-black/50 z-40 opacity-0 invisible" onclick="toggleSidebar()"></div>

            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Main Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <!-- Top Controls Bar -->
                <div class="flex items-center justify-between mb-6">
                    <!-- Hamburger Menu -->
                    <button id="hamburger" class="hamburger p-2 rounded-xl glass hover:glass-card transition-colors" onclick="toggleSidebar()">
                        <div class="w-5 h-5 flex flex-col justify-center gap-1.5">
                            <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
                            <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
                            <span class="hamburger-line block w-full h-0.5 bg-zinc-600 dark:bg-zinc-400 rounded-full"></span>
                        </div>
                    </button>

                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleTheme()" class="relative p-2.5 rounded-xl glass hover:glass-card transition-all">
                        <div class="relative w-5 h-5">
                            <svg class="w-5 h-5 text-accent-amber absolute inset-0 transition-all duration-500 dark:opacity-0 dark:rotate-90 dark:scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg class="w-5 h-5 text-accent-violet absolute inset-0 transition-all duration-500 opacity-0 -rotate-90 scale-0 dark:opacity-100 dark:rotate-0 dark:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </div>
                    </button>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6">
                        <div class="glass-card rounded-xl p-4 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-emerald">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-emerald {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6">
                        <div class="glass-card rounded-xl p-4 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-rose">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-rose {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('warning'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6">
                        <div class="glass-card rounded-xl p-4 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-amber">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-amber {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm">{{ session('warning') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                {{ $slot }}
            </main>
        </div>

        <!-- Scripts -->
        <script>
            // Initialize theme from localStorage or default to dark
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }

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

                sidebar.classList.toggle('-translate-x-full');
                @if(app()->getLocale() === 'ar')
                    sidebar.classList.toggle('translate-x-full');
                @endif
                hamburger.classList.toggle('active');

                if (sidebar.classList.contains('-translate-x-full') || sidebar.classList.contains('translate-x-full')) {
                    overlay.classList.add('opacity-0', 'invisible');
                    overlay.classList.remove('opacity-100', 'visible');
                } else {
                    overlay.classList.remove('opacity-0', 'invisible');
                    overlay.classList.add('opacity-100', 'visible');
                }
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full', 'translate-x-full');
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
