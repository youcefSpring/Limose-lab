@extends('frontend.layouts.app')

@section('title', 'Careers - SGLR Laboratory Management System')
@section('description', 'Join SGLR and help shape the future of laboratory management. Explore career opportunities in research, engineering, and innovation.')
@section('keywords', 'SGLR careers, laboratory management jobs, research positions, software engineering careers, scientific careers')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">
                        Build Your Career with SGLR
                    </h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        Join a dynamic team of innovators dedicated to transforming scientific research through cutting-edge technology and collaboration.
                    </p>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                        <a href="#open-positions" class="btn btn-light btn-lg me-3 mb-3">
                            <i class="fas fa-search me-2"></i>Browse Jobs
                        </a>
                        <a href="#company-culture" class="btn btn-outline-light btn-lg mb-3">
                            <i class="fas fa-heart me-2"></i>Our Culture
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Join SGLR -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Why Choose SGLR?</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Discover what makes SGLR an exceptional place to build your career and make a meaningful impact in scientific research.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="benefit-card card-custom text-center p-4 h-100">
                    <div class="benefit-icon mb-3">
                        <i class="fas fa-lightbulb text-warning fa-3x"></i>
                    </div>
                    <h5 class="mb-3">Innovation First</h5>
                    <p class="mb-0">Work on cutting-edge projects that push the boundaries of laboratory management and scientific research.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="benefit-card card-custom text-center p-4 h-100">
                    <div class="benefit-icon mb-3">
                        <i class="fas fa-users text-primary fa-3x"></i>
                    </div>
                    <h5 class="mb-3">Collaborative Culture</h5>
                    <p class="mb-0">Join a diverse, inclusive team where every voice matters and collaboration drives our success.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="benefit-card card-custom text-center p-4 h-100">
                    <div class="benefit-icon mb-3">
                        <i class="fas fa-graduation-cap text-success fa-3x"></i>
                    </div>
                    <h5 class="mb-3">Continuous Learning</h5>
                    <p class="mb-0">Access to conferences, training programs, and educational resources to advance your skills and career.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Open Positions -->
<section id="open-positions" class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Open Positions</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Explore current opportunities to join our growing team and make your mark in laboratory technology.
                </p>
            </div>
        </div>

        <!-- Job Filters -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="job-filters text-center" data-aos="fade-up">
                    <button class="btn btn-outline-primary me-2 mb-2 filter-btn active" data-filter="all">All Positions</button>
                    <button class="btn btn-outline-primary me-2 mb-2 filter-btn" data-filter="engineering">Engineering</button>
                    <button class="btn btn-outline-primary me-2 mb-2 filter-btn" data-filter="research">Research</button>
                    <button class="btn btn-outline-primary me-2 mb-2 filter-btn" data-filter="product">Product</button>
                    <button class="btn btn-outline-primary me-2 mb-2 filter-btn" data-filter="business">Business</button>
                </div>
            </div>
        </div>

        <div class="row" id="jobListings">
            <!-- Job 1 -->
            <div class="col-lg-6 mb-4 job-item" data-category="engineering" data-aos="fade-up" data-aos-delay="100">
                <div class="job-card card-custom p-4 h-100">
                    <div class="job-header mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="job-title mb-2">Senior Backend Engineer</h5>
                                <p class="job-department text-muted mb-0">Engineering • Full-time • Remote</p>
                            </div>
                            <span class="badge bg-success">New</span>
                        </div>
                    </div>
                    <p class="job-description mb-3">
                        Join our backend team to build scalable microservices and APIs that power laboratory management for thousands of researchers worldwide.
                    </p>
                    <div class="job-requirements mb-3">
                        <h6>Key Requirements:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>5+ years Python/Django experience</li>
                            <li><i class="fas fa-check text-success me-2"></i>Microservices architecture</li>
                            <li><i class="fas fa-check text-success me-2"></i>Cloud platforms (AWS/GCP)</li>
                        </ul>
                    </div>
                    <div class="job-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>San Francisco, CA
                        </small>
                        <a href="#" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>

            <!-- Job 2 -->
            <div class="col-lg-6 mb-4 job-item" data-category="research" data-aos="fade-up" data-aos-delay="200">
                <div class="job-card card-custom p-4 h-100">
                    <div class="job-header mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="job-title mb-2">AI Research Scientist</h5>
                                <p class="job-department text-muted mb-0">Research • Full-time • Hybrid</p>
                            </div>
                            <span class="badge bg-primary">Featured</span>
                        </div>
                    </div>
                    <p class="job-description mb-3">
                        Lead research initiatives in machine learning applications for laboratory automation and scientific workflow optimization.
                    </p>
                    <div class="job-requirements mb-3">
                        <h6>Key Requirements:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>PhD in AI/ML or related field</li>
                            <li><i class="fas fa-check text-success me-2"></i>Published research papers</li>
                            <li><i class="fas fa-check text-success me-2"></i>TensorFlow/PyTorch expertise</li>
                        </ul>
                    </div>
                    <div class="job-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>Boston, MA
                        </small>
                        <a href="#" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>

            <!-- Job 3 -->
            <div class="col-lg-6 mb-4 job-item" data-category="product" data-aos="fade-up" data-aos-delay="300">
                <div class="job-card card-custom p-4 h-100">
                    <div class="job-header mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="job-title mb-2">Product Manager</h5>
                                <p class="job-department text-muted mb-0">Product • Full-time • Remote</p>
                            </div>
                        </div>
                    </div>
                    <p class="job-description mb-3">
                        Drive product strategy and roadmap for our laboratory management platform, working closely with engineering and research teams.
                    </p>
                    <div class="job-requirements mb-3">
                        <h6>Key Requirements:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>5+ years product management</li>
                            <li><i class="fas fa-check text-success me-2"></i>B2B SaaS experience</li>
                            <li><i class="fas fa-check text-success me-2"></i>Scientific background preferred</li>
                        </ul>
                    </div>
                    <div class="job-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>Austin, TX
                        </small>
                        <a href="#" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>

            <!-- Job 4 -->
            <div class="col-lg-6 mb-4 job-item" data-category="business" data-aos="fade-up" data-aos-delay="400">
                <div class="job-card card-custom p-4 h-100">
                    <div class="job-header mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="job-title mb-2">Sales Development Representative</h5>
                                <p class="job-department text-muted mb-0">Sales • Full-time • Remote</p>
                            </div>
                        </div>
                    </div>
                    <p class="job-description mb-3">
                        Generate and qualify leads for our sales team while building relationships with research institutions and laboratories.
                    </p>
                    <div class="job-requirements mb-3">
                        <h6>Key Requirements:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>2+ years B2B sales experience</li>
                            <li><i class="fas fa-check text-success me-2"></i>Excellent communication skills</li>
                            <li><i class="fas fa-check text-success me-2"></i>CRM proficiency</li>
                        </ul>
                    </div>
                    <div class="job-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>New York, NY
                        </small>
                        <a href="#" class="btn btn-primary">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Open Positions Message -->
        <div class="row" id="noJobsMessage" style="display: none;">
            <div class="col-lg-8 mx-auto text-center">
                <p class="text-muted">No positions match your filter criteria. Try selecting a different category.</p>
            </div>
        </div>
    </div>
</section>

<!-- Company Culture -->
<section id="company-culture" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Our Culture & Values</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    At SGLR, we believe that great products come from great people working together toward a common mission.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-5" data-aos="fade-right">
                <h4 class="mb-4">What Drives Us</h4>
                <div class="value-item mb-4">
                    <div class="d-flex align-items-start">
                        <div class="value-icon me-3">
                            <i class="fas fa-rocket text-primary fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-2">Innovation & Excellence</h6>
                            <p class="text-muted mb-0">We strive for excellence in everything we do, pushing boundaries and challenging conventional thinking.</p>
                        </div>
                    </div>
                </div>

                <div class="value-item mb-4">
                    <div class="d-flex align-items-start">
                        <div class="value-icon me-3">
                            <i class="fas fa-handshake text-success fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-2">Collaboration & Respect</h6>
                            <p class="text-muted mb-0">We value diverse perspectives and believe that collaboration leads to better solutions.</p>
                        </div>
                    </div>
                </div>

                <div class="value-item mb-4">
                    <div class="d-flex align-items-start">
                        <div class="value-icon me-3">
                            <i class="fas fa-globe text-info fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-2">Global Impact</h6>
                            <p class="text-muted mb-0">Our work enables scientific breakthroughs that benefit humanity worldwide.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="culture-image">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Team Collaboration"
                         class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits & Perks -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Benefits & Perks</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    We invest in our team's success, well-being, and professional growth.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="perk-card text-center p-4">
                    <i class="fas fa-heart text-danger fa-2x mb-3"></i>
                    <h6 class="mb-3">Health & Wellness</h6>
                    <ul class="list-unstyled text-muted">
                        <li>Comprehensive health insurance</li>
                        <li>Mental health support</li>
                        <li>Fitness stipend</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="perk-card text-center p-4">
                    <i class="fas fa-clock text-primary fa-2x mb-3"></i>
                    <h6 class="mb-3">Work-Life Balance</h6>
                    <ul class="list-unstyled text-muted">
                        <li>Flexible working hours</li>
                        <li>Remote work options</li>
                        <li>Unlimited PTO</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="perk-card text-center p-4">
                    <i class="fas fa-money-bill-wave text-success fa-2x mb-3"></i>
                    <h6 class="mb-3">Financial Benefits</h6>
                    <ul class="list-unstyled text-muted">
                        <li>Competitive salary</li>
                        <li>Equity participation</li>
                        <li>401(k) matching</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Application Process -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Application Process</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Our streamlined hiring process is designed to help us get to know each other better.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="process-step text-center">
                    <div class="step-number mb-3">1</div>
                    <h6 class="mb-3">Apply Online</h6>
                    <p class="text-muted">Submit your application through our online portal</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="process-step text-center">
                    <div class="step-number mb-3">2</div>
                    <h6 class="mb-3">Initial Screening</h6>
                    <p class="text-muted">Phone or video call with our recruiting team</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="process-step text-center">
                    <div class="step-number mb-3">3</div>
                    <h6 class="mb-3">Technical Interview</h6>
                    <p class="text-muted">Deep dive into your skills and experience</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="process-step text-center">
                    <div class="step-number mb-3">4</div>
                    <h6 class="mb-3">Final Decision</h6>
                    <p class="text-muted">Reference check and offer discussion</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.benefit-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.benefit-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.job-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.job-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.job-item {
    transition: opacity 0.3s ease;
}

.job-item.hidden {
    opacity: 0;
    pointer-events: none;
}

.perk-card {
    background: white;
    border-radius: 12px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.perk-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.process-step .step-number {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0 auto;
}

.value-item {
    padding: 1rem 0;
}

@media (max-width: 768px) {
    .job-filters {
        text-align: left;
    }

    .filter-btn {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Job filtering functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const jobItems = document.querySelectorAll('.job-item');
    const noJobsMessage = document.getElementById('noJobsMessage');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.filter;
            let visibleCount = 0;

            // Filter job items
            jobItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.classList.remove('hidden');
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        if (item.classList.contains('hidden')) {
                            item.style.display = 'none';
                        }
                    }, 300);
                }
            });

            // Show/hide no jobs message
            if (visibleCount === 0) {
                noJobsMessage.style.display = 'block';
            } else {
                noJobsMessage.style.display = 'none';
            }

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'job_filter', {
                    'category': category
                });
            }
        });
    });

    // Apply button tracking
    document.querySelectorAll('.job-card .btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const jobTitle = this.closest('.job-card').querySelector('.job-title').textContent;

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'job_application_start', {
                    'job_title': jobTitle
                });
            }

            // Show application message
            alert(`Application process for "${jobTitle}" would start here.`);
        });
    });

    // Smooth scrolling for hero buttons
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
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
});
</script>
@endpush