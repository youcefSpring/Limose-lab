<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SGLR Laboratory Management System') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .feature-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .btn-primary-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background: linear-gradient(45deg, #5a6fd8, #6a4190);
            transform: translateY(-2px);
        }
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: 700;
            color: #667eea !important;
        }
        .section-padding {
            padding: 80px 0;
        }
        .icon-large {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .module-card {
            border: none;
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        .module-card .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }
        .stats-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-flask me-2"></i>SGLR Labs
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.about') }}">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="solutionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Solutions
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="solutionsDropdown">
                            <li><a class="dropdown-item" href="{{ route('frontend.services') }}"><i class="fas fa-cogs me-2"></i>Services</a></li>
                            <li><a class="dropdown-item" href="{{ route('frontend.research') }}"><i class="fas fa-microscope me-2"></i>Research</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#features">Platform Features</a></li>
                            <li><a class="dropdown-item" href="#modules">System Modules</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.publications') }}">Publications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.team') }}">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.news') }}">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.careers') }}">Careers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.contact') }}">Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.index') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-white" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        SGLR Laboratory Management System
                    </h1>
                    <p class="lead mb-4">
                        Comprehensive platform for scientific research management.
                        Streamline your laboratory operations, manage projects, equipment,
                        publications, and collaborate with researchers worldwide.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        @auth
                            <a href="{{ route('dashboard.index') }}" class="btn btn-primary-custom btn-lg">
                                <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary-custom btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Get Started
                            </a>
                        @endauth
                        <a href="#modules" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-info-circle me-2"></i>Explore Modules
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="position-relative">
                        <i class="fas fa-flask" style="font-size: 15rem; opacity: 0.1;"></i>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-microscope" style="font-size: 8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary">Key Features</h2>
                    <p class="lead text-muted">Everything you need to manage your laboratory efficiently</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-project-diagram text-primary icon-large"></i>
                            <h5 class="card-title">Project Management</h5>
                            <p class="card-text text-muted">
                                Organize research projects, track progress, manage team collaboration,
                                and monitor milestones with comprehensive project management tools.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-cogs text-success icon-large"></i>
                            <h5 class="card-title">Equipment Management</h5>
                            <p class="card-text text-muted">
                                Manage laboratory equipment inventory, schedule maintenance,
                                handle reservations, and track usage with integrated equipment management.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-book-open text-info icon-large"></i>
                            <h5 class="card-title">Publication Tracking</h5>
                            <p class="card-text text-muted">
                                Track research publications, manage author collaborations,
                                and maintain a comprehensive database of scientific outputs and citations.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-users text-warning icon-large"></i>
                            <h5 class="card-title">Researcher Network</h5>
                            <p class="card-text text-muted">
                                Connect with researchers, manage team members, build research profiles,
                                and facilitate collaboration across different research domains.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-calendar-alt text-danger icon-large"></i>
                            <h5 class="card-title">Event Management</h5>
                            <p class="card-text text-muted">
                                Organize seminars, conferences, training sessions, and workshops.
                                Manage registrations, track attendance, and coordinate schedules.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 feature-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-handshake text-secondary icon-large"></i>
                            <h5 class="card-title">Funding & Collaboration</h5>
                            <p class="card-text text-muted">
                                Track funding sources, manage grant applications, monitor budgets,
                                and facilitate collaborations with external institutions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- System Modules Section -->
    <section id="modules" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary">System Modules</h2>
                    <p class="lead text-muted">Explore all available modules in the laboratory management system</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Dashboard Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Dashboard</h5>
                        <p class="text-muted mb-4">Central hub with analytics, recent activities, and quick access to all system features.</p>
                        <a href="{{ route('dashboard.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>Access Dashboard
                        </a>
                    </div>
                </div>

                <!-- Researchers Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Researchers</h5>
                        <p class="text-muted mb-4">Manage researcher profiles, expertise areas, publications, and collaboration networks.</p>
                        <a href="{{ route('researchers.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>View Researchers
                        </a>
                    </div>
                </div>

                <!-- Projects Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Projects</h5>
                        <p class="text-muted mb-4">Research project management, team assignment, progress tracking, and milestone monitoring.</p>
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>Manage Projects
                        </a>
                    </div>
                </div>

                <!-- Publications Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Publications</h5>
                        <p class="text-muted mb-4">Scientific publication database, author management, citation tracking, and impact metrics.</p>
                        <a href="{{ route('publications.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>View Publications
                        </a>
                    </div>
                </div>

                <!-- Equipment Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Equipment</h5>
                        <p class="text-muted mb-4">Laboratory equipment inventory, reservation system, maintenance schedules, and usage tracking.</p>
                        <a href="{{ route('equipment.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>Manage Equipment
                        </a>
                    </div>
                </div>

                <!-- Events Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Events</h5>
                        <p class="text-muted mb-4">Seminars, conferences, training sessions, workshop management, and attendance tracking.</p>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>View Events
                        </a>
                    </div>
                </div>

                <!-- Collaborations Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Collaborations</h5>
                        <p class="text-muted mb-4">External partnerships, institutional collaborations, joint research projects, and agreements.</p>
                        <a href="{{ route('collaborations.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>View Collaborations
                        </a>
                    </div>
                </div>

                <!-- Funding Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Funding</h5>
                        <p class="text-muted mb-4">Grant applications, funding sources, budget tracking, financial reporting, and expense management.</p>
                        <a href="{{ route('funding.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>Manage Funding
                        </a>
                    </div>
                </div>

                <!-- Admin Module -->
                <div class="col-md-6 col-lg-4">
                    <div class="module-card">
                        <div class="icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Administration</h5>
                        <p class="text-muted mb-4">User management, system settings, permissions, analytics, and administrative tools.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right me-2"></i>Admin Panel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section section-padding">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <i class="fas fa-users text-primary" style="font-size: 3rem;"></i>
                            <h3 class="fw-bold mt-3">500+</h3>
                            <p class="text-muted">Active Researchers</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <i class="fas fa-project-diagram text-success" style="font-size: 3rem;"></i>
                            <h3 class="fw-bold mt-3">150+</h3>
                            <p class="text-muted">Active Projects</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <i class="fas fa-file-alt text-info" style="font-size: 3rem;"></i>
                            <h3 class="fw-bold mt-3">1,200+</h3>
                            <p class="text-muted">Publications</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <i class="fas fa-microscope text-warning" style="font-size: 3rem;"></i>
                            <h3 class="fw-bold mt-3">85+</h3>
                            <p class="text-muted">Lab Equipment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold text-primary mb-4">About SGLR Labs</h2>
                    <p class="lead text-muted mb-4">
                        The Scientific and Research Laboratory Management System (SGLR) is a comprehensive
                        platform designed to streamline laboratory operations and enhance research productivity.
                    </p>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Modern Technology</h6>
                                    <p class="text-muted small mb-0">Built with latest web technologies for optimal performance</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">User-Friendly</h6>
                                    <p class="text-muted small mb-0">Intuitive interface designed for researchers and administrators</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Secure & Reliable</h6>
                                    <p class="text-muted small mb-0">Enterprise-grade security with reliable data protection</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Scalable</h6>
                                    <p class="text-muted small mb-0">Grows with your laboratory and research needs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDUwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI1MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjZjhmOWZhIi8+CjxjaXJjbGUgY3g9IjI1MCIgY3k9IjE1MCIgcj0iNTAiIGZpbGw9IiM2NjdlZWEiLz4KPHN2ZyB4PSIyMjAiIHk9IjEyMCIgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9IndoaXRlIj4KICA8cGF0aCBkPSJNOSA4aDZWNmgtNnYyem00IDJIOXY5aC0yVjZoOHYxMy0zaDJ2Mkg5ek05IDE2aDR2LTJIOXYyeiIvPgo8L3N2Zz4KPC9zdmc+"
                         alt="About SGLR" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-padding bg-primary text-white">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-5 fw-bold mb-4">Ready to Get Started?</h2>
                    <p class="lead mb-4">
                        Join the SGLR Laboratory Management System and transform how you manage your research activities.
                        Get in touch with our team for demos, support, or implementation assistance.
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap mb-4">
                        @auth
                            <a href="{{ route('dashboard.index') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-rocket me-2"></i>Access Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-rocket me-2"></i>Get Started
                            </a>
                        @endauth
                        <a href="mailto:support@sglr.com" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-envelope me-2"></i>Contact Support
                        </a>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-4">
                            <i class="fas fa-envelope fa-2x mb-3"></i>
                            <h6>Email Support</h6>
                            <p>support@sglr.com</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-phone fa-2x mb-3"></i>
                            <h6>Phone Support</h6>
                            <p>+1 (555) 123-4567</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-clock fa-2x mb-3"></i>
                            <h6>Support Hours</h6>
                            <p>24/7 Technical Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">
                        <i class="fas fa-flask me-2"></i>SGLR Laboratory System
                    </h5>
                    <p class="text-muted">
                        Scientific and Research Laboratory Management System -
                        Streamlining laboratory operations worldwide.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-light">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                        <a href="#" class="text-light">
                            <i class="fab fa-github fa-lg"></i>
                        </a>
                    </div>
                </div>

                <div class="col-md-2 mb-4">
                    <h6 class="fw-bold">Company</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.about') }}" class="text-muted text-decoration-none">About</a></li>
                        <li><a href="{{ route('frontend.team') }}" class="text-muted text-decoration-none">Team</a></li>
                        <li><a href="{{ route('frontend.careers') }}" class="text-muted text-decoration-none">Careers</a></li>
                        <li><a href="{{ route('frontend.news') }}" class="text-muted text-decoration-none">News</a></li>
                        <li><a href="{{ route('frontend.contact') }}" class="text-muted text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold">Solutions</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.services') }}" class="text-muted text-decoration-none">Services</a></li>
                        <li><a href="{{ route('frontend.research') }}" class="text-muted text-decoration-none">Research</a></li>
                        <li><a href="{{ route('frontend.publications') }}" class="text-muted text-decoration-none">Publications</a></li>
                        <li><a href="#features" class="text-muted text-decoration-none">Platform Features</a></li>
                        <li><a href="#modules" class="text-muted text-decoration-none">System Modules</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.contact') }}" class="text-muted text-decoration-none">Contact Support</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Documentation</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">API Reference</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Help Center</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Training</a></li>
                    </ul>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} SGLR Laboratory Management System. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="{{ route('frontend.privacy') }}" class="text-muted text-decoration-none">Privacy Policy</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('frontend.terms') }}" class="text-muted text-decoration-none">Terms of Service</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('frontend.contact') }}" class="text-muted text-decoration-none">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Smooth scrolling and animations -->
    <script>
        // Smooth scroll for anchor links
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

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });

        // Animate cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.feature-card, .module-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>