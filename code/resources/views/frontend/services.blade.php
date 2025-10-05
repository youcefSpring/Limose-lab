@extends('frontend.layouts.app')

@section('title', 'Services - SGLR Laboratory Management System')
@section('description', 'Comprehensive laboratory management services including equipment management, research collaboration tools, and scientific workflow optimization.')
@section('keywords', 'laboratory services, equipment management, research collaboration, scientific workflow, lab automation')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
                        Comprehensive Laboratory Management Services
                    </h1>
                    <p class="lead mb-4" data-aos="fade-right" data-aos-delay="100">
                        Transform your research operations with our suite of advanced laboratory management solutions designed for modern scientific institutions.
                    </p>
                    <div class="hero-buttons" data-aos="fade-right" data-aos-delay="200">
                        <a href="#services-overview" class="btn btn-light btn-lg me-3 mb-3">
                            <i class="fas fa-play me-2"></i>Explore Services
                        </a>
                        <a href="{{ route('frontend.contact') }}" class="btn btn-outline-light btn-lg mb-3">
                            <i class="fas fa-phone me-2"></i>Get Quote
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                         alt="Laboratory Management Services"
                         class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section id="services-overview" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Our Service Portfolio</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    From equipment management to research collaboration, we offer comprehensive solutions that streamline your laboratory operations and enhance research productivity.
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Service Categories -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="service-card card-custom h-100 p-4">
                    <div class="service-icon mb-3">
                        <i class="fas fa-cogs text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="service-title mb-3">Equipment Management</h4>
                    <p class="service-description mb-4">
                        Comprehensive equipment tracking, maintenance scheduling, reservation systems, and usage analytics for optimal resource utilization.
                    </p>
                    <ul class="service-features list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Asset tracking & inventory</li>
                        <li><i class="fas fa-check text-success me-2"></i>Maintenance scheduling</li>
                        <li><i class="fas fa-check text-success me-2"></i>Reservation management</li>
                        <li><i class="fas fa-check text-success me-2"></i>Usage analytics</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="service-card card-custom h-100 p-4">
                    <div class="service-icon mb-3">
                        <i class="fas fa-users text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="service-title mb-3">Collaboration Tools</h4>
                    <p class="service-description mb-4">
                        Advanced collaboration platforms for research teams, project management, and seamless communication across institutions.
                    </p>
                    <ul class="service-features list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Team collaboration</li>
                        <li><i class="fas fa-check text-success me-2"></i>Project management</li>
                        <li><i class="fas fa-check text-success me-2"></i>Document sharing</li>
                        <li><i class="fas fa-check text-success me-2"></i>Communication tools</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="service-card card-custom h-100 p-4">
                    <div class="service-icon mb-3">
                        <i class="fas fa-chart-line text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="service-title mb-3">Analytics & Reporting</h4>
                    <p class="service-description mb-4">
                        Powerful analytics dashboard with customizable reports, performance metrics, and data visualization tools.
                    </p>
                    <ul class="service-features list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Real-time dashboards</li>
                        <li><i class="fas fa-check text-success me-2"></i>Custom reports</li>
                        <li><i class="fas fa-check text-success me-2"></i>Performance metrics</li>
                        <li><i class="fas fa-check text-success me-2"></i>Data visualization</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Detailed Services -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Service Packages</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Choose the perfect package for your laboratory's needs, from small research teams to large institutions.
                </p>
            </div>
        </div>

        <!-- Pricing Cards -->
        <div class="row">
            <!-- Starter Package -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="pricing-card card-custom h-100 text-center p-4">
                    <div class="pricing-header mb-4">
                        <h4 class="package-name">Starter</h4>
                        <div class="package-price">
                            <span class="price-amount">$99</span>
                            <span class="price-period">/month</span>
                        </div>
                        <p class="package-description">Perfect for small research teams</p>
                    </div>

                    <ul class="package-features list-unstyled text-start mb-4">
                        <li><i class="fas fa-check text-success me-2"></i>Up to 10 users</li>
                        <li><i class="fas fa-check text-success me-2"></i>Basic equipment management</li>
                        <li><i class="fas fa-check text-success me-2"></i>Project tracking</li>
                        <li><i class="fas fa-check text-success me-2"></i>Standard reports</li>
                        <li><i class="fas fa-check text-success me-2"></i>Email support</li>
                        <li><i class="fas fa-check text-success me-2"></i>5GB storage</li>
                    </ul>

                    <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">
                        Get Started
                    </a>
                </div>
            </div>

            <!-- Professional Package -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="pricing-card card-custom h-100 text-center p-4 position-relative">
                    <div class="popular-badge">
                        <span class="badge bg-primary">Most Popular</span>
                    </div>

                    <div class="pricing-header mb-4">
                        <h4 class="package-name">Professional</h4>
                        <div class="package-price">
                            <span class="price-amount">$299</span>
                            <span class="price-period">/month</span>
                        </div>
                        <p class="package-description">Ideal for medium-sized institutions</p>
                    </div>

                    <ul class="package-features list-unstyled text-start mb-4">
                        <li><i class="fas fa-check text-success me-2"></i>Up to 50 users</li>
                        <li><i class="fas fa-check text-success me-2"></i>Advanced equipment management</li>
                        <li><i class="fas fa-check text-success me-2"></i>Collaboration tools</li>
                        <li><i class="fas fa-check text-success me-2"></i>Custom reports & analytics</li>
                        <li><i class="fas fa-check text-success me-2"></i>Priority support</li>
                        <li><i class="fas fa-check text-success me-2"></i>50GB storage</li>
                        <li><i class="fas fa-check text-success me-2"></i>API access</li>
                    </ul>

                    <a href="{{ route('register') }}" class="btn btn-primary w-100">
                        Get Started
                    </a>
                </div>
            </div>

            <!-- Enterprise Package -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="pricing-card card-custom h-100 text-center p-4">
                    <div class="pricing-header mb-4">
                        <h4 class="package-name">Enterprise</h4>
                        <div class="package-price">
                            <span class="price-amount">Custom</span>
                            <span class="price-period">pricing</span>
                        </div>
                        <p class="package-description">For large research institutions</p>
                    </div>

                    <ul class="package-features list-unstyled text-start mb-4">
                        <li><i class="fas fa-check text-success me-2"></i>Unlimited users</li>
                        <li><i class="fas fa-check text-success me-2"></i>Full feature access</li>
                        <li><i class="fas fa-check text-success me-2"></i>Custom integrations</li>
                        <li><i class="fas fa-check text-success me-2"></i>Advanced analytics</li>
                        <li><i class="fas fa-check text-success me-2"></i>24/7 dedicated support</li>
                        <li><i class="fas fa-check text-success me-2"></i>Unlimited storage</li>
                        <li><i class="fas fa-check text-success me-2"></i>On-premise deployment</li>
                    </ul>

                    <a href="{{ route('frontend.contact') }}" class="btn btn-outline-primary w-100">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Services -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Additional Services</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Extend your laboratory management capabilities with our specialized services and expert consultation.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="additional-service-card card-custom p-4">
                    <div class="d-flex align-items-start">
                        <div class="service-icon me-4">
                            <i class="fas fa-graduation-cap text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="service-content">
                            <h5 class="service-title mb-3">Training & Consultation</h5>
                            <p class="service-description mb-3">
                                Expert training programs and consultation services to maximize your team's productivity with our platform.
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>On-site training</li>
                                <li><i class="fas fa-check text-success me-2"></i>Online workshops</li>
                                <li><i class="fas fa-check text-success me-2"></i>Best practices consultation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="additional-service-card card-custom p-4">
                    <div class="d-flex align-items-start">
                        <div class="service-icon me-4">
                            <i class="fas fa-code text-success" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="service-content">
                            <h5 class="service-title mb-3">Custom Integration</h5>
                            <p class="service-description mb-3">
                                Seamlessly integrate SGLR with your existing systems and develop custom modules for specific requirements.
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>API development</li>
                                <li><i class="fas fa-check text-success me-2"></i>System integration</li>
                                <li><i class="fas fa-check text-success me-2"></i>Custom modules</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="additional-service-card card-custom p-4">
                    <div class="d-flex align-items-start">
                        <div class="service-icon me-4">
                            <i class="fas fa-shield-alt text-info" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="service-content">
                            <h5 class="service-title mb-3">Security & Compliance</h5>
                            <p class="service-description mb-3">
                                Comprehensive security audits and compliance assistance for regulatory requirements in research environments.
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Security audits</li>
                                <li><i class="fas fa-check text-success me-2"></i>Compliance assistance</li>
                                <li><i class="fas fa-check text-success me-2"></i>Data protection</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="additional-service-card card-custom p-4">
                    <div class="d-flex align-items-start">
                        <div class="service-icon me-4">
                            <i class="fas fa-database text-warning" style="font-size: 2.5rem;"></i>
                        </div>
                        <div class="service-content">
                            <h5 class="service-title mb-3">Data Migration</h5>
                            <p class="service-description mb-3">
                                Smooth transition from legacy systems with our comprehensive data migration and validation services.
                            </p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Data migration</li>
                                <li><i class="fas fa-check text-success me-2"></i>Quality validation</li>
                                <li><i class="fas fa-check text-success me-2"></i>System transition</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Service Comparison -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Service Comparison</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Compare our service packages to find the perfect fit for your laboratory's requirements.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200">
                <div class="comparison-table-wrapper">
                    <div class="table-responsive">
                        <table class="table table-striped comparison-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Features</th>
                                    <th class="text-center">Starter</th>
                                    <th class="text-center">Professional</th>
                                    <th class="text-center">Enterprise</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Users</strong></td>
                                    <td class="text-center">Up to 10</td>
                                    <td class="text-center">Up to 50</td>
                                    <td class="text-center">Unlimited</td>
                                </tr>
                                <tr>
                                    <td><strong>Equipment Management</strong></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td><strong>Project Tracking</strong></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td><strong>Collaboration Tools</strong></td>
                                    <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td><strong>Advanced Analytics</strong></td>
                                    <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td><strong>API Access</strong></td>
                                    <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td><strong>Custom Integrations</strong></td>
                                    <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                    <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                </tr>
                                <tr>
                                    <td><strong>24/7 Support</strong></td>
                                    <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                    <td class="text-center"><i class="fas fa-times text-danger"></i></td>
                                    <td class="text-center"><i class="fas fa-check text-success"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="hero-pattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23hero-pattern)"/></svg>');
    pointer-events: none;
}

.service-card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.service-card:hover {
    border-color: var(--primary-color);
    box-shadow: 0 15px 45px rgba(102, 126, 234, 0.2);
}

.pricing-card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
    position: relative;
}

.pricing-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.popular-badge {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
}

.package-price {
    margin: 1rem 0;
}

.price-amount {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
}

.price-period {
    font-size: 1rem;
    color: var(--text-color);
}

.comparison-table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.comparison-table th,
.comparison-table td {
    padding: 1rem;
    vertical-align: middle;
}

.additional-service-card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.additional-service-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-3px);
}

@media (max-width: 768px) {
    .hero-section {
        padding: 100px 0 60px;
    }

    .price-amount {
        font-size: 2rem;
    }

    .comparison-table-wrapper {
        overflow-x: auto;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for hero button
    document.querySelector('a[href="#services-overview"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('services-overview').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    // Package selection tracking
    document.querySelectorAll('.pricing-card .btn').forEach(button => {
        button.addEventListener('click', function() {
            const packageName = this.closest('.pricing-card').querySelector('.package-name').textContent;

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'package_selected', {
                    'package_name': packageName.toLowerCase(),
                    'page_location': window.location.href
                });
            }
        });
    });
});
</script>
@endpush