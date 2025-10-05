<!-- Newsletter Section -->
<section class="newsletter-section py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-8 mx-auto text-center">
                <div class="newsletter-content text-white">
                    <h3 class="mb-3" data-aos="fade-up">Stay Informed with SGLR</h3>
                    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
                        Get the latest updates on laboratory management trends, research insights, and product announcements delivered directly to your inbox.
                    </p>

                    <form class="newsletter-signup-form" id="mainNewsletterForm" data-aos="fade-up" data-aos-delay="200">
                        @csrf
                        <div class="input-group input-group-lg">
                            <input type="email" class="form-control newsletter-input" placeholder="Enter your email address" required>
                            <button class="btn btn-light btn-newsletter" type="submit">
                                <span class="btn-text">Subscribe</span>
                                <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                        <small class="form-text text-white-50 mt-2 d-block">
                            <i class="fas fa-lock me-1"></i>
                            We respect your privacy. Unsubscribe at any time.
                        </small>
                    </form>

                    <!-- Success/Error Messages -->
                    <div class="newsletter-messages mt-3">
                        <div class="alert alert-success newsletter-success d-none" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Thank you for subscribing! Please check your email to confirm your subscription.
                        </div>
                        <div class="alert alert-danger newsletter-error d-none" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Something went wrong. Please try again later.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Stats -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="newsletter-stats text-center">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                                <h4 class="text-white mb-1">
                                    <span class="counter" data-target="5000">0</span>+
                                </h4>
                                <small class="text-white-50">Newsletter Subscribers</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                                <h4 class="text-white mb-1">
                                    <span class="counter" data-target="150">0</span>+
                                </h4>
                                <small class="text-white-50">Research Updates</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-item" data-aos="fade-up" data-aos-delay="500">
                                <h4 class="text-white mb-1">
                                    <span class="counter" data-target="98">0</span>%
                                </h4>
                                <small class="text-white-50">Satisfaction Rate</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.newsletter-section {
    position: relative;
    overflow: hidden;
}

.newsletter-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="newsletter-grid" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23newsletter-grid)"/></svg>');
    pointer-events: none;
}

.newsletter-input {
    border: 2px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border-radius: 12px 0 0 12px;
    padding: 1rem 1.5rem;
    font-size: 1rem;
    backdrop-filter: blur(10px);
}

.newsletter-input:focus {
    border-color: rgba(255, 255, 255, 0.5);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: none;
    color: white;
}

.newsletter-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.btn-newsletter {
    padding: 1rem 2rem;
    font-weight: 600;
    border-radius: 0 12px 12px 0;
    border: 2px solid white;
    transition: all 0.3s ease;
    background: white;
    color: var(--primary-color);
}

.btn-newsletter:hover {
    background: rgba(255, 255, 255, 0.9);
    color: var(--primary-color);
    transform: translateY(-2px);
}

.btn-newsletter:active {
    transform: translateY(0);
}

.newsletter-signup-form.loading .btn-newsletter {
    pointer-events: none;
}

.newsletter-signup-form.loading .btn-text {
    display: none;
}

.newsletter-signup-form.loading .fa-arrow-right {
    animation: spin 1s linear infinite;
}

.newsletter-success,
.newsletter-error {
    border: none;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.newsletter-success {
    background: rgba(72, 187, 120, 0.9);
    color: white;
}

.newsletter-error {
    background: rgba(245, 101, 101, 0.9);
    color: white;
}

.stat-item h4 {
    font-weight: 700;
    font-size: 2rem;
}

.counter {
    display: inline-block;
}

@media (max-width: 768px) {
    .newsletter-input {
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .btn-newsletter {
        border-radius: 12px;
        width: 100%;
    }

    .input-group {
        flex-direction: column;
    }

    .stat-item h4 {
        font-size: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Newsletter form submission
    const newsletterForm = document.getElementById('mainNewsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const emailInput = this.querySelector('.newsletter-input');
            const submitButton = this.querySelector('.btn-newsletter');
            const successMessage = document.querySelector('.newsletter-success');
            const errorMessage = document.querySelector('.newsletter-error');
            const email = emailInput.value.trim();

            // Hide previous messages
            successMessage.classList.add('d-none');
            errorMessage.classList.add('d-none');

            if (!email) {
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errorMessage.textContent = 'Please enter a valid email address.';
                errorMessage.classList.remove('d-none');
                return;
            }

            // Add loading state
            this.classList.add('loading');
            submitButton.disabled = true;
            emailInput.disabled = true;

            // Simulate API call (replace with actual newsletter subscription logic)
            setTimeout(() => {
                // Remove loading state
                this.classList.remove('loading');
                submitButton.disabled = false;
                emailInput.disabled = false;

                // Simulate success (90% chance) or error (10% chance)
                if (Math.random() > 0.1) {
                    // Success
                    emailInput.value = '';
                    successMessage.classList.remove('d-none');

                    // Track newsletter signup (analytics)
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'newsletter_signup', {
                            'email': email
                        });
                    }
                } else {
                    // Error
                    errorMessage.classList.remove('d-none');
                }
            }, 1500);
        });
    }

    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const target = parseInt(counter.dataset.target);
            const duration = 2000; // 2 seconds
            const start = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - start;
                const progress = Math.min(elapsed / duration, 1);

                // Easing function for smooth animation
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

    // Trigger counter animation when newsletter section comes into view
    const newsletterSection = document.querySelector('.newsletter-section');
    if (newsletterSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(newsletterSection);
    }
});
</script>