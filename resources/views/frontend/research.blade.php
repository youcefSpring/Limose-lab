@extends('frontend.layouts.app')

@section('title', 'Research - SGLR Laboratory Management System')
@section('description', 'Explore cutting-edge research projects, publications, and innovations in laboratory management and scientific collaboration.')
@section('keywords', 'laboratory research, scientific projects, research collaboration, publications, innovation, laboratory technology')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
                        Advancing Scientific Research Through Innovation
                    </h1>
                    <p class="lead mb-4" data-aos="fade-right" data-aos-delay="100">
                        Discover our groundbreaking research initiatives that are shaping the future of laboratory management and scientific collaboration.
                    </p>
                    <div class="hero-buttons" data-aos="fade-right" data-aos-delay="200">
                        <a href="#research-areas" class="btn btn-light btn-lg me-3 mb-3">
                            <i class="fas fa-microscope me-2"></i>Explore Research
                        </a>
                        <a href="{{ route('frontend.publications') }}" class="btn btn-outline-light btn-lg mb-3">
                            <i class="fas fa-book me-2"></i>View Publications
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                         alt="Scientific Research"
                         class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Research Statistics -->
<section class="research-stats py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <h3 class="stat-number text-primary">
                        <span class="counter" data-target="150">0</span>+
                    </h3>
                    <p class="stat-label">Active Projects</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <h3 class="stat-number text-success">
                        <span class="counter" data-target="500">0</span>+
                    </h3>
                    <p class="stat-label">Publications</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <h3 class="stat-number text-info">
                        <span class="counter" data-target="75">0</span>+
                    </h3>
                    <p class="stat-label">Collaborations</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <h3 class="stat-number text-warning">
                        <span class="counter" data-target="25">0</span>+
                    </h3>
                    <p class="stat-label">Patents</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Research Areas -->
<section id="research-areas" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Our Research Focus Areas</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    We're pioneering research across multiple domains to advance laboratory management and scientific discovery.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="research-area-card card-custom h-100 p-4">
                    <div class="research-icon mb-3">
                        <i class="fas fa-robot text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="research-title mb-3">Laboratory Automation</h4>
                    <p class="research-description mb-4">
                        Developing intelligent automation systems for laboratory workflows, equipment management, and data collection to enhance efficiency and reduce human error.
                    </p>
                    <div class="research-progress mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Research Progress</small>
                            <small>85%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-primary btn-sm">Learn More</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="research-area-card card-custom h-100 p-4">
                    <div class="research-icon mb-3">
                        <i class="fas fa-brain text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="research-title mb-3">AI-Driven Analytics</h4>
                    <p class="research-description mb-4">
                        Leveraging artificial intelligence and machine learning to provide predictive analytics, pattern recognition, and intelligent insights from laboratory data.
                    </p>
                    <div class="research-progress mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Research Progress</small>
                            <small>72%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 72%"></div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-success btn-sm">Learn More</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="research-area-card card-custom h-100 p-4">
                    <div class="research-icon mb-3">
                        <i class="fas fa-network-wired text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="research-title mb-3">Collaborative Networks</h4>
                    <p class="research-description mb-4">
                        Creating advanced collaboration platforms that enable seamless knowledge sharing and project coordination across global research networks.
                    </p>
                    <div class="research-progress mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Research Progress</small>
                            <small>91%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 91%"></div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-info btn-sm">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Featured Research Projects</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Explore our most impactful research projects that are transforming laboratory management practices worldwide.
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Project 1 -->
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="project-card card-custom h-100">
                    <div class="project-image">
                        <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Smart Lab Management"
                             class="img-fluid">
                        <div class="project-status">
                            <span class="badge bg-success">Ongoing</span>
                        </div>
                    </div>
                    <div class="project-content p-4">
                        <h5 class="project-title mb-3">Smart Lab Management Platform</h5>
                        <p class="project-description mb-3">
                            Developing an AI-powered platform that optimizes laboratory operations through predictive maintenance, intelligent scheduling, and automated resource allocation.
                        </p>
                        <div class="project-meta mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>2023-2025
                                    </small>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-dollar-sign me-1"></i>$2.5M funding
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="project-tags mb-3">
                            <span class="badge bg-light text-dark me-1">AI</span>
                            <span class="badge bg-light text-dark me-1">Automation</span>
                            <span class="badge bg-light text-dark">IoT</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Project 2 -->
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="project-card card-custom h-100">
                    <div class="project-image">
                        <img src="https://images.unsplash.com/photo-1576086213369-97a306d36557?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Blockchain Research"
                             class="img-fluid">
                        <div class="project-status">
                            <span class="badge bg-warning">Pilot Phase</span>
                        </div>
                    </div>
                    <div class="project-content p-4">
                        <h5 class="project-title mb-3">Blockchain for Research Integrity</h5>
                        <p class="project-description mb-3">
                            Implementing blockchain technology to ensure data integrity, reproducibility, and transparency in scientific research and laboratory operations.
                        </p>
                        <div class="project-meta mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>2024-2026
                                    </small>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-dollar-sign me-1"></i>$1.8M funding
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="project-tags mb-3">
                            <span class="badge bg-light text-dark me-1">Blockchain</span>
                            <span class="badge bg-light text-dark me-1">Security</span>
                            <span class="badge bg-light text-dark">Integrity</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Project 3 -->
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="project-card card-custom h-100">
                    <div class="project-image">
                        <img src="https://images.unsplash.com/photo-1518152006812-edab29b069ac?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Virtual Collaboration"
                             class="img-fluid">
                        <div class="project-status">
                            <span class="badge bg-info">Beta Testing</span>
                        </div>
                    </div>
                    <div class="project-content p-4">
                        <h5 class="project-title mb-3">Virtual Research Collaboration</h5>
                        <p class="project-description mb-3">
                            Creating immersive virtual environments for remote laboratory collaboration, enabling researchers to work together regardless of physical location.
                        </p>
                        <div class="project-meta mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>2023-2024
                                    </small>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-dollar-sign me-1"></i>$3.2M funding
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="project-tags mb-3">
                            <span class="badge bg-light text-dark me-1">VR/AR</span>
                            <span class="badge bg-light text-dark me-1">Collaboration</span>
                            <span class="badge bg-light text-dark">Remote Work</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Project 4 -->
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="project-card card-custom h-100">
                    <div class="project-image">
                        <img src="https://images.unsplash.com/photo-1581092918484-8313de2c4ea8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Sustainability Research"
                             class="img-fluid">
                        <div class="project-status">
                            <span class="badge bg-success">Completed</span>
                        </div>
                    </div>
                    <div class="project-content p-4">
                        <h5 class="project-title mb-3">Sustainable Laboratory Practices</h5>
                        <p class="project-description mb-3">
                            Research on optimizing laboratory energy consumption, waste reduction, and sustainable practices through intelligent monitoring and management systems.
                        </p>
                        <div class="project-meta mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>2022-2023
                                    </small>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-dollar-sign me-1"></i>$1.5M funding
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="project-tags mb-3">
                            <span class="badge bg-light text-dark me-1">Sustainability</span>
                            <span class="badge bg-light text-dark me-1">Energy</span>
                            <span class="badge bg-light text-dark">Green Tech</span>
                        </div>
                        <a href="#" class="btn btn-primary btn-sm">View Results</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Research Partnerships -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Research Partnerships</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Collaborating with leading institutions and organizations to advance scientific research and innovation.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="partnerships-grid" data-aos="fade-up" data-aos-delay="200">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-4">
                            <div class="partner-logo">
                                <div class="logo-placeholder">
                                    <i class="fas fa-university fa-3x text-muted"></i>
                                    <h6 class="mt-2">MIT</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <div class="partner-logo">
                                <div class="logo-placeholder">
                                    <i class="fas fa-graduation-cap fa-3x text-muted"></i>
                                    <h6 class="mt-2">Stanford</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <div class="partner-logo">
                                <div class="logo-placeholder">
                                    <i class="fas fa-atom fa-3x text-muted"></i>
                                    <h6 class="mt-2">CERN</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-4">
                            <div class="partner-logo">
                                <div class="logo-placeholder">
                                    <i class="fas fa-dna fa-3x text-muted"></i>
                                    <h6 class="mt-2">NIH</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Research Impact -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="section-title mb-4">Research Impact & Achievements</h2>
                <p class="lead mb-4">
                    Our research initiatives have made significant contributions to the scientific community and laboratory management practices worldwide.
                </p>

                <div class="impact-metrics">
                    <div class="impact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="impact-icon me-3">
                                <i class="fas fa-trophy text-warning fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">15 Research Awards</h5>
                                <p class="text-muted mb-0">International recognition for innovation</p>
                            </div>
                        </div>
                    </div>

                    <div class="impact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="impact-icon me-3">
                                <i class="fas fa-chart-line text-success fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">40% Efficiency Improvement</h5>
                                <p class="text-muted mb-0">Average lab productivity increase</p>
                            </div>
                        </div>
                    </div>

                    <div class="impact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="impact-icon me-3">
                                <i class="fas fa-globe text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Global Adoption</h5>
                                <p class="text-muted mb-0">Implemented in 50+ countries</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('frontend.publications') }}" class="btn btn-primary-custom">
                    <i class="fas fa-book me-2"></i>View Publications
                </a>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="impact-chart-placeholder">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Research Impact Chart"
                         class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
@include('frontend.partials.cta')

@endsection

@push('styles')
<style>
.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-weight: 500;
    color: var(--text-color);
}

.research-area-card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.research-area-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.progress {
    height: 8px;
    border-radius: 4px;
}

.project-card {
    overflow: hidden;
    transition: all 0.3s ease;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
}

.project-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.project-card:hover .project-image img {
    transform: scale(1.05);
}

.project-status {
    position: absolute;
    top: 15px;
    right: 15px;
}

.project-tags .badge {
    font-size: 0.75rem;
}

.partner-logo {
    padding: 2rem 1rem;
    border: 2px solid transparent;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.partner-logo:hover {
    border-color: var(--primary-color);
    background: rgba(102, 126, 234, 0.05);
}

.impact-item {
    padding: 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.impact-item:hover {
    background: rgba(102, 126, 234, 0.05);
}

@media (max-width: 768px) {
    .stat-number {
        font-size: 2rem;
    }

    .project-image {
        height: 150px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const target = parseInt(counter.dataset.target);
            const duration = 2000;
            const start = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - start;
                const progress = Math.min(elapsed / duration, 1);
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const current = Math.floor(target * easeOutQuart);

                counter.textContent = current;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                }
            }

            requestAnimationFrame(updateCounter);
        });
    }

    // Trigger counter animation when stats section comes into view
    const statsSection = document.querySelector('.research-stats');
    if (statsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(statsSection);
    }

    // Smooth scrolling for hero button
    const exploreButton = document.querySelector('a[href="#research-areas"]');
    if (exploreButton) {
        exploreButton.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('research-areas').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    }

    // Project card interactions
    document.querySelectorAll('.project-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush