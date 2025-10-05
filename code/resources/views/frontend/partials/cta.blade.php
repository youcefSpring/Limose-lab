<!-- Call to Action Section -->
<section class="cta-section section-padding" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="cta-content">
                    <h2 class="section-title mb-4" data-aos="fade-up">
                        Ready to Transform Your Laboratory Management?
                    </h2>
                    <p class="section-subtitle mb-5" data-aos="fade-up" data-aos-delay="100">
                        Join thousands of research institutions worldwide who trust SGLR for their laboratory management needs. Start your free trial today and experience the difference.
                    </p>

                    <div class="cta-buttons mb-5" data-aos="fade-up" data-aos-delay="200">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg me-3 mb-3">
                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                        </a>
                        <a href="{{ route('frontend.contact') }}" class="btn btn-outline-custom btn-lg mb-3">
                            <i class="fas fa-calendar-alt me-2"></i>Schedule Demo
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="trust-indicators" data-aos="fade-up" data-aos-delay="300">
                        <div class="row align-items-center">
                            <div class="col-md-3 col-6 mb-3">
                                <div class="trust-item">
                                    <div class="trust-icon mb-2">
                                        <i class="fas fa-shield-alt text-success"></i>
                                    </div>
                                    <h6 class="trust-title">Secure & Compliant</h6>
                                    <small class="text-muted">ISO 27001 Certified</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="trust-item">
                                    <div class="trust-icon mb-2">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    <h6 class="trust-title">Quick Setup</h6>
                                    <small class="text-muted">Ready in 24 hours</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="trust-item">
                                    <div class="trust-icon mb-2">
                                        <i class="fas fa-headset text-info"></i>
                                    </div>
                                    <h6 class="trust-title">24/7 Support</h6>
                                    <small class="text-muted">Expert assistance</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="trust-item">
                                    <div class="trust-icon mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <h6 class="trust-title">5-Star Rated</h6>
                                    <small class="text-muted">Customer satisfaction</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Statistics -->
        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <div class="cta-stats">
                    <div class="row text-center">
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="stat-card card-custom h-100 p-4">
                                <div class="stat-icon mb-3">
                                    <i class="fas fa-building text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                                <h3 class="stat-number mb-2">
                                    <span class="counter" data-target="500">0</span>+
                                </h3>
                                <p class="stat-label mb-0">Research Institutions</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="500">
                            <div class="stat-card card-custom h-100 p-4">
                                <div class="stat-icon mb-3">
                                    <i class="fas fa-users text-success" style="font-size: 2.5rem;"></i>
                                </div>
                                <h3 class="stat-number mb-2">
                                    <span class="counter" data-target="10000">0</span>+
                                </h3>
                                <p class="stat-label mb-0">Active Researchers</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="600">
                            <div class="stat-card card-custom h-100 p-4">
                                <div class="stat-icon mb-3">
                                    <i class="fas fa-flask text-warning" style="font-size: 2.5rem;"></i>
                                </div>
                                <h3 class="stat-number mb-2">
                                    <span class="counter" data-target="50000">0</span>+
                                </h3>
                                <p class="stat-label mb-0">Experiments Managed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-element element-1">
            <i class="fas fa-atom"></i>
        </div>
        <div class="floating-element element-2">
            <i class="fas fa-dna"></i>
        </div>
        <div class="floating-element element-3">
            <i class="fas fa-microscope"></i>
        </div>
    </div>
</section>

<style>
.cta-section {
    position: relative;
    overflow: hidden;
}

.cta-buttons .btn {
    min-width: 180px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.trust-item {
    text-align: center;
    padding: 1rem;
}

.trust-icon {
    font-size: 2rem;
}

.trust-title {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.25rem;
}

.stat-card {
    border: 2px solid transparent;
    transition: all 0.3s ease;
    background: white;
}

.stat-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(102, 126, 234, 0.2);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--dark-color);
}

.stat-label {
    font-weight: 500;
    color: var(--text-color);
    font-size: 1.1rem;
}

.floating-elements {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
}

.floating-element {
    position: absolute;
    color: rgba(102, 126, 234, 0.1);
    font-size: 4rem;
    animation: float 6s ease-in-out infinite;
}

.element-1 {
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.element-2 {
    top: 20%;
    right: 15%;
    animation-delay: 2s;
}

.element-3 {
    bottom: 15%;
    left: 20%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(10deg);
    }
}

/* Pulse animation for CTA buttons */
.btn-primary-custom {
    position: relative;
    overflow: hidden;
}

.btn-primary-custom::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transition: all 0.6s ease;
    transform: translate(-50%, -50%);
}

.btn-primary-custom:hover::before {
    width: 300px;
    height: 300px;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .cta-buttons {
        text-align: center;
    }

    .cta-buttons .btn {
        width: 100%;
        margin-bottom: 1rem;
        margin-right: 0 !important;
    }

    .trust-indicators .col-6 {
        margin-bottom: 2rem;
    }

    .stat-number {
        font-size: 2rem;
    }

    .floating-element {
        font-size: 2.5rem;
    }

    .section-title {
        font-size: 2rem;
    }
}

/* Loading animation for counters */
.counter {
    display: inline-block;
    font-variant-numeric: tabular-nums;
}

/* Accessibility improvements */
.btn:focus {
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
}

/* Print styles */
@media print {
    .cta-section {
        background: white !important;
    }

    .floating-elements {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation for CTA stats
    function animateCTACounters() {
        const counters = document.querySelectorAll('.cta-section .counter');

        counters.forEach(counter => {
            const target = parseInt(counter.dataset.target);
            const duration = 2500; // 2.5 seconds
            const start = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - start;
                const progress = Math.min(elapsed / duration, 1);

                // Different easing for different numbers
                let easeFunction;
                if (target >= 10000) {
                    easeFunction = 1 - Math.pow(1 - progress, 3); // Ease out cubic for large numbers
                } else {
                    easeFunction = 1 - Math.pow(1 - progress, 4); // Ease out quart for smaller numbers
                }

                const current = Math.floor(target * easeFunction);

                // Format number with commas for readability
                counter.textContent = current.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            }

            requestAnimationFrame(updateCounter);
        });
    }

    // Trigger counter animation when CTA section comes into view
    const ctaSection = document.querySelector('.cta-section');
    if (ctaSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCTACounters();
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        });

        observer.observe(ctaSection);
    }

    // Button click tracking
    document.querySelectorAll('.cta-buttons .btn').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.textContent.trim().toLowerCase().replace(/\s+/g, '_');

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'cta_click', {
                    'cta_action': action,
                    'cta_location': 'main_cta_section'
                });
            }
        });
    });

    // Parallax effect for floating elements
    if (window.innerWidth > 768) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.floating-element');

            parallaxElements.forEach((element, index) => {
                const speed = 0.5 + (index * 0.1);
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });
    }

    // Hover effects for stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });
});
</script>