<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SGLR Laboratory Management System')</title>
    <meta name="description" content="@yield('description', 'Advanced laboratory management solutions for research institutions and scientific organizations.')">
    <meta name="keywords" content="@yield('keywords', 'laboratory management, research software, scientific equipment, lab management system')">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'SGLR Laboratory Management System')">
    <meta property="og:description" content="@yield('og_description', 'Advanced laboratory management solutions for research institutions and scientific organizations.')">
    <meta property="og:image" content="@yield('og_image', asset('images/sglr-logo.png'))">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'SGLR Laboratory Management System')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Advanced laboratory management solutions for research institutions and scientific organizations.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/sglr-logo.png'))">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --dark-color: #2d3748;
            --light-color: #f7fafc;
            --text-color: #4a5568;
            --border-color: #e2e8f0;
            --success-color: #48bb78;
            --warning-color: #ed8936;
            --danger-color: #f56565;
            --info-color: #4299e1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: #ffffff;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .navbar-custom.scrolled {
            padding: 0.5rem 0;
            background: rgba(255, 255, 255, 0.98);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            text-decoration: none;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-color) !important;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(102, 126, 234, 0.1);
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 24px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-color);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .footer-custom {
            background: linear-gradient(135deg, var(--dark-color) 0%, #1a202c 100%);
            color: white;
            padding: 60px 0 20px;
        }

        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer-link {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer-link:hover {
            color: var(--accent-color);
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
        }

        .social-icon:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-spinner.show {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .section-padding {
                padding: 60px 0;
            }

            .navbar-nav {
                text-align: center;
                margin-top: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Navigation -->
    @include('frontend.partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Page loading effect
        window.addEventListener('beforeunload', function() {
            document.getElementById('loadingSpinner').classList.add('show');
        });

        // Hide loading spinner when page loads
        window.addEventListener('load', function() {
            setTimeout(() => {
                document.getElementById('loadingSpinner').classList.remove('show');
            }, 300);
        });

        // Form validation and submission
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>