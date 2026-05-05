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

        <!-- Turbo for SPA-like navigation -->
        <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-umd.js"></script>

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
                                900: '#18181b',
                                800: '#27272a',
                                700: '#3f3f46',
                                600: '#52525b',
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
                background: #18181b;
                background-image:
                    radial-gradient(ellipse 80% 50% at 20% -20%, rgba(245, 158, 11, 0.05), transparent),
                    radial-gradient(ellipse 60% 40% at 80% 100%, rgba(139, 92, 246, 0.04), transparent);
            }

            body {
                background: #f8fafc;
                background-image:
                    radial-gradient(ellipse 80% 50% at 20% -20%, rgba(245, 158, 11, 0.08), transparent),
                    radial-gradient(ellipse 60% 40% at 80% 100%, rgba(139, 92, 246, 0.05), transparent);
                transition: background 0.3s ease;
            }

            .dark .glass {
                background: rgba(39, 39, 42, 0.7);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .glass {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(0, 0, 0, 0.05);
                transition: background 0.3s ease;
            }

            .dark .glass-card {
                background: linear-gradient(135deg, rgba(63, 63, 70, 0.7), rgba(39, 39, 42, 0.5));
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .glass-card {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.8));
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

            /* Sidebar transitions */
            .sidebar {
                transition: transform 0.3s ease-in-out;
            }
            
            /* Sidebar hidden states - LTR */
            .sidebar.sidebar-hidden {
                transform: translateX(-100%);
            }
            
            /* Sidebar hidden states - RTL */
            [dir="rtl"] .sidebar.sidebar-hidden {
                transform: translateX(100%);
            }
            
            @media (min-width: 1024px) {
                .sidebar.sidebar-hidden {
                    width: 0 !important;
                    min-width: 0 !important;
                    overflow: hidden;
                    opacity: 0;
                }
            }
            
            /* RTL Layout - Sidebar should stay on right but hidden */
            @media (min-width: 1024px) {
                [dir="rtl"] .sidebar.sidebar-hidden {
                    width: 0 !important;
                    min-width: 0 !important;
                    overflow: hidden;
                    opacity: 0;
                }
            }
            
            /* Overlay transitions */
            .sidebar-overlay {
                transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
            }

            /* Body scroll lock for mobile */
            body.sidebar-open {
                overflow: hidden;
            }

            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 3px; }
            .dark ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
        </style>

        <!-- Additional Styles -->
        @stack('styles')
    </head>
    <body class="min-h-screen text-zinc-800 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-outfit' }}">
        <!-- Global Loader -->
        <div id="global-loader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-zinc-50 dark:bg-[#18181b] transition-all duration-500">
            <div class="flex flex-col items-center gap-4">
                <div class="relative w-16 h-16">
                    <div class="absolute inset-0 rounded-full border-4 border-accent-amber/10"></div>
                    <div class="absolute inset-0 rounded-full border-4 border-t-accent-amber animate-spin"></div>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="text-sm font-medium tracking-wider uppercase text-zinc-500 animate-pulse">{{ config('app.name', 'RLMS') }}</span>
                </div>
            </div>
        </div>

        <div class="flex min-h-screen">
            <!-- Mobile Overlay -->
            <div id="sidebar-overlay" 
                 class="sidebar-overlay fixed inset-0 bg-black/50 z-30 lg:hidden opacity-0 invisible"
                 aria-hidden="true"
                 onclick="toggleSidebar()">
            </div>

            <!-- Sidebar -->
            @include('layouts.navigation')

            <!-- Header -->
            @include('components.header')

            <!-- Main Content -->
            <main class="flex-1 min-h-screen pt-16 lg:pt-20 transition-all duration-300 {{ app()->getLocale() === 'ar' ? 'lg:mr-64' : 'lg:ml-64' }}">
                <div class="p-4 sm:p-6 lg:p-8">
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
                </div>
            </main>
        </div>

        <!-- Alpine.js and Axios -->
        <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

        <!-- Scripts -->
        <script>
            // Global Loader Handler
            window.addEventListener('load', () => {
                const loader = document.getElementById('global-loader');
                if (loader) {
                    loader.classList.add('opacity-0', 'invisible');
                    setTimeout(() => loader.remove(), 500);
                }
            });

            // Turbo Compatibility
            document.addEventListener('turbo:load', () => {
                const loader = document.getElementById('global-loader');
                if (loader) {
                    loader.classList.add('opacity-0', 'invisible');
                    setTimeout(() => {
                        if (loader.parentNode) loader.remove();
                    }, 500);
                }
            });

            // Initialize theme
            (function() {
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (saved === 'dark' || (!saved && prefersDark)) {
                    document.documentElement.classList.add('dark');
                }
            })();

            // Toggle theme
            function toggleTheme() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            }
            window.toggleTheme = toggleTheme;

            // Initialize sidebar
            (function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.querySelector('main');
                const header = document.getElementById('header');
                const isRtl = document.documentElement.dir === 'rtl';
                
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('sidebar-hidden');
                    if (isRtl) {
                        mainContent.classList.add('lg:mr-64');
                        header.classList.add('lg:right-64');
                    } else {
                        mainContent.classList.add('lg:ml-64');
                        header.classList.add('lg:left-64');
                    }
                } else {
                    sidebar.classList.add('sidebar-hidden');
                }
            })();

            // Toggle sidebar
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const isRtl = document.documentElement.dir === 'rtl';
                const mainContent = document.querySelector('main');
                const header = document.getElementById('header');
                
                sidebar.classList.toggle('sidebar-hidden');
                
                if (window.innerWidth >= 1024) {
                    if (sidebar.classList.contains('sidebar-hidden')) {
                        mainContent.classList.remove('lg:ml-64', 'lg:mr-64');
                        header.classList.remove('lg:left-64', 'lg:right-64');
                    } else {
                        if (isRtl) {
                            mainContent.classList.add('lg:mr-64');
                            header.classList.add('lg:right-64');
                        } else {
                            mainContent.classList.add('lg:ml-64');
                            header.classList.add('lg:left-64');
                        }
                    }
                }
            }
            window.toggleSidebar = toggleSidebar;
        </script>
        @stack('scripts')
    </body>
</html>
        @stack('scripts')
    </body>
</html>