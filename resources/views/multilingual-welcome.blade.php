@extends('layouts.guest')

@section('content')
<div id="welcome-app">
    <!-- Main content based on locale -->
    <div class="text-center">
        @if(app()->getLocale() === 'ar')
            <!-- Arabic Content -->
            <h2 class="text-h4 font-weight-bold mb-4">
                مرحباً بكم في نظام إدارة المختبرات العلمية للبحث
            </h2>
            <p class="text-body-1 mb-6">
                نظام شامل لإدارة الأنشطة البحثية، والمشاريع، والمنشورات، والمعدات العلمية
            </p>

            <!-- Action buttons in Arabic -->
            <div class="d-flex justify-center ga-4 flex-wrap">
                <v-btn
                    color="primary"
                    size="large"
                    prepend-icon="mdi-login"
                    href="/login"
                >
                    تسجيل الدخول
                </v-btn>
                <v-btn
                    color="success"
                    size="large"
                    prepend-icon="mdi-account-plus"
                    variant="outlined"
                    href="/register"
                >
                    إنشاء حساب جديد
                </v-btn>
            </div>

        @elseif(app()->getLocale() === 'fr')
            <!-- French Content -->
            <h2 class="text-h4 font-weight-bold mb-4">
                Bienvenue dans le Système de Gestion des Laboratoires de Recherche Scientifique
            </h2>
            <p class="text-body-1 mb-6">
                Un système complet pour gérer les activités de recherche, projets, publications et équipements scientifiques
            </p>

            <!-- Action buttons in French -->
            <div class="d-flex justify-center ga-4 flex-wrap">
                <v-btn
                    color="primary"
                    size="large"
                    prepend-icon="mdi-login"
                    href="/login"
                >
                    Se Connecter
                </v-btn>
                <v-btn
                    color="success"
                    size="large"
                    prepend-icon="mdi-account-plus"
                    variant="outlined"
                    href="/register"
                >
                    Créer un Compte
                </v-btn>
            </div>

        @else
            <!-- English Content (Default) -->
            <h2 class="text-h4 font-weight-bold mb-4">
                Welcome to Scientific Research Laboratory Management System
            </h2>
            <p class="text-body-1 mb-6">
                A comprehensive system for managing research activities, projects, publications, and scientific equipment
            </p>

            <!-- Action buttons in English -->
            <div class="d-flex justify-center ga-4 flex-wrap">
                <v-btn
                    color="primary"
                    size="large"
                    prepend-icon="mdi-login"
                    href="/login"
                >
                    Sign In
                </v-btn>
                <v-btn
                    color="success"
                    size="large"
                    prepend-icon="mdi-account-plus"
                    variant="outlined"
                    href="/register"
                >
                    Create Account
                </v-btn>
            </div>
        @endif

        <!-- Key Features Section -->
        <v-divider class="my-8"></v-divider>

        <div class="mb-6">
            <h3 class="text-h5 font-weight-bold mb-4">
                {{ __('Key Features') }}
            </h3>

            <v-row>
                <v-col cols="12" sm="4">
                    <v-card variant="outlined" class="pa-4 text-center h-100">
                        <v-icon size="48" color="primary" class="mb-2">mdi-flask</v-icon>
                        <h4 class="text-h6 font-weight-bold mb-2">{{ __('Research Management') }}</h4>
                        <p class="text-body-2">{{ __('Manage research projects, researchers, and scientific publications') }}</p>
                    </v-card>
                </v-col>

                <v-col cols="12" sm="4">
                    <v-card variant="outlined" class="pa-4 text-center h-100">
                        <v-icon size="48" color="success" class="mb-2">mdi-tools</v-icon>
                        <h4 class="text-h6 font-weight-bold mb-2">{{ __('Equipment Management') }}</h4>
                        <p class="text-body-2">{{ __('Reserve and use scientific equipment with maintenance scheduling') }}</p>
                    </v-card>
                </v-col>

                <v-col cols="12" sm="4">
                    <v-card variant="outlined" class="pa-4 text-center h-100">
                        <v-icon size="48" color="info" class="mb-2">mdi-handshake</v-icon>
                        <h4 class="text-h6 font-weight-bold mb-2">{{ __('International Collaboration') }}</h4>
                        <p class="text-body-2">{{ __('Manage collaboration with international research institutions') }}</p>
                    </v-card>
                </v-col>
            </v-row>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* RTL specific styles for Arabic */
[dir="rtl"] .v-card {
    text-align: right;
}

[dir="rtl"] .v-list-item {
    text-align: right;
}

/* Smooth transitions */
.v-card {
    transition: transform 0.2s ease-in-out;
}

.v-card:hover {
    transform: translateY(-2px);
}
</style>
@endpush