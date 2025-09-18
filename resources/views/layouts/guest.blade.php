<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SGLR' }} - {{ config('app.name', 'نظام إدارة المختبرات العلمية للبحث') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Arabic Font -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Material Design Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Vuetify CSS -->
    <link href="https://cdn.jsdelivr.net/npm/vuetify@3.4.4/dist/vuetify.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* RTL Support */
        [dir="rtl"] {
            font-family: 'Noto Sans Arabic', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        [dir="ltr"] {
            font-family: 'Figtree', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Background gradient */
        .bg-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Custom card styling */
        .auth-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div id="app" class="bg-gradient">
        <v-app>
            <v-main>
                <!-- Header with Language Selector -->
                <v-app-bar color="transparent" flat absolute>
                    <v-spacer></v-spacer>

                    <!-- Language Selector -->
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                icon
                                variant="text"
                                color="white"
                                v-bind="props"
                            >
                                <v-icon>mdi-translate</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item @click="changeLanguage('ar')">
                                <v-list-item-title>العربية</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="changeLanguage('fr')">
                                <v-list-item-title>Français</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="changeLanguage('en')">
                                <v-list-item-title>English</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-app-bar>

                <!-- Main Content -->
                <v-container fluid class="fill-height">
                    <v-row justify="center" align="center" class="fill-height">
                        <v-col cols="12" sm="8" md="6" lg="4">
                            <!-- Logo and Title -->
                            <div class="text-center mb-8">
                                <v-avatar size="80" class="mb-4">
                                    <v-img
                                        src="/images/sglr-logo.png"
                                        alt="SGLR Logo"
                                    ></v-img>
                                </v-avatar>
                                <h1 class="text-h4 font-weight-bold text-white mb-2">
                                    {{ config('app.name', 'SGLR') }}
                                </h1>
                                <p class="text-subtitle-1 text-white opacity-90">
                                    {{ __('Scientific Research Laboratory Management System') }}
                                </p>
                            </div>

                            <!-- Auth Card -->
                            <v-card class="auth-card" elevation="24" rounded="lg">
                                <v-card-text class="pa-8">
                                    @yield('content')
                                </v-card-text>
                            </v-card>

                            <!-- Footer Links -->
                            <div class="text-center mt-6">
                                <v-btn
                                    variant="text"
                                    color="white"
                                    href="{{ route('home') }}"
                                    class="mx-2"
                                >
                                    {{ __('Home') }}
                                </v-btn>
                                @if(Route::has('api-docs'))
                                    <v-btn
                                        variant="text"
                                        color="white"
                                        href="{{ route('api-docs') }}"
                                        class="mx-2"
                                    >
                                        {{ __('API Docs') }}
                                    </v-btn>
                                @endif
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </v-app>
    </div>

    <!-- Vue.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/vue@3.3.8/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@3.4.4/dist/vuetify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.0/dist/axios.min.js"></script>

    <script>
        const { createApp } = Vue;
        const { createVuetify } = Vuetify;

        // Vuetify configuration
        const vuetify = createVuetify({
            theme: {
                defaultTheme: 'light',
                themes: {
                    light: {
                        colors: {
                            primary: '#1976d2',
                            secondary: '#424242',
                            accent: '#82b1ff',
                            error: '#f44336',
                            warning: '#ff9800',
                            info: '#2196f3',
                            success: '#4caf50'
                        }
                    }
                }
            },
            locale: {
                locale: '{{ app()->getLocale() }}',
                rtl: {{ app()->getLocale() === 'ar' ? 'true' : 'false' }}
            }
        });

        // Vue.js app
        const app = createApp({
            methods: {
                changeLanguage(locale) {
                    window.location.href = `/lang/${locale}`;
                }
            },
            mounted() {
                // Setup axios defaults
                axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            }
        });

        app.use(vuetify);
        app.mount('#app');
    </script>

    @stack('scripts')
</body>
</html>