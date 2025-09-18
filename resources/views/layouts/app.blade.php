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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])

    <!-- Additional Page Styles -->
    @stack('styles')

    <style>
        /* RTL Support */
        [dir="rtl"] {
            font-family: 'Noto Sans Arabic', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        [dir="ltr"] {
            font-family: 'Figtree', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Custom SGLR Colors */
        .sglr-primary {
            background-color: #1976d2 !important;
        }

        .sglr-secondary {
            background-color: #424242 !important;
        }

        .sglr-accent {
            background-color: #82b1ff !important;
        }

        .sglr-success {
            background-color: #4caf50 !important;
        }

        .sglr-warning {
            background-color: #ff9800 !important;
        }

        .sglr-error {
            background-color: #f44336 !important;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(2px);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #1976d2;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Sidebar styles */
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.25rem;
        }

        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: #212529;
        }

        .sidebar .nav-link.active {
            background-color: #1976d2;
            color: white;
        }

        .navbar-brand img {
            height: 32px;
        }

        /* Alert animations */
        .alert-slide {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Main content positioning */
        .main-content {
            margin-left: 0;
        }

        @media (min-width: 992px) {
            .main-content {
                margin-left: 280px;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-dark sglr-primary fixed-top">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard.index') }}">
                    <img src="/images/sglr-logo.png" alt="SGLR Logo" class="me-2">
                    <span class="fw-bold">{{ __('SGLR') }}</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Search Bar -->
                <div class="d-none d-lg-flex flex-grow-1 justify-content-center">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="search" class="form-control" id="globalSearch" placeholder="{{ __('Search...') }}">
                        <button class="btn btn-outline-light" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Right side items -->
                <div class="d-flex align-items-center">
                    <!-- Language Dropdown -->
                    <div class="dropdown me-2">
                        <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/lang/ar">العربية</a></li>
                            <li><a class="dropdown-item" href="/lang/fr">Français</a></li>
                            <li><a class="dropdown-item" href="/lang/en">English</a></li>
                        </ul>
                    </div>

                    <!-- Notifications -->
                    <div class="dropdown me-2">
                        <button class="btn btn-outline-light btn-sm position-relative" type="button" data-bs-toggle="dropdown" id="notificationsBtn">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" id="notificationBadge">
                                0
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" style="width: 350px; max-height: 400px; overflow-y: auto;" id="notificationsDropdown">
                            <h6 class="dropdown-header">{{ __('Notifications') }}</h6>
                            <div id="notificationsList">
                                <div class="dropdown-item text-center text-muted">{{ __('Loading...') }}</div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="{{ route('dashboard.notifications') }}">{{ __('View All') }}</a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->photo_url ?? '/images/default-avatar.png' }}" alt="User" class="rounded-circle me-1" width="24" height="24">
                            <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'User' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">{{ auth()->user()->name ?? 'User' }}<br><small class="text-muted">{{ auth()->user()->email ?? '' }}</small></h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="fas fa-user me-2"></i>{{ __('Profile') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.settings') }}"><i class="fas fa-cog me-2"></i>{{ __('Settings') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="sidebar" data-bs-backdrop="false">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">{{ __('Navigation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <!-- User Info -->
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <img src="{{ auth()->user()->photo_url ?? '/images/default-avatar.png' }}" alt="User" class="rounded-circle me-2" width="40" height="40">
                        <div>
                            <div class="fw-medium">{{ auth()->user()->name ?? 'User' }}</div>
                            <small class="text-muted text-capitalize">{{ auth()->user()->role ?? 'visitor' }}</small>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="nav flex-column p-2">
                    <a class="nav-link" href="{{ route('dashboard.index') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>{{ __('Dashboard') }}
                    </a>

                    @auth
                        @if(auth()->user()->isResearcher() || auth()->user()->isAdmin() || auth()->user()->isLabManager())
                            <a class="nav-link" href="{{ route('researchers.index') }}">
                                <i class="fas fa-users me-2"></i>{{ __('Researchers') }}
                            </a>
                            <a class="nav-link" href="{{ route('projects.index') }}">
                                <i class="fas fa-folder me-2"></i>{{ __('Projects') }}
                            </a>
                            <a class="nav-link" href="{{ route('publications.index') }}">
                                <i class="fas fa-book me-2"></i>{{ __('Publications') }}
                            </a>
                            <a class="nav-link" href="{{ route('equipment.index') }}">
                                <i class="fas fa-tools me-2"></i>{{ __('Equipment') }}
                            </a>
                            <a class="nav-link" href="{{ route('events.index') }}">
                                <i class="fas fa-calendar me-2"></i>{{ __('Events') }}
                            </a>
                            <a class="nav-link" href="{{ route('collaborations.index') }}">
                                <i class="fas fa-handshake me-2"></i>{{ __('Collaborations') }}
                            </a>
                            <a class="nav-link" href="{{ route('funding.index') }}">
                                <i class="fas fa-dollar-sign me-2"></i>{{ __('Funding') }}
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            <hr class="my-2">
                            <h6 class="sidebar-heading px-3">{{ __('Administration') }}</h6>
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-shield-alt me-2"></i>{{ __('Admin Panel') }}
                            </a>
                            <a class="nav-link" href="{{ route('admin.users') }}">
                                <i class="fas fa-user-cog me-2"></i>{{ __('User Management') }}
                            </a>
                            <a class="nav-link" href="{{ route('admin.settings') }}">
                                <i class="fas fa-cogs me-2"></i>{{ __('System Settings') }}
                            </a>
                            <a class="nav-link" href="{{ route('admin.analytics') }}">
                                <i class="fas fa-chart-line me-2"></i>{{ __('Analytics') }}
                            </a>
                        @endif

                        @if(auth()->user()->isLabManager())
                            <hr class="my-2">
                            <h6 class="sidebar-heading px-3">{{ __('Lab Management') }}</h6>
                            <a class="nav-link" href="{{ route('lab-manager.dashboard') }}">
                                <i class="fas fa-microscope me-2"></i>{{ __('Lab Dashboard') }}
                            </a>
                            <a class="nav-link" href="{{ route('lab-manager.equipment') }}">
                                <i class="fas fa-toolbox me-2"></i>{{ __('Equipment Management') }}
                            </a>
                            <a class="nav-link" href="{{ route('lab-manager.reports') }}">
                                <i class="fas fa-file-alt me-2"></i>{{ __('Reports') }}
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container-fluid pt-5 mt-3">
                <!-- Breadcrumbs -->
                @if(isset($breadcrumbs))
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            @foreach($breadcrumbs as $breadcrumb)
                                @if($loop->last)
                                    <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                @else
                                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] ?? '#' }}">{{ $breadcrumb['title'] }}</a></li>
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

        <!-- Footer -->
        <footer class="footer bg-light border-top mt-5">
            <div class="container-fluid py-3">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="text-muted">
                            © {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                        </div>
                        <div class="small text-muted">
                            {{ __('Version') }} 1.0.0 |
                            <a href="{{ route('api-docs') }}" class="text-decoration-none">{{ __('API Documentation') }}</a>
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
            // Setup CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Global loading functions
            window.showLoading = function() {
                $('#loadingOverlay').removeClass('d-none');
            };

            window.hideLoading = function() {
                $('#loadingOverlay').addClass('d-none');
            };

            // Global search
            $('#searchBtn, #globalSearch').on('click keyup', function(e) {
                if (e.type === 'click' || e.key === 'Enter') {
                    const query = $('#globalSearch').val().trim();
                    if (query) {
                        console.log('Searching for:', query);
                        // Implement global search functionality
                    }
                }
            });

            // Load notifications
            function loadNotifications() {
                $.get('/api/v1/notifications')
                    .done(function(response) {
                        if (response.status === 'success') {
                            updateNotifications(response.data.notifications, response.data.unread_count);
                        }
                    })
                    .fail(function(xhr) {
                        console.error('Failed to load notifications:', xhr);
                    });
            }

            function updateNotifications(notifications, unreadCount) {
                // Update badge
                const badge = $('#notificationBadge');
                if (unreadCount > 0) {
                    badge.text(unreadCount).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }

                // Update dropdown
                const list = $('#notificationsList');
                list.empty();

                if (notifications.length === 0) {
                    list.append('<div class="dropdown-item text-center text-muted">{{ __('No notifications') }}</div>');
                } else {
                    notifications.forEach(function(notification) {
                        const item = $(`
                            <a class="dropdown-item notification-item ${!notification.is_read ? 'bg-light' : ''}"
                               href="#" data-id="${notification.id}">
                                <div class="fw-medium">${notification.title}</div>
                                <div class="text-muted small">${notification.message}</div>
                                <div class="text-muted small">${new Date(notification.created_at).toLocaleDateString()}</div>
                            </a>
                        `);
                        list.append(item);
                    });
                }
            }

            // Mark notification as read
            $(document).on('click', '.notification-item', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const item = $(this);

                $.ajax({
                    url: `/api/v1/notifications/${id}/read`,
                    type: 'PUT',
                    success: function() {
                        item.removeClass('bg-light');
                        const currentCount = parseInt($('#notificationBadge').text()) || 0;
                        if (currentCount > 1) {
                            $('#notificationBadge').text(currentCount - 1);
                        } else {
                            $('#notificationBadge').addClass('d-none');
                        }
                    },
                    error: function(xhr) {
                        console.error('Failed to mark notification as read:', xhr);
                    }
                });
            });

            // Logout functionality
            $('#logoutBtn').on('click', function(e) {
                e.preventDefault();

                $.post('/api/v1/auth/logout')
                    .always(function() {
                        window.location.href = '/';
                    });
            });

            // Initialize sidebar for desktop
            if (window.innerWidth >= 992) {
                const sidebar = new bootstrap.Offcanvas('#sidebar');
                sidebar.show();

                // Prevent backdrop on desktop
                $('#sidebar').on('show.bs.offcanvas', function() {
                    if (window.innerWidth >= 992) {
                        $(this).attr('data-bs-backdrop', 'false');
                    }
                });
            }

            // Mark active navigation
            const currentPath = window.location.pathname;
            $('.nav-link').each(function() {
                const href = $(this).attr('href');
                if (href && (href === currentPath || currentPath.startsWith(href + '/'))) {
                    $(this).addClass('active');
                }
            });

            // Load notifications on page load
            loadNotifications();
        });
    </script>

    <!-- Additional Page Scripts -->
    @stack('scripts')
</body>
</html>