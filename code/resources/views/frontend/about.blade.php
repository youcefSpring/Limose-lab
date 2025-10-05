<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - {{ config('app.name', 'SGLR Laboratory Management System') }}</title>
    <meta name="description" content="Learn about SGLR Laboratory Management System - our mission, vision, team, and commitment to advancing scientific research through innovative technology solutions.">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 120px 0 80px;
            color: white;
        }

        .section-padding {
            padding: 80px 0;
        }

        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .team-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .team-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stats-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-color);
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
        }

        .timeline-content {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            position: relative;
            width: 45%;
        }

        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
        }

        .timeline-item:nth-child(even) .timeline-content {
            margin-right: auto;
        }

        .timeline-date {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            white-space: nowrap;
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            font-weight: 500;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(45deg, #5a6fd8, #6a4190);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
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
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('frontend.about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.research') }}">Research</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.news') }}">News</a>
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
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 fw-bold mb-4">About SGLR Laboratory</h1>
                    <p class="lead mb-4">
                        Pioneering the future of scientific research through innovative laboratory management solutions.
                        We empower researchers worldwide to achieve breakthrough discoveries.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('frontend.contact') }}" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-envelope me-2"></i>Get in Touch
                        </a>
                        <a href="{{ route('frontend.research') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-microscope me-2"></i>Our Research
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <div class="position-relative">
                        <i class="fas fa-atom" style="font-size: 12rem; opacity: 0.1;"></i>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="fas fa-dna" style="font-size: 6rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5" data-aos="fade-up">
                    <div class="feature-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="fas fa-bullseye text-primary" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="text-center mb-4">Our Mission</h3>
                            <p class="text-center text-muted">
                                To revolutionize scientific research by providing cutting-edge laboratory management systems
                                that streamline operations, enhance collaboration, and accelerate scientific discovery.
                                We believe that powerful tools should be accessible to every researcher, regardless of
                                their institution size or budget.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="fas fa-eye text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="text-center mb-4">Our Vision</h3>
                            <p class="text-center text-muted">
                                To become the global leader in laboratory management technology, fostering a world where
                                scientific research is efficiently managed, collaborative, and transparent. We envision
                                a future where researchers can focus entirely on discovery while our systems handle
                                the complexity of laboratory operations.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="stats-section section-padding">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4" data-aos="zoom-in">
                    <div class="stat-card">
                        <div class="stat-number text-primary">500+</div>
                        <h5>Active Researchers</h5>
                        <p class="text-muted">Scientists and researchers using our platform worldwide</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-card">
                        <div class="stat-number text-success">150+</div>
                        <h5>Research Projects</h5>
                        <p class="text-muted">Active research projects being managed on our platform</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="stat-number text-info">1,200+</div>
                        <h5>Publications</h5>
                        <p class="text-muted">Scientific publications tracked and managed</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-card">
                        <div class="stat-number text-warning">85+</div>
                        <h5>Lab Equipment</h5>
                        <p class="text-muted">Pieces of laboratory equipment under management</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Timeline -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary" data-aos="fade-up">Our Story</h2>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">
                        The journey of innovation and scientific advancement
                    </p>
                </div>
            </div>

            <div class="timeline">
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-date">2020</div>
                    <div class="timeline-content">
                        <h4>Foundation</h4>
                        <p>SGLR Laboratory Management System was founded with a vision to transform scientific research through technology. Our team of scientists and developers came together to address the challenges faced by modern laboratories.</p>
                    </div>
                </div>

                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-date">2021</div>
                    <div class="timeline-content">
                        <h4>First Platform Launch</h4>
                        <p>We launched our first laboratory management platform, serving 50 researchers across 5 institutions. The platform included basic project management and equipment tracking features.</p>
                    </div>
                </div>

                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-date">2022</div>
                    <div class="timeline-content">
                        <h4>Global Expansion</h4>
                        <p>Expanded our services internationally, reaching researchers in 25 countries. Introduced advanced features like collaboration tools, publication tracking, and funding management.</p>
                    </div>
                </div>

                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-date">2023</div>
                    <div class="timeline-content">
                        <h4>AI Integration</h4>
                        <p>Integrated artificial intelligence and machine learning capabilities to provide predictive analytics, automated reporting, and intelligent resource allocation recommendations.</p>
                    </div>
                </div>

                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-date">2024</div>
                    <div class="timeline-content">
                        <h4>Next Generation Platform</h4>
                        <p>Launched our next-generation platform with enhanced user experience, mobile applications, and comprehensive API ecosystem for seamless integration with existing laboratory systems.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary" data-aos="fade-up">Meet Our Team</h2>
                    <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">
                        Dedicated professionals committed to advancing scientific research
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up">
                    <div class="team-card">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop&crop=face"
                                 alt="Dr. Ahmed Hassan" class="team-photo mb-3">
                            <h5 class="fw-bold">Dr. Ahmed Hassan</h5>
                            <p class="text-primary mb-2">Chief Executive Officer</p>
                            <p class="text-muted small">
                                PhD in Computer Science with 15+ years in laboratory management systems.
                                Passionate about bridging technology and scientific research.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-muted"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fas fa-envelope fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-card">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b123?w=300&h=300&fit=crop&crop=face"
                                 alt="Dr. Sarah Johnson" class="team-photo mb-3">
                            <h5 class="fw-bold">Dr. Sarah Johnson</h5>
                            <p class="text-primary mb-2">Chief Technology Officer</p>
                            <p class="text-muted small">
                                Expert in laboratory automation and software architecture.
                                Leading our technical innovation and platform development.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-muted"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fab fa-github fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fas fa-envelope fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-card">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face"
                                 alt="Dr. Michael Chen" class="team-photo mb-3">
                            <h5 class="fw-bold">Dr. Michael Chen</h5>
                            <p class="text-primary mb-2">Head of Research</p>
                            <p class="text-muted small">
                                Biochemist and data scientist specializing in laboratory workflow optimization
                                and research methodology innovation.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-muted"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fab fa-researchgate fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fas fa-envelope fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-card">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop&crop=face"
                                 alt="Dr. Emily Rodriguez" class="team-photo mb-3">
                            <h5 class="fw-bold">Dr. Emily Rodriguez</h5>
                            <p class="text-primary mb-2">Director of Operations</p>
                            <p class="text-muted small">
                                Operations expert with deep understanding of laboratory workflows
                                and institutional research requirements.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-muted"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fas fa-envelope fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-card">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop&crop=face"
                                 alt="Dr. David Kim" class="team-photo mb-3">
                            <h5 class="fw-bold">Dr. David Kim</h5>
                            <p class="text-primary mb-2">Lead Software Architect</p>
                            <p class="text-muted small">
                                Full-stack developer and system architect designing scalable
                                laboratory management solutions for global research institutions.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-muted"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fab fa-github fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fas fa-envelope fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="500">
                    <div class="team-card">
                        <div class="card-body text-center p-4">
                            <img src="https://images.unsplash.com/photo-1507101105822-7472b28e22ac?w=300&h=300&fit=crop&crop=face"
                                 alt="Dr. James Wilson" class="team-photo mb-3">
                            <h5 class="fw-bold">Dr. James Wilson</h5>
                            <p class="text-primary mb-2">Customer Success Manager</p>
                            <p class="text-muted small">
                                Dedicated to ensuring our clients achieve maximum value from our platform.
                                Expert in laboratory management best practices.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="text-muted"><i class="fab fa-linkedin fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#" class="text-muted"><i class="fas fa-envelope fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="section-padding" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto text-white">
                    <h2 class="display-5 fw-bold mb-4" data-aos="fade-up">Ready to Transform Your Research?</h2>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        Join hundreds of researchers who have revolutionized their laboratory operations with SGLR.
                        Experience the future of scientific research management today.
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('frontend.contact') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-rocket me-2"></i>Get Started Today
                        </a>
                        <a href="{{ route('frontend.services') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-info-circle me-2"></i>Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('frontend.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });

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
    </script>
</body>
</html>