<footer class="footer-custom">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-brand mb-4">
                    <h3 class="footer-title">
                        <i class="fas fa-flask me-2"></i>SGLR
                    </h3>
                    <p class="mb-4">Advanced laboratory management solutions for research institutions and scientific organizations worldwide. Streamline your research operations with our comprehensive platform.</p>
                </div>

                <div class="contact-info">
                    <div class="contact-item mb-3">
                        <i class="fas fa-map-marker-alt me-3"></i>
                        <span>123 Science Park Drive<br>Research City, RC 12345</span>
                    </div>
                    <div class="contact-item mb-3">
                        <i class="fas fa-phone me-3"></i>
                        <span>+1 (555) 123-4567</span>
                    </div>
                    <div class="contact-item mb-3">
                        <i class="fas fa-envelope me-3"></i>
                        <span>info@sglr.com</span>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="social-links mt-4">
                    <a href="#" class="social-icon" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title">Company</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('frontend.about') }}" class="footer-link">About Us</a></li>
                    <li><a href="{{ route('frontend.team') }}" class="footer-link">Our Team</a></li>
                    <li><a href="{{ route('frontend.careers') }}" class="footer-link">Careers</a></li>
                    <li><a href="{{ route('frontend.news') }}" class="footer-link">News & Blog</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="footer-link">Contact Us</a></li>
                </ul>
            </div>

            <!-- Solutions -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title">Solutions</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('frontend.services') }}" class="footer-link">Services</a></li>
                    <li><a href="{{ route('frontend.research') }}" class="footer-link">Research</a></li>
                    <li><a href="{{ route('frontend.publications') }}" class="footer-link">Publications</a></li>
                    <li><a href="#" class="footer-link">Equipment Management</a></li>
                    <li><a href="#" class="footer-link">Collaboration Tools</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title">Resources</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="footer-link">Documentation</a></li>
                    <li><a href="#" class="footer-link">API Reference</a></li>
                    <li><a href="#" class="footer-link">Support Center</a></li>
                    <li><a href="#" class="footer-link">Training</a></li>
                    <li><a href="#" class="footer-link">Webinars</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="footer-title">Stay Updated</h5>
                <p class="mb-3">Subscribe to our newsletter for the latest updates and insights.</p>

                <form class="newsletter-form" id="newsletterForm">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your email" required>
                        <button class="btn btn-primary-custom" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>

                <div class="newsletter-links mt-3">
                    <small class="text-muted">
                        <a href="{{ route('frontend.privacy') }}" class="footer-link">Privacy Policy</a> •
                        <a href="{{ route('frontend.terms') }}" class="footer-link">Terms of Service</a>
                    </small>
                </div>
            </div>
        </div>

        <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.1);">

        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0 text-muted">
                    &copy; {{ date('Y') }} SGLR Laboratory Management System. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="footer-badges">
                    <span class="badge bg-success me-2">
                        <i class="fas fa-shield-alt me-1"></i>Secure
                    </span>
                    <span class="badge bg-info me-2">
                        <i class="fas fa-cloud me-1"></i>Cloud-Based
                    </span>
                    <span class="badge bg-warning">
                        <i class="fas fa-award me-1"></i>ISO Certified
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>
</footer>

<style>
.footer-custom {
    position: relative;
    overflow: hidden;
}

.footer-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    pointer-events: none;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    color: #cbd5e0;
}

.contact-item i {
    color: var(--accent-color);
    margin-top: 0.2rem;
    width: 20px;
}

.newsletter-form .form-control {
    border: 2px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
    color: white;
    border-radius: 8px 0 0 8px;
}

.newsletter-form .form-control:focus {
    border-color: var(--primary-color);
    background: rgba(255, 255, 255, 0.1);
    box-shadow: none;
    color: white;
}

.newsletter-form .form-control::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.newsletter-form .btn {
    border-radius: 0 8px 8px 0;
    border: 2px solid var(--primary-color);
}

.footer-badges .badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}

.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
    z-index: 1000;
    cursor: pointer;
}

.back-to-top:hover {
    background: var(--secondary-color);
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
}

.back-to-top.show {
    display: flex;
}

@media (max-width: 768px) {
    .footer-custom {
        padding: 40px 0 20px;
    }

    .footer-title {
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .contact-info {
        margin-bottom: 2rem;
    }

    .social-links {
        text-align: center;
        margin-bottom: 2rem;
    }

    .newsletter-form {
        margin-bottom: 1rem;
    }

    .back-to-top {
        bottom: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
    }

    .footer-badges {
        text-align: center;
        margin-top: 1rem;
    }
}

/* Loading animation for newsletter form */
.newsletter-form.loading .btn {
    pointer-events: none;
}

.newsletter-form.loading .btn i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Back to top button functionality
    const backToTopButton = document.getElementById('backToTop');

    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Newsletter form submission
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const emailInput = this.querySelector('input[type="email"]');
            const submitButton = this.querySelector('button[type="submit"]');
            const email = emailInput.value.trim();

            if (!email) {
                return;
            }

            // Add loading state
            this.classList.add('loading');
            submitButton.disabled = true;

            // Simulate API call (replace with actual newsletter subscription logic)
            setTimeout(() => {
                // Remove loading state
                this.classList.remove('loading');
                submitButton.disabled = false;

                // Show success message
                emailInput.value = '';
                emailInput.placeholder = 'Thank you for subscribing!';

                // Reset placeholder after 3 seconds
                setTimeout(() => {
                    emailInput.placeholder = 'Your email';
                }, 3000);
            }, 1500);
        });
    }

    // Smooth scrolling for footer links
    document.querySelectorAll('.footer-link').forEach(link => {
        if (link.getAttribute('href').startsWith('#')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        }
    });
});
</script>