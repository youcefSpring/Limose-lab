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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        /* Modern background */
        .bg-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 300% 300%;
            animation: gradientShift 8s ease infinite;
            min-height: 100vh;
            position: relative;
        }

        .bg-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Modern glass card */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            position: relative;
            z-index: 10;
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }

        /* Modern form controls */
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 15px;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: rgba(255, 255, 255, 1);
        }

        .input-group-text {
            border: 2px solid #e2e8f0;
            border-right: none;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px 0 0 12px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        /* Modern buttons */
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 12px 24px;
            transition: var(--transition);
            font-size: 15px;
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

        /* Logo animation */
        .logo-container {
            animation: fadeInUp 1s ease-out;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo i {
            font-size: 36px;
            color: white;
        }

        /* Typography */
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Footer links */
        .footer-links {
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .footer-links .btn {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .footer-links .btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .glass-card {
                background: rgba(15, 23, 42, 0.95);
                color: white;
            }

            .form-control {
                background: rgba(30, 41, 59, 0.8);
                border-color: #334155;
                color: white;
            }

            .form-control:focus {
                background: rgba(30, 41, 59, 1);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .glass-card {
                margin: 20px;
                border-radius: 12px;
            }

            .language-selector {
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body class="bg-modern">
    <!-- Language Selector -->
    <div class="language-selector">
        <div class="dropdown">
            <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
    <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">

                <!-- Logo and Title -->
                <div class="text-center mb-5 logo-container">
                    <div class="logo animate__animated animate__bounceIn">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h1 class="h2 fw-bold text-white mb-2 animate__animated animate__fadeInUp">
                        {{ config('app.name', 'SGLR') }}
                    </h1>
                    <p class="text-white-50 mb-0 animate__animated animate__fadeInUp animate__delay-1s">
                        {{ __('Scientific Research Laboratory Management System') }}
                    </p>
                </div>

                <!-- Auth Card -->
                <div class="glass-card p-4 p-md-5 animate__animated animate__fadeInUp animate__delay-2s">
                    @yield('content')
                </div>

                <!-- Footer Links -->
                <div class="text-center mt-4 footer-links">
                    <a href="{{ route('home') }}" class="btn btn-link text-white-50 me-3">
                        <i class="fas fa-home me-2"></i>{{ __('Home') }}
                    </a>
                    @if(Route::has('api-docs'))
                        <a href="{{ route('api-docs') }}" class="btn btn-link text-white-50">
                            <i class="fas fa-code me-2"></i>{{ __('API Docs') }}
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