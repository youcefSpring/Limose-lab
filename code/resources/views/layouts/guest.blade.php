<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SGLR' }} - {{ config('app.name', 'نظام إدارة المختبرات العلمية للبحث') }}</title>

    <!-- Modern Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Scripts -->
    <!-- Vite removed - using CDN only -->

    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --light: #f8fafc;
            --dark: #0f172a;
            --border-radius: 16px;
            --box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* RTL Support */
        [dir="rtl"] {
            font-family: 'Noto Sans Arabic', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        [dir="ltr"] {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            font-family: inherit;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
            font-variation-settings: normal;
        }

        /* Simple background */
        .bg-simple {
            background: #ffffff;
            min-height: 100vh;
            position: relative;
        }

        /* Simple card */
        .simple-card {
            background: rgba(255, 255, 255, 1);
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            box-shadow: none;
            position: relative;
            z-index: 10;
        }

        /* Modern form controls */
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: rgba(255, 255, 255, 1);
        }

        .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .input-group-text {
            border: 2px solid #e2e8f0;
            border-right: none;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px 0 0 12px;
        }

        .input-group .form-control, .input-group .form-select {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        /* Modern buttons */
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 10px 20px;
            transition: var(--transition);
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px 0 rgba(59, 130, 246, 0.35);
        }

        /* Language selector */
        .language-selector {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 20;
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--box-shadow);
            border-radius: 12px;
            overflow: hidden;
        }

        .dropdown-item {
            padding: 12px 20px;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background: var(--primary);
            color: white;
        }

        /* Simple logo */
        .logo-container {
            animation: none;
        }

        .logo-small {
            width: 60px;
            height: 60px;
            background: #f8fafc;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 1px solid #e2e8f0;
        }

        .logo-small i {
            font-size: 28px;
            color: var(--primary);
        }

        /* Typography */
        .text-gradient {
            color: var(--primary);
        }

        /* Footer links */
        .footer-links .btn {
            color: #64748b;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .footer-links .btn:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .bg-simple {
                background: #ffffff;
            }

            .simple-card {
                background: #ffffff;
                color: #1e293b;
            }

            .form-control {
                background: #ffffff;
                border-color: #e2e8f0;
                color: #1e293b;
            }

            .form-control:focus {
                background: #ffffff;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .simple-card {
                margin: 15px;
                border-radius: 12px;
                padding: 20px !important;
            }

            .language-selector {
                top: 10px;
                right: 10px;
            }

            .form-control {
                padding: 8px 12px;
                font-size: 13px;
            }

            .btn {
                padding: 8px 16px;
                font-size: 13px;
            }

            .logo-small {
                width: 50px;
                height: 50px;
                margin-bottom: 10px;
            }

            .logo-small i {
                font-size: 24px;
            }

            .col-md-6 {
                margin-bottom: 10px !important;
            }
        }

        /* Compact layout for better viewport utilization */
        .container-fluid {
            max-height: 100vh;
            overflow-y: auto;
        }

        .simple-card {
            max-height: 85vh;
            overflow-y: auto;
        }

        /* Register form specific styles */
        .register-form .col-register-xl-6 {
            max-width: 50% !important;
        }

        .register-form .simple-card {
            max-height: 90vh;
            padding: 2rem !important;
        }

        .register-form .form-control, .register-form .form-select {
            padding: 12px 16px;
            font-size: 15px;
        }

        .register-form .form-label {
            font-size: 14px !important;
            font-weight: 500;
        }

        .register-form .btn {
            padding: 12px 24px;
            font-size: 15px;
        }

        .register-form .logo-small {
            width: 70px;
            height: 70px;
            margin-bottom: 20px;
        }

        .register-form .logo-small i {
            font-size: 32px;
        }

        @media (max-width: 1200px) {
            .register-form .col-register-xl-6 {
                max-width: 75% !important;
            }
        }

        @media (max-width: 992px) {
            .register-form .col-register-xl-6 {
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-simple {{ request()->routeIs('register') ? 'register-form' : '' }}">
    <!-- Language Selector -->
    <div class="language-selector">
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-globe me-2"></i>
                @switch(app()->getLocale())
                    @case('ar')
                        العربية
                        @break
                    @case('fr')
                        Français
                        @break
                    @default
                        English
                @endswitch
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                    <i class="fas fa-flag-usa me-2"></i>English
                </a></li>
                <li><a class="dropdown-item" href="{{ route('lang.switch', 'fr') }}">
                    <i class="fas fa-flag me-2"></i>Français
                </a></li>
                <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">
                    <i class="fas fa-flag me-2"></i>العربية
                </a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100 py-3">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4 col-register-xl-6">

                <!-- Logo and Title -->
                <div class="text-center mb-3 logo-container">
                    <div class="logo-small">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h1 class="h4 fw-bold text-dark mb-1">
                        {{ config('app.name', 'SGLR') }}
                    </h1>
                    <p class="text-muted mb-0 small">
                        {{ __('Scientific Research Laboratory Management System') }}
                    </p>
                </div>

                <!-- Auth Card -->
                <div class="simple-card p-3 p-md-4">
                    @yield('content')
                </div>

                <!-- Footer Links -->
                <div class="text-center mt-2 footer-links">
                    <a href="{{ route('home') }}" class="btn btn-link me-2 small">
                        <i class="fas fa-home me-1"></i>{{ __('Home') }}
                    </a>
                    @if(Route::has('api-docs'))
                        <a href="{{ route('api-docs') }}" class="btn btn-link small">
                            <i class="fas fa-code me-1"></i>{{ __('API Docs') }}
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            // Setup CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Add smooth scroll behavior
            $('html').css('scroll-behavior', 'smooth');

            // Add floating animation to logo
            const logo = $('.logo');
            if (logo.length) {
                setInterval(() => {
                    logo.addClass('animate__animated animate__pulse');
                    setTimeout(() => {
                        logo.removeClass('animate__animated animate__pulse');
                    }, 1000);
                }, 5000);
            }

            // Add ripple effect to buttons
            $('.btn').on('click', function(e) {
                const button = $(this);
                const rect = this.getBoundingClientRect();
                const ripple = $('<span class="ripple"></span>');

                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.css({
                    width: size,
                    height: size,
                    left: x,
                    top: y
                });

                button.append(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>

    <style>
        /* Ripple effect */
        .btn {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>

    @stack('scripts')
</body>
</html>