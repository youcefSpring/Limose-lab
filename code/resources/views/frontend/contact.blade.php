@extends('frontend.layouts.app')

@section('title', 'Contact Us - SGLR Laboratory Management System')
@section('description', 'Get in touch with SGLR for laboratory management solutions, support, and partnership opportunities. We are here to help you transform your research operations.')
@section('keywords', 'contact SGLR, laboratory management support, scientific software contact, research solutions inquiry')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">
                        Get in Touch with SGLR
                    </h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        Ready to transform your laboratory operations? We're here to help you find the perfect solution for your research needs.
                    </p>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                        <a href="#contact-form" class="btn btn-light btn-lg me-3 mb-3">
                            <i class="fas fa-envelope me-2"></i>Send Message
                        </a>
                        <a href="#contact-info" class="btn btn-outline-light btn-lg mb-3">
                            <i class="fas fa-phone me-2"></i>Call Us Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Options -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Multiple Ways to Reach Us</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Choose the communication method that works best for you. Our team is ready to assist with any questions or requirements.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-option card-custom text-center p-4 h-100">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-phone-alt text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">Phone Support</h5>
                    <p class="mb-3">Speak directly with our experts for immediate assistance and consultations.</p>
                    <div class="contact-details mb-3">
                        <strong>+1 (555) 123-4567</strong><br>
                        <small class="text-muted">Mon-Fri, 9 AM - 6 PM EST</small>
                    </div>
                    <a href="tel:+15551234567" class="btn btn-outline-primary">Call Now</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-option card-custom text-center p-4 h-100">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-envelope text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">Email Support</h5>
                    <p class="mb-3">Send us detailed inquiries and we'll respond within 24 hours.</p>
                    <div class="contact-details mb-3">
                        <strong>info@sglr.com</strong><br>
                        <small class="text-muted">24/7 email support</small>
                    </div>
                    <a href="mailto:info@sglr.com" class="btn btn-outline-success">Send Email</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-option card-custom text-center p-4 h-100">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-comments text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-3">Live Chat</h5>
                    <p class="mb-3">Get instant answers from our support team through live chat.</p>
                    <div class="contact-details mb-3">
                        <strong>Available 24/7</strong><br>
                        <small class="text-muted">Average response: 2 minutes</small>
                    </div>
                    <button class="btn btn-outline-info" id="startLiveChat">Start Chat</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Info -->
<section id="contact-form" class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8 mb-5" data-aos="fade-right">
                <div class="contact-form-wrapper">
                    <h3 class="mb-4">Send Us a Message</h3>
                    <p class="mb-4">Fill out the form below and our team will get back to you within 24 hours.</p>

                    <form id="contactForm" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" required>
                                <div class="invalid-feedback">Please provide a valid first name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" required>
                                <div class="invalid-feedback">Please provide a valid last name.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="company" class="form-label">Organization/Institution</label>
                                <input type="text" class="form-control" id="company" name="company">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jobTitle" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="jobTitle" name="job_title">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="inquiryType" class="form-label">Inquiry Type *</label>
                            <select class="form-select" id="inquiryType" name="inquiry_type" required>
                                <option value="">Select inquiry type...</option>
                                <option value="product_demo">Product Demo</option>
                                <option value="pricing">Pricing Information</option>
                                <option value="technical_support">Technical Support</option>
                                <option value="partnership">Partnership Opportunities</option>
                                <option value="custom_solution">Custom Solution</option>
                                <option value="general">General Inquiry</option>
                            </select>
                            <div class="invalid-feedback">Please select an inquiry type.</div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                            <div class="invalid-feedback">Please provide a subject.</div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            <div class="invalid-feedback">Please provide a message.</div>
                            <div class="form-text">Minimum 10 characters required.</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                <label class="form-check-label" for="newsletter">
                                    Subscribe to our newsletter for updates and insights
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="privacy" name="privacy" required>
                                <label class="form-check-label" for="privacy">
                                    I agree to the <a href="{{ route('frontend.privacy') }}" target="_blank">Privacy Policy</a> and <a href="{{ route('frontend.terms') }}" target="_blank">Terms of Service</a> *
                                </label>
                                <div class="invalid-feedback">You must agree to the privacy policy and terms.</div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom btn-lg">
                            <span class="btn-text">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </span>
                            <span class="btn-loading d-none">
                                <i class="fas fa-spinner fa-spin me-2"></i>Sending...
                            </span>
                        </button>
                    </form>

                    <!-- Success/Error Messages -->
                    <div class="form-messages mt-4">
                        <div class="alert alert-success d-none" id="successMessage" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Thank you for your message! We'll get back to you within 24 hours.
                        </div>
                        <div class="alert alert-danger d-none" id="errorMessage" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            There was an error sending your message. Please try again or contact us directly.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="contact-info-card card-custom p-4 h-100">
                    <h4 class="mb-4">Contact Information</h4>

                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-item-icon me-3">
                                <i class="fas fa-map-marker-alt text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Headquarters</h6>
                                <p class="mb-0 text-muted">
                                    123 Science Park Drive<br>
                                    Research City, RC 12345<br>
                                    United States
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-item-icon me-3">
                                <i class="fas fa-phone text-success fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Phone</h6>
                                <p class="mb-1">
                                    <strong>Sales:</strong> +1 (555) 123-4567<br>
                                    <strong>Support:</strong> +1 (555) 123-4568
                                </p>
                                <small class="text-muted">Mon-Fri, 9 AM - 6 PM EST</small>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-item-icon me-3">
                                <i class="fas fa-envelope text-info fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <p class="mb-0">
                                    <strong>General:</strong> info@sglr.com<br>
                                    <strong>Sales:</strong> sales@sglr.com<br>
                                    <strong>Support:</strong> support@sglr.com
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-item-icon me-3">
                                <i class="fas fa-clock text-warning fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Business Hours</h6>
                                <p class="mb-0 text-muted">
                                    <strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM EST<br>
                                    <strong>Saturday:</strong> 10:00 AM - 4:00 PM EST<br>
                                    <strong>Sunday:</strong> Closed
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Follow Us</h6>
                    <div class="social-links">
                        <a href="#" class="social-link me-2" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link me-2" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link me-2" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link me-2" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Office Locations -->
<section id="contact-info" class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Our Global Presence</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    With offices and partners worldwide, we're always close to you.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="office-card card-custom p-4 text-center h-100">
                    <div class="office-flag mb-3">
                        <i class="fas fa-flag-usa text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3">United States</h5>
                    <p class="mb-3">
                        123 Science Park Drive<br>
                        Research City, RC 12345<br>
                        <strong>Phone:</strong> +1 (555) 123-4567
                    </p>
                    <small class="text-muted">Headquarters & Americas</small>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="office-card card-custom p-4 text-center h-100">
                    <div class="office-flag mb-3">
                        <i class="fas fa-flag text-success fa-2x"></i>
                    </div>
                    <h5 class="mb-3">Europe</h5>
                    <p class="mb-3">
                        45 Innovation Boulevard<br>
                        London, UK SW1A 1AA<br>
                        <strong>Phone:</strong> +44 20 7123 4567
                    </p>
                    <small class="text-muted">European Operations</small>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="office-card card-custom p-4 text-center h-100">
                    <div class="office-flag mb-3">
                        <i class="fas fa-flag text-info fa-2x"></i>
                    </div>
                    <h5 class="mb-3">Asia Pacific</h5>
                    <p class="mb-3">
                        88 Technology Street<br>
                        Singapore 018956<br>
                        <strong>Phone:</strong> +65 6123 4567
                    </p>
                    <small class="text-muted">APAC Operations</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Frequently Asked Questions</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Quick answers to common questions about our services and solutions.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="200">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                How quickly can we implement SGLR in our laboratory?
                            </button>
                        </h3>
                        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Implementation typically takes 2-4 weeks depending on your laboratory size and requirements. Our team provides full support throughout the process, including data migration, training, and system customization.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                What kind of support do you provide?
                            </button>
                        </h3>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer 24/7 technical support, comprehensive training programs, regular system updates, and dedicated account management. Our support team includes laboratory management experts and technical specialists.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                Can SGLR integrate with our existing systems?
                            </button>
                        </h3>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, SGLR offers robust API integration capabilities and can connect with most existing laboratory information systems, equipment databases, and research management platforms. Our team assists with custom integrations as needed.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                Is there a free trial available?
                            </button>
                        </h3>
                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we offer a 30-day free trial with full access to all features. No credit card required. Our team will also provide a personalized demo to show how SGLR can benefit your specific laboratory operations.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.contact-option {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.contact-option:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.contact-form .form-control,
.contact-form .form-select {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.contact-form .form-control:focus,
.contact-form .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.contact-form .form-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.contact-info-card .contact-item {
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.contact-info-card .contact-item:last-child {
    border-bottom: none;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--light-color);
    color: var(--text-color);
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.office-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.office-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.accordion-button {
    font-weight: 600;
    background: var(--light-color);
    border: none;
    border-radius: 8px !important;
    margin-bottom: 0.5rem;
}

.accordion-button:not(.collapsed) {
    background: var(--primary-color);
    color: white;
}

.accordion-item {
    border: none;
    margin-bottom: 1rem;
}

.accordion-body {
    background: white;
    border-radius: 0 0 8px 8px;
    padding: 1.5rem;
}

.form-messages .alert {
    border: none;
    border-radius: 8px;
    padding: 1rem 1.5rem;
}

#contactForm.loading {
    opacity: 0.7;
    pointer-events: none;
}

@media (max-width: 768px) {
    .contact-form-wrapper,
    .contact-info-card {
        margin-bottom: 2rem;
    }

    .hero-buttons .btn {
        width: 100%;
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const contactForm = document.getElementById('contactForm');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Hide previous messages
            successMessage.classList.add('d-none');
            errorMessage.classList.add('d-none');

            // Validate form
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }

            // Validate message length
            const message = document.getElementById('message').value;
            if (message.length < 10) {
                document.getElementById('message').classList.add('is-invalid');
                return;
            }

            // Show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const btnText = submitButton.querySelector('.btn-text');
            const btnLoading = submitButton.querySelector('.btn-loading');

            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            this.classList.add('loading');

            // Simulate form submission (replace with actual form submission)
            setTimeout(() => {
                // Remove loading state
                this.classList.remove('loading');
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');

                // Simulate success (90% chance) or error (10% chance)
                if (Math.random() > 0.1) {
                    // Success
                    successMessage.classList.remove('d-none');
                    this.reset();
                    this.classList.remove('was-validated');

                    // Analytics tracking
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'contact_form_submit', {
                            'form_type': 'contact_us'
                        });
                    }
                } else {
                    // Error
                    errorMessage.classList.remove('d-none');
                }

                // Scroll to message
                successMessage.scrollIntoView({ behavior: 'smooth' });
            }, 2000);
        });

        // Real-time validation
        const inputs = contactForm.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid') && this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });
    }

    // Live chat functionality
    const liveChatButton = document.getElementById('startLiveChat');
    if (liveChatButton) {
        liveChatButton.addEventListener('click', function() {
            // Replace with actual live chat implementation
            alert('Live chat functionality would be integrated here with services like Intercom, Zendesk Chat, or custom solution.');

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'live_chat_start', {
                    'source': 'contact_page'
                });
            }
        });
    }

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

    // Form field auto-completion suggestions
    const companyInput = document.getElementById('company');
    if (companyInput) {
        companyInput.addEventListener('input', function() {
            // Add auto-complete functionality for common institution names
            // This would typically connect to a database of institutions
        });
    }

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            // Format phone number as user types
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{3})(\d{3})/, '($1) $2');
            }
            this.value = value;
        });
    }

    // Track FAQ interactions
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', function() {
            const faqTitle = this.textContent.trim();

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'faq_interaction', {
                    'faq_question': faqTitle
                });
            }
        });
    });
});
</script>
@endpush