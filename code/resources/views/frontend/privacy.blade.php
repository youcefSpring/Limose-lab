@extends('frontend.layouts.app')

@section('title', 'Privacy Policy - SGLR Laboratory Management System')
@section('description', 'Learn how SGLR protects your privacy and handles data in our laboratory management platform. Comprehensive privacy policy and data protection information.')
@section('keywords', 'SGLR privacy policy, data protection, laboratory data security, privacy rights, GDPR compliance')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">
                        Privacy Policy
                    </h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        Your privacy is important to us. Learn how we collect, use, and protect your information.
                    </p>
                    <div class="last-updated" data-aos="fade-up" data-aos-delay="200">
                        <small class="badge bg-light text-dark">Last updated: December 15, 2024</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Table of Contents -->
            <div class="col-lg-3">
                <div class="toc-wrapper position-sticky" style="top: 100px;">
                    <div class="card-custom p-4">
                        <h6 class="mb-3">Table of Contents</h6>
                        <nav class="toc-nav">
                            <ul class="list-unstyled">
                                <li><a href="#information-collection" class="toc-link">1. Information We Collect</a></li>
                                <li><a href="#how-we-use" class="toc-link">2. How We Use Information</a></li>
                                <li><a href="#information-sharing" class="toc-link">3. Information Sharing</a></li>
                                <li><a href="#data-security" class="toc-link">4. Data Security</a></li>
                                <li><a href="#data-retention" class="toc-link">5. Data Retention</a></li>
                                <li><a href="#your-rights" class="toc-link">6. Your Rights</a></li>
                                <li><a href="#cookies" class="toc-link">7. Cookies & Tracking</a></li>
                                <li><a href="#international-transfers" class="toc-link">8. International Transfers</a></li>
                                <li><a href="#changes" class="toc-link">9. Policy Changes</a></li>
                                <li><a href="#contact" class="toc-link">10. Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="privacy-content">
                    <!-- Introduction -->
                    <div class="content-section mb-5">
                        <p class="lead">SGLR Laboratory Management System ("SGLR," "we," "us," or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our laboratory management platform and related services.</p>
                    </div>

                    <!-- 1. Information We Collect -->
                    <div id="information-collection" class="content-section mb-5">
                        <h3 class="section-heading mb-4">1. Information We Collect</h3>
                        
                        <h5 class="mb-3">Personal Information</h5>
                        <p>We collect personal information that you provide directly to us, including:</p>
                        <ul>
                            <li><strong>Account Information:</strong> Name, email address, phone number, job title, and organization details</li>
                            <li><strong>Profile Information:</strong> Professional background, research interests, and bio information</li>
                            <li><strong>Communication Data:</strong> Messages, support requests, and feedback you send to us</li>
                            <li><strong>Payment Information:</strong> Billing details and payment method information (processed securely by third-party providers)</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Research and Laboratory Data</h5>
                        <p>Through your use of our platform, we may collect:</p>
                        <ul>
                            <li><strong>Project Data:</strong> Research project information, timelines, and collaboration details</li>
                            <li><strong>Equipment Data:</strong> Equipment usage logs, maintenance records, and reservation information</li>
                            <li><strong>Publication Data:</strong> Research papers, datasets, and publication metadata</li>
                            <li><strong>Collaboration Data:</strong> Team member interactions and shared research activities</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Technical Information</h5>
                        <p>We automatically collect certain technical information:</p>
                        <ul>
                            <li><strong>Usage Data:</strong> How you interact with our platform, features used, and time spent</li>
                            <li><strong>Device Information:</strong> IP address, browser type, operating system, and device identifiers</li>
                            <li><strong>Log Data:</strong> Server logs, error reports, and performance metrics</li>
                        </ul>
                    </div>

                    <!-- 2. How We Use Information -->
                    <div id="how-we-use" class="content-section mb-5">
                        <h3 class="section-heading mb-4">2. How We Use Information</h3>
                        
                        <p>We use the collected information for the following purposes:</p>
                        
                        <h5 class="mb-3">Service Provision</h5>
                        <ul>
                            <li>Provide, operate, and maintain our laboratory management platform</li>
                            <li>Process transactions and manage your account</li>
                            <li>Enable collaboration and communication features</li>
                            <li>Provide customer support and respond to inquiries</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Platform Improvement</h5>
                        <ul>
                            <li>Analyze usage patterns to improve our services</li>
                            <li>Develop new features and functionality</li>
                            <li>Conduct research and analytics to enhance user experience</li>
                            <li>Monitor and improve platform security and performance</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Communication</h5>
                        <ul>
                            <li>Send important updates about our services</li>
                            <li>Provide technical support and assistance</li>
                            <li>Share relevant research insights and industry news (with consent)</li>
                            <li>Respond to your requests and communications</li>
                        </ul>
                    </div>

                    <!-- 3. Information Sharing -->
                    <div id="information-sharing" class="content-section mb-5">
                        <h3 class="section-heading mb-4">3. Information Sharing and Disclosure</h3>
                        
                        <p>We do not sell, trade, or rent your personal information. We may share information in the following circumstances:</p>
                        
                        <h5 class="mb-3">With Your Consent</h5>
                        <p>We share information when you explicitly consent to such sharing, such as collaborating with other researchers or institutions.</p>

                        <h5 class="mb-3 mt-4">Service Providers</h5>
                        <p>We work with trusted third-party service providers who help us operate our platform:</p>
                        <ul>
                            <li>Cloud hosting and infrastructure providers</li>
                            <li>Payment processing services</li>
                            <li>Analytics and monitoring tools</li>
                            <li>Customer support platforms</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Legal Requirements</h5>
                        <p>We may disclose information if required by law or to:</p>
                        <ul>
                            <li>Comply with legal processes or government requests</li>
                            <li>Protect our rights, property, or safety</li>
                            <li>Prevent fraud or security threats</li>
                            <li>Enforce our terms of service</li>
                        </ul>
                    </div>

                    <!-- 4. Data Security -->
                    <div id="data-security" class="content-section mb-5">
                        <h3 class="section-heading mb-4">4. Data Security</h3>
                        
                        <p>We implement comprehensive security measures to protect your information:</p>
                        
                        <div class="security-measures">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="security-item">
                                        <i class="fas fa-shield-alt text-primary me-2"></i>
                                        <strong>Encryption:</strong> Data encrypted in transit and at rest
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="security-item">
                                        <i class="fas fa-lock text-success me-2"></i>
                                        <strong>Access Controls:</strong> Multi-factor authentication and role-based access
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="security-item">
                                        <i class="fas fa-eye text-info me-2"></i>
                                        <strong>Monitoring:</strong> 24/7 security monitoring and threat detection
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="security-item">
                                        <i class="fas fa-certificate text-warning me-2"></i>
                                        <strong>Compliance:</strong> SOC 2 Type II and ISO 27001 certified
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="mt-3">While we implement robust security measures, no system is completely secure. We continuously monitor and update our security practices to protect your data.</p>
                    </div>

                    <!-- 5. Data Retention -->
                    <div id="data-retention" class="content-section mb-5">
                        <h3 class="section-heading mb-4">5. Data Retention</h3>
                        
                        <p>We retain your information for as long as necessary to provide our services and fulfill the purposes outlined in this policy:</p>
                        
                        <ul>
                            <li><strong>Account Data:</strong> Retained while your account is active and for a reasonable period afterward</li>
                            <li><strong>Research Data:</strong> Retained according to your preferences and applicable research data retention requirements</li>
                            <li><strong>Communication Records:</strong> Retained for customer support and legal compliance purposes</li>
                            <li><strong>Technical Logs:</strong> Typically retained for 12-24 months for security and operational purposes</li>
                        </ul>
                        
                        <p>You can request deletion of your data at any time, subject to legal and contractual obligations.</p>
                    </div>

                    <!-- 6. Your Rights -->
                    <div id="your-rights" class="content-section mb-5">
                        <h3 class="section-heading mb-4">6. Your Privacy Rights</h3>
                        
                        <p>Depending on your location, you may have the following rights regarding your personal information:</p>
                        
                        <div class="rights-grid">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="right-item">
                                        <h6><i class="fas fa-eye text-primary me-2"></i>Right to Access</h6>
                                        <p class="small text-muted">Request copies of your personal data</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="right-item">
                                        <h6><i class="fas fa-edit text-success me-2"></i>Right to Rectification</h6>
                                        <p class="small text-muted">Correct inaccurate or incomplete data</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="right-item">
                                        <h6><i class="fas fa-trash text-danger me-2"></i>Right to Erasure</h6>
                                        <p class="small text-muted">Request deletion of your personal data</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="right-item">
                                        <h6><i class="fas fa-download text-info me-2"></i>Right to Portability</h6>
                                        <p class="small text-muted">Export your data in a portable format</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <p>To exercise these rights, contact us at <a href="mailto:privacy@sglr.com">privacy@sglr.com</a>. We will respond to your request within 30 days.</p>
                    </div>

                    <!-- 7. Cookies -->
                    <div id="cookies" class="content-section mb-5">
                        <h3 class="section-heading mb-4">7. Cookies and Tracking Technologies</h3>
                        
                        <p>We use cookies and similar technologies to enhance your experience:</p>
                        
                        <h5 class="mb-3">Essential Cookies</h5>
                        <p>Required for basic platform functionality, including authentication and security features.</p>
                        
                        <h5 class="mb-3 mt-4">Analytics Cookies</h5>
                        <p>Help us understand how you use our platform to improve performance and user experience.</p>
                        
                        <h5 class="mb-3 mt-4">Functional Cookies</h5>
                        <p>Remember your preferences and settings to provide a personalized experience.</p>
                        
                        <p class="mt-3">You can control cookie settings through your browser preferences. Note that disabling certain cookies may limit platform functionality.</p>
                    </div>

                    <!-- 8. International Transfers -->
                    <div id="international-transfers" class="content-section mb-5">
                        <h3 class="section-heading mb-4">8. International Data Transfers</h3>
                        
                        <p>SGLR operates globally, and your information may be transferred to and processed in countries other than your own. We ensure adequate protection through:</p>
                        
                        <ul>
                            <li>Standard Contractual Clauses approved by relevant authorities</li>
                            <li>Adequacy decisions for data transfers to certain countries</li>
                            <li>Appropriate safeguards and security measures</li>
                            <li>Regular compliance audits and assessments</li>
                        </ul>
                    </div>

                    <!-- 9. Changes -->
                    <div id="changes" class="content-section mb-5">
                        <h3 class="section-heading mb-4">9. Changes to This Privacy Policy</h3>
                        
                        <p>We may update this Privacy Policy periodically to reflect changes in our practices or legal requirements. We will:</p>
                        
                        <ul>
                            <li>Notify you of material changes via email or platform notification</li>
                            <li>Update the "Last Modified" date at the top of this policy</li>
                            <li>Provide at least 30 days' notice for significant changes</li>
                            <li>Maintain previous versions for reference</li>
                        </ul>
                    </div>

                    <!-- 10. Contact -->
                    <div id="contact" class="content-section mb-5">
                        <h3 class="section-heading mb-4">10. Contact Information</h3>
                        
                        <p>If you have questions about this Privacy Policy or our data practices, please contact us:</p>
                        
                        <div class="contact-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Privacy Officer</h6>
                                    <p>
                                        <i class="fas fa-envelope me-2"></i>privacy@sglr.com<br>
                                        <i class="fas fa-phone me-2"></i>+1 (555) 123-4567
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Mailing Address</h6>
                                    <p>
                                        SGLR Laboratory Management System<br>
                                        123 Science Park Drive<br>
                                        Research City, RC 12345<br>
                                        United States
                                    </p>
                                </div>
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
.toc-link {
    display: block;
    padding: 0.5rem 0;
    color: var(--text-color);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.toc-link:hover,
.toc-link.active {
    color: var(--primary-color);
}

.section-heading {
    color: var(--dark-color);
    font-weight: 600;
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 0.5rem;
}

.content-section {
    line-height: 1.7;
}

.content-section ul {
    padding-left: 1.5rem;
}

.content-section li {
    margin-bottom: 0.5rem;
}

.security-item,
.right-item {
    padding: 1rem;
    background: var(--light-color);
    border-radius: 8px;
    height: 100%;
}

.contact-info {
    background: var(--light-color);
    padding: 2rem;
    border-radius: 12px;
    margin-top: 1rem;
}

@media (max-width: 991.98px) {
    .toc-wrapper {
        position: relative !important;
        top: auto !important;
        margin-bottom: 2rem;
    }
}

@media (max-width: 768px) {
    .rights-grid .col-md-6,
    .security-measures .col-md-6 {
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for TOC links
    document.querySelectorAll('.toc-link').forEach(link => {
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
    });

    // Update active TOC link on scroll
    const sections = document.querySelectorAll('[id]');
    const tocLinks = document.querySelectorAll('.toc-link');

    function updateActiveTocLink() {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 120;
            if (window.pageYOffset >= sectionTop) {
                current = '#' + section.getAttribute('id');
            }
        });

        tocLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === current) {
                link.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', updateActiveTocLink);
    updateActiveTocLink(); // Initial call
});
</script>
@endpush