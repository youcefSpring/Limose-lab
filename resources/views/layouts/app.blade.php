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

    <!-- DataTables Modern -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Select2 Modern -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])

    <!-- Additional Page Styles -->
    @stack('styles')

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #a5b4fc;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --light: #f8fafc;
            --dark: #0f172a;
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --box-shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --sidebar-width: 280px;
        }

        /* Typography */
        [dir="rtl"] {
            font-family: 'Noto Sans Arabic', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        [dir="ltr"] {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            font-family: inherit;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
            background-color: var(--light);
            color: #1e293b;
        }

        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Modern navbar */
        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
            backdrop-filter: blur(20px);
            box-shadow: var(--box-shadow);
            border: none;
            height: 70px;
            padding: 0.5rem 1.5rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-brand img {
            height: 36px;
            width: 36px;
            border-radius: 8px;
        }

        /* Modern sidebar - Simple fixed approach */
        .sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-right: 1px solid #e2e8f0;
            box-shadow: var(--box-shadow);
            width: var(--sidebar-width);
            position: fixed;
            top: 70px;
            bottom: 0;
            left: 0;
            z-index: 1040;
            overflow-y: auto;
            padding: 1rem 0;
        }

        /* Desktop: Always show sidebar */
        @media (min-width: 992px) {
            .sidebar {
                display: block;
                transform: translateX(0);
            }
        }

        /* Mobile: Hide sidebar by default */
        @media (max-width: 991.98px) {
            .sidebar {
                display: none;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.mobile-open {
                display: block;
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }
        }

        .sidebar-heading {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--secondary);
            margin: 1rem 0 0.5rem;
        }

        .sidebar .nav-link {
            color: #475569;
            padding: 0.875rem 1.5rem;
            margin: 0.125rem 0.75rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
        }

        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: var(--primary-dark);
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.25);
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: white;
            border-radius: 0 3px 3px 0;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        /* User info section */
        .user-info {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            margin: 0.75rem;
            border-radius: var(--border-radius);
            border: 1px solid #e2e8f0;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            border: 2px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Main content */
        .main-content {
            margin-left: 0;
            padding-top: 70px;
            min-height: 100vh;
            transition: var(--transition);
        }

        @media (min-width: 992px) {
            .main-content {
                margin-left: var(--sidebar-width);
            }
        }

        /* Modern cards */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--box-shadow);
            background: white;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--box-shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e2e8f0;
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        /* Modern buttons */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 600;
            padding: 0.625rem 1.5rem;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px 0 rgba(99, 102, 241, 0.35);
        }

        .btn-outline-primary {
            color: var(--primary);
            border: 2px solid var(--primary);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            transform: translateY(-1px);
        }

        /* Modern form controls */
        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            transition: var(--transition);
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* Modern alerts */
        .alert {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border-left: 4px solid;
        }

        .alert-success {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-left-color: var(--success);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            border-left-color: var(--danger);
            color: #991b1b;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fffbeb 0%, #fed7aa 100%);
            border-left-color: var(--warning);
            color: #92400e;
        }

        .alert-info {
            background: linear-gradient(135deg, #ecfeff 0%, #a5f3fc 100%);
            border-left-color: var(--info);
            color: #155e75;
        }

        /* Modern dropdowns */
        .dropdown-menu {
            border: none;
            box-shadow: var(--box-shadow-lg);
            border-radius: var(--border-radius);
            padding: 0.5rem;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            color: white;
        }

        /* Modern search */
        .search-container {
            position: relative;
            max-width: 400px;
        }

        .search-container .form-control {
            padding-left: 2.5rem;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .search-container .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }

        /* Modern loading */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #e2e8f0;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Modern breadcrumbs */
        .breadcrumb {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: var(--border-radius);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-dark);
        }

        .breadcrumb-item.active {
            color: var(--secondary);
            font-weight: 600;
        }

        /* Animations */
        .alert-slide {
            animation: slideInDown 0.5s ease-out;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Modern footer */
        .footer {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-top: 1px solid #e2e8f0;
            margin-top: 3rem;
            margin-left: 0;
        }

        @media (min-width: 992px) {
            .footer {
                margin-left: var(--sidebar-width);
            }
        }

        /* Mobile responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 70px;
                left: -100%;
                transition: left 0.3s ease;
                z-index: 1050;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            :root {
                --light: #1e293b;
                --dark: #f8fafc;
            }

            body {
                background-color: #0f172a;
                color: #f1f5f9;
            }

            .sidebar {
                background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
                border-right-color: #475569;
            }

            .card {
                background: #1e293b;
                border-color: #475569;
            }

            .form-control, .form-select {
                background: #334155;
                border-color: #475569;
                color: #f1f5f9;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Modern Header -->
        <nav class="navbar fixed-top">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand" href="{{ route('dashboard.index') }}">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white bg-opacity-20 p-2 rounded-2">
                            <i class="fas fa-microscope text-white"></i>
                        </div>
                        <span class="text-white">{{ __('SGLR') }}</span>
                    </div>
                </a>

                <!-- Mobile Toggle -->
                <button class="btn btn-outline-light d-lg-none" type="button" id="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Search Bar -->
                <div class="d-none d-lg-flex flex-grow-1 justify-content-center">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="search" class="form-control" id="globalSearch" placeholder="{{ __('Search everything...') }}">
                    </div>
                </div>

                <!-- Right side items -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Language Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe me-1"></i>
                            <span class="d-none d-md-inline">
                                @switch(app()->getLocale())
                                    @case('ar') العربية @break
                                    @case('fr') FR @break
                                    @default EN
                                @endswitch
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
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

                    <!-- Notifications -->
                    <div class="dropdown">
                        <a href="{{ route('dashboard.notifications') }}" class="btn btn-outline-light btn-sm position-relative">
                            <i class="fas fa-bell"></i>
                            @php
                                try {
                                    $unreadCount = auth()->user()->unreadNotifications->count();
                                } catch (\Exception $e) {
                                    $unreadCount = 0; // Default to 0 if notifications table not properly set up
                                }
                            @endphp
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->photo_url ?? '/images/default-avatar.png' }}" alt="User" class="user-avatar" width="32" height="32">
                            <span class="d-none d-md-inline text-white">{{ auth()->user()->name ?? 'User' }}</span>
                            <i class="fas fa-chevron-down text-white-50"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="min-width: 250px;">
                            <div class="dropdown-header">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ auth()->user()->photo_url ?? '/images/default-avatar.png' }}" alt="User" class="user-avatar" width="40" height="40">
                                    <div>
                                        <div class="fw-bold">{{ auth()->user()->name ?? 'User' }}</div>
                                        <small class="text-muted">{{ auth()->user()->email ?? '' }}</small>
                                        <div class="badge bg-light text-dark text-capitalize">{{ auth()->user()->role ?? 'visitor' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('dashboard.profile') }}">
                                <i class="fas fa-user me-2"></i>{{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('dashboard.settings') }}">
                                <i class="fas fa-cog me-2"></i>{{ __('Settings') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Modern Sidebar -->
        <div class="sidebar" id="sidebar">
            <!-- Mobile Header -->
            <div class="d-lg-none p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">{{ __('Navigation') }}</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="mobile-menu-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
                <!-- User Info -->
                <div class="user-info">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ auth()->user()->photo_url ?? '/images/default-avatar.png' }}" alt="User" class="user-avatar">
                        <div class="flex-grow-1">
                            <div class="fw-bold text-truncate">{{ auth()->user()->name ?? 'User' }}</div>
                            <div class="badge bg-primary bg-opacity-10 text-primary text-capitalize">
                                {{ auth()->user()->role ?? 'visitor' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="nav flex-column">
                    <!-- Main Navigation -->
                    <div class="sidebar-heading px-3">{{ __('Main') }}</div>
                    <a class="nav-link" href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>

                    @auth
                        @if(auth()->user()->isResearcher() || auth()->user()->isAdmin() || auth()->user()->isLabManager())
                            <!-- Research Section -->
                            <div class="sidebar-heading px-3">{{ __('Research') }}</div>
                            <a class="nav-link" href="{{ route('researchers.index') }}">
                                <i class="fas fa-user-graduate"></i>
                                <span>{{ __('Researchers') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('projects.index') }}">
                                <i class="fas fa-project-diagram"></i>
                                <span>{{ __('Projects') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('publications.index') }}">
                                <i class="fas fa-newspaper"></i>
                                <span>{{ __('Publications') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('collaborations.index') }}">
                                <i class="fas fa-handshake"></i>
                                <span>{{ __('Collaborations') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('funding.index') }}">
                                <i class="fas fa-coins"></i>
                                <span>{{ __('Funding') }}</span>
                            </a>

                            <!-- Laboratory Section -->
                            <div class="sidebar-heading px-3">{{ __('Laboratory') }}</div>
                            <a class="nav-link" href="{{ route('equipment.index') }}">
                                <i class="fas fa-microscope"></i>
                                <span>{{ __('Equipment') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('events.index') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ __('Events') }}</span>
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <!-- Administration Section -->
                            <div class="sidebar-heading px-3">{{ __('Administration') }}</div>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-shield-alt"></i>
                                <span>{{ __('Admin Panel') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('admin.users') }}">
                                <i class="fas fa-users-cog"></i>
                                <span>{{ __('User Management') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('admin.settings') }}">
                                <i class="fas fa-cogs"></i>
                                <span>{{ __('System Settings') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('admin.analytics') }}">
                                <i class="fas fa-chart-line"></i>
                                <span>{{ __('Analytics') }}</span>
                            </a>
                        @endif

                        @if(auth()->user()->isLabManager())
                            <!-- Lab Management Section -->
                            <div class="sidebar-heading px-3">{{ __('Lab Management') }}</div>
                            <a class="nav-link" href="{{ route('lab-manager.dashboard') }}">
                                <i class="fas fa-flask"></i>
                                <span>{{ __('Lab Dashboard') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('lab-manager.equipment') }}">
                                <i class="fas fa-toolbox"></i>
                                <span>{{ __('Equipment Management') }}</span>
                            </a>
                            <a class="nav-link" href="{{ route('lab-manager.reports') }}">
                                <i class="fas fa-chart-bar"></i>
                                <span>{{ __('Reports') }}</span>
                            </a>
                        @endif
                    @endauth

                    <!-- Quick Actions -->
                    <div class="sidebar-heading px-3">{{ __('Quick Actions') }}</div>
                    <a class="nav-link" href="{{ route('dashboard.profile') }}">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ __('My Profile') }}</span>
                    </a>
                    <a class="nav-link" href="{{ route('dashboard.settings') }}">
                        <i class="fas fa-sliders-h"></i>
                        <span>{{ __('Preferences') }}</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Modern Main Content -->
        <main class="main-content">
            <div class="container-fluid p-4">
                <!-- Breadcrumbs -->
                @if(isset($breadcrumbs))
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            @foreach($breadcrumbs as $breadcrumb)
                                @if($loop->last)
                                    <li class="breadcrumb-item active">
                                        <i class="fas fa-chevron-right me-2 text-muted" style="font-size: 0.75rem;"></i>
                                        {{ $breadcrumb['title'] }}
                                    </li>
                                @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ $breadcrumb['url'] ?? '#' }}" class="text-decoration-none">
                                            {{ $breadcrumb['title'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                @endif

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show alert-slide" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show alert-slide" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show alert-slide" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show alert-slide" role="alert">
                        <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>

        <!-- Modern Footer -->
        <footer class="footer">
            <div class="container-fluid py-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-2">
                                <i class="fas fa-microscope text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold">{{ config('app.name', 'SGLR') }}</div>
                                <small class="text-muted">{{ __('Scientific Research Laboratory Management System') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <div class="text-muted small">
                            © {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                        </div>
                        <div class="d-flex justify-content-md-end gap-3 mt-1">
                            <a href="{{ route('api-docs') }}" class="text-decoration-none small text-muted">
                                {{ __('API Documentation') }}
                            </a>
                            <span class="text-muted small">|</span>
                            <span class="text-muted small">{{ __('Version') }} 1.0.0</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay d-none" id="loadingOverlay">
        <div class="text-center">
            <div class="loading-spinner mb-3"></div>
            <div class="h5">{{ __('Loading...') }}</div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Global search - redirect to search page instead of AJAX
            $('#globalSearch').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    const query = $(this).val().trim();
                    if (query) {
                        window.location.href = '/search?q=' + encodeURIComponent(query);
                    }
                }
            });

            // Simple sidebar toggle for mobile
            $('#mobile-menu-toggle').on('click', function() {
                $('#sidebar').addClass('show');
            });

            $('#mobile-menu-close').on('click', function() {
                $('#sidebar').removeClass('show');
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', function(e) {
                if (window.innerWidth < 992) {
                    if (!$(e.target).closest('#sidebar, #mobile-menu-toggle').length) {
                        $('#sidebar').removeClass('show');
                    }
                }
            });

            // Handle window resize
            $(window).on('resize', function() {
                if (window.innerWidth >= 992) {
                    $('#sidebar').removeClass('show');
                }
            });

            // Mark active navigation
            const currentPath = window.location.pathname;
            $('.nav-link').each(function() {
                const href = $(this).attr('href');
                if (href && (href === currentPath || currentPath.startsWith(href + '/'))) {
                    $(this).addClass('active');
                }
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        });
    </script>

    <!-- Additional Page Scripts -->
    @stack('scripts')
</body>
</html>