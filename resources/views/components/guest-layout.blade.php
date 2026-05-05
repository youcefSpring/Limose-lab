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

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo -->
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-zinc-500" />
                </a>
            </div>

            <!-- Content -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 glass-card rounded-2xl overflow-hidden">
                {{ $slot }}
            </div>
        </div>

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

            // Initialize theme from localStorage or default to light
            if (localStorage.getItem('theme') === 'dark' || !localStorage.getItem('theme')) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        @stack('scripts')
    </body>
</html>
