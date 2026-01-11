<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar']) ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RLMS') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
        @if(app()->getLocale() === 'ar')
            <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
        @endif

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        </style>
    </head>
    <body class="min-h-screen text-zinc-800 dark:text-white {{ app()->getLocale() === 'ar' ? 'font-arabic' : 'font-outfit' }}">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 sm:px-6 lg:px-8 py-12">
            <!-- Theme Toggle -->
            <div class="absolute top-4 {{ app()->getLocale() === 'ar' ? 'left-4' : 'right-4' }}">
                <button onclick="toggleTheme()" class="p-2.5 rounded-xl glass hover:glass-card transition-all group">
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

            <!-- Logo -->
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-accent-amber to-accent-coral flex items-center justify-center glow-amber">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-semibold tracking-tight">{{ config('app.name', 'RLMS') }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Research Laboratory Management System') }}</p>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md">
                <div class="glass-card rounded-2xl p-6 sm:p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            </div>
        </div>

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
        </script>
    </body>
</html>
