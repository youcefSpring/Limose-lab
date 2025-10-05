@extends('frontend.layouts.app')

@section('title', 'Terms of Service - SGLR Laboratory Management System')
@section('description', 'Read the terms of service for SGLR Laboratory Management System. Learn about user rights, responsibilities, and platform usage guidelines.')
@section('keywords', 'SGLR terms of service, user agreement, laboratory management terms, platform usage terms, legal terms')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">
                        Terms of Service
                    </h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        Please read these terms carefully before using our laboratory management platform.
                    </p>
                    <div class="last-updated" data-aos="fade-up" data-aos-delay="200">
                        <small class="badge bg-light text-dark">Last updated: December 15, 2024</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Terms Content -->
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
                                <li><a href="#acceptance" class="toc-link">1. Acceptance of Terms</a></li>
                                <li><a href="#description" class="toc-link">2. Service Description</a></li>
                                <li><a href="#user-accounts" class="toc-link">3. User Accounts</a></li>
                                <li><a href="#acceptable-use" class="toc-link">4. Acceptable Use</a></li>
                                <li><a href="#intellectual-property" class="toc-link">5. Intellectual Property</a></li>
                                <li><a href="#user-content" class="toc-link">6. User Content</a></li>
                                <li><a href="#payment-terms" class="toc-link">7. Payment Terms</a></li>
                                <li><a href="#privacy" class="toc-link">8. Privacy & Data</a></li>
                                <li><a href="#disclaimers" class="toc-link">9. Disclaimers</a></li>
                                <li><a href="#limitation-liability" class="toc-link">10. Limitation of Liability</a></li>
                                <li><a href="#termination" class="toc-link">11. Termination</a></li>
                                <li><a href="#governing-law" class="toc-link">12. Governing Law</a></li>
                                <li><a href="#contact" class="toc-link">13. Contact Information</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="terms-content">
                    <!-- Introduction -->
                    <div class="content-section mb-5">
                        <p class="lead">These Terms of Service ("Terms") govern your access to and use of the SGLR Laboratory Management System platform and related services provided by SGLR Inc. ("SGLR," "we," "us," or "our").</p>
                    </div>

                    <!-- 1. Acceptance of Terms -->
                    <div id="acceptance" class="content-section mb-5">
                        <h3 class="section-heading mb-4">1. Acceptance of Terms</h3>

                        <p>By accessing or using our services, you agree to be bound by these Terms and our Privacy Policy. If you do not agree to these Terms, you may not access or use our services.</p>

                        <p>These Terms constitute a legally binding agreement between you and SGLR. You represent that you have the legal authority to enter into this agreement on behalf of yourself or the organization you represent.</p>

                        <h5 class="mb-3 mt-4">Updates to Terms</h5>
                        <p>We may modify these Terms from time to time. We will notify you of material changes at least 30 days in advance via email or through our platform. Your continued use of our services after such modifications constitutes acceptance of the updated Terms.</p>
                    </div>

                    <!-- 2. Service Description -->
                    <div id="description" class="content-section mb-5">
                        <h3 class="section-heading mb-4">2. Service Description</h3>

                        <p>SGLR provides a cloud-based laboratory management platform that includes:</p>

                        <ul>
                            <li><strong>Equipment Management:</strong> Tools for tracking, scheduling, and managing laboratory equipment</li>
                            <li><strong>Project Management:</strong> Collaboration tools for research projects and team coordination</li>
                            <li><strong>Data Management:</strong> Secure storage and organization of research data and publications</li>
                            <li><strong>Analytics & Reporting:</strong> Insights and reports on laboratory operations and research activities</li>
                            <li><strong>Integration Services:</strong> APIs and integrations with third-party laboratory systems</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Service Availability</h5>
                        <p>We strive to maintain 99.9% uptime for our services. However, we do not guarantee uninterrupted access and may perform maintenance or updates that temporarily affect service availability. We will provide advance notice of planned maintenance when possible.</p>
                    </div>

                    <!-- 3. User Accounts -->
                    <div id="user-accounts" class="content-section mb-5">
                        <h3 class="section-heading mb-4">3. User Accounts and Registration</h3>

                        <h5 class="mb-3">Account Creation</h5>
                        <p>To use our services, you must create an account and provide accurate, complete information. You are responsible for:</p>
                        <ul>
                            <li>Maintaining the confidentiality of your account credentials</li>
                            <li>All activities that occur under your account</li>
                            <li>Notifying us immediately of any unauthorized use</li>
                            <li>Keeping your account information current and accurate</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Eligibility</h5>
                        <p>You must be at least 18 years old and have the legal capacity to enter into contracts. If you are creating an account on behalf of an organization, you must have the authority to bind that organization to these Terms.</p>

                        <h5 class="mb-3 mt-4">Account Suspension</h5>
                        <p>We reserve the right to suspend or terminate accounts that violate these Terms or engage in activities that harm our platform or other users.</p>
                    </div>

                    <!-- 4. Acceptable Use -->
                    <div id="acceptable-use" class="content-section mb-5">
                        <h3 class="section-heading mb-4">4. Acceptable Use Policy</h3>

                        <p>You agree to use our services only for lawful purposes and in accordance with these Terms. You may not:</p>

                        <div class="prohibited-activities">
                            <h5 class="mb-3">Prohibited Activities</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="prohibition-item">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <span>Upload malicious software or code</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="prohibition-item">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <span>Attempt to gain unauthorized access</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="prohibition-item">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <span>Violate applicable laws or regulations</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="prohibition-item">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <span>Infringe on intellectual property rights</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="prohibition-item">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <span>Share false or misleading information</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="prohibition-item">
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        <span>Harass or harm other users</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4">Research Ethics</h5>
                        <p>When using our platform for research activities, you agree to:</p>
                        <ul>
                            <li>Comply with applicable research ethics guidelines and regulations</li>
                            <li>Obtain necessary permissions and approvals for your research</li>
                            <li>Respect intellectual property and publication rights</li>
                            <li>Maintain appropriate data security and confidentiality</li>
                        </ul>
                    </div>

                    <!-- 5. Intellectual Property -->
                    <div id="intellectual-property" class="content-section mb-5">
                        <h3 class="section-heading mb-4">5. Intellectual Property Rights</h3>

                        <h5 class="mb-3">SGLR's Rights</h5>
                        <p>The SGLR platform, including all software, designs, text, graphics, and other content, is owned by SGLR and protected by intellectual property laws. We grant you a limited, non-exclusive, non-transferable license to use our services according to these Terms.</p>

                        <h5 class="mb-3 mt-4">Third-Party Content</h5>
                        <p>Our platform may include third-party software, content, or services. Such third-party content is subject to the respective third party's terms and conditions.</p>

                        <h5 class="mb-3 mt-4">Feedback and Suggestions</h5>
                        <p>If you provide feedback, suggestions, or ideas about our services, you grant SGLR the right to use such feedback without any obligation to compensate you.</p>
                    </div>

                    <!-- 6. User Content -->
                    <div id="user-content" class="content-section mb-5">
                        <h3 class="section-heading mb-4">6. User Content and Data</h3>

                        <h5 class="mb-3">Your Content</h5>
                        <p>You retain ownership of all research data, publications, and other content you upload to our platform ("User Content"). You grant SGLR a limited license to store, process, and display your User Content as necessary to provide our services.</p>

                        <h5 class="mb-3 mt-4">Content Responsibility</h5>
                        <p>You are solely responsible for your User Content and must ensure that it:</p>
                        <ul>
                            <li>Does not violate any laws or regulations</li>
                            <li>Does not infringe on third-party rights</li>
                            <li>Is accurate and not misleading</li>
                            <li>Complies with applicable research ethics standards</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Data Backup and Export</h5>
                        <p>While we implement robust backup procedures, you are responsible for maintaining copies of your important data. We provide data export tools to help you maintain your own backups.</p>
                    </div>

                    <!-- 7. Payment Terms -->
                    <div id="payment-terms" class="content-section mb-5">
                        <h3 class="section-heading mb-4">7. Payment Terms and Billing</h3>

                        <h5 class="mb-3">Subscription Fees</h5>
                        <p>Access to certain features requires a paid subscription. Subscription fees are billed in advance according to your chosen billing cycle (monthly or annually).</p>

                        <h5 class="mb-3 mt-4">Payment Processing</h5>
                        <ul>
                            <li>Payments are processed through secure third-party payment providers</li>
                            <li>You authorize us to charge your payment method for applicable fees</li>
                            <li>Subscription fees are non-refundable except as required by law</li>
                            <li>We may suspend access for overdue payments after reasonable notice</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Price Changes</h5>
                        <p>We may change our pricing with at least 30 days' notice. Price changes will not affect your current billing cycle but will apply to subsequent renewals.</p>
                    </div>

                    <!-- 8. Privacy -->
                    <div id="privacy" class="content-section mb-5">
                        <h3 class="section-heading mb-4">8. Privacy and Data Protection</h3>

                        <p>Your privacy is important to us. Our collection, use, and disclosure of your information is governed by our <a href="{{ route('frontend.privacy') }}">Privacy Policy</a>, which is incorporated into these Terms by reference.</p>

                        <h5 class="mb-3 mt-4">Data Security</h5>
                        <p>We implement industry-standard security measures to protect your data, including:</p>
                        <ul>
                            <li>Encryption of data in transit and at rest</li>
                            <li>Regular security audits and assessments</li>
                            <li>Access controls and authentication measures</li>
                            <li>Compliance with applicable data protection regulations</li>
                        </ul>
                    </div>

                    <!-- 9. Disclaimers -->
                    <div id="disclaimers" class="content-section mb-5">
                        <h3 class="section-heading mb-4">9. Disclaimers and Warranties</h3>

                        <div class="disclaimer-notice">
                            <div class="alert alert-warning" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Important:</strong> Our services are provided "as is" without warranties of any kind.
                            </div>\n                        </div>\n\n                        <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, SGLR DISCLAIMS ALL WARRANTIES, EXPRESS OR IMPLIED, INCLUDING:</p>\n                        \n                        <ul>\n                            <li>WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT</li>\n                            <li>WARRANTIES THAT THE SERVICES WILL BE UNINTERRUPTED, ERROR-FREE, OR COMPLETELY SECURE</li>\n                            <li>WARRANTIES REGARDING THE ACCURACY, RELIABILITY, OR COMPLETENESS OF CONTENT</li>\n                        </ul>\n                        \n                        <p>You acknowledge that computer systems and networks are not fault-free and may occasionally experience downtime, errors, or security incidents.</p>\n                    </div>\n\n                    <!-- 10. Limitation of Liability -->\n                    <div id=\"limitation-liability\" class=\"content-section mb-5\">\n                        <h3 class=\"section-heading mb-4\">10. Limitation of Liability</h3>\n                        \n                        <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, SGLR'S TOTAL LIABILITY FOR ANY CLAIMS ARISING FROM OR RELATED TO THESE TERMS OR OUR SERVICES SHALL NOT EXCEED:</p>\n                        \n                        <div class=\"liability-limits\">\n                            <div class=\"row\">\n                                <div class=\"col-md-6 mb-3\">\n                                    <div class=\"limit-item\">\n                                        <i class=\"fas fa-dollar-sign text-primary me-2\"></i>\n                                        <strong>For Paid Users:</strong> The amount you paid us in the 12 months preceding the claim\n                                    </div>\n                                </div>\n                                <div class=\"col-md-6 mb-3\">\n                                    <div class=\"limit-item\">\n                                        <i class=\"fas fa-coins text-success me-2\"></i>\n                                        <strong>For Free Users:</strong> $100 USD\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                        \n                        <p class=\"mt-3\">WE SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, INCLUDING LOST PROFITS, DATA, OR BUSINESS OPPORTUNITIES.</p>\n                    </div>\n\n                    <!-- 11. Termination -->\n                    <div id=\"termination\" class=\"content-section mb-5\">\n                        <h3 class=\"section-heading mb-4\">11. Termination</h3>\n                        \n                        <h5 class=\"mb-3\">Termination by You</h5>\n                        <p>You may terminate your account at any time by contacting us or using the account closure feature in your dashboard. Upon termination:</p>\n                        <ul>\n                            <li>Your access to paid features will end at the end of your current billing period</li>\n                            <li>We will provide you with a reasonable opportunity to export your data</li>\n                            <li>We may delete your data according to our data retention policies</li>\n                        </ul>\n                        \n                        <h5 class=\"mb-3 mt-4\">Termination by SGLR</h5>\n                        <p>We may suspend or terminate your account if you:</p>\n                        <ul>\n                            <li>Violate these Terms or our Acceptable Use Policy</li>\n                            <li>Fail to pay applicable fees</li>\n                            <li>Engage in activities that harm our platform or other users</li>\n                            <li>Provide false or misleading information</li>\n                        </ul>\n                        \n                        <p>We will provide reasonable notice before termination except in cases involving immediate security risks or legal violations.</p>\n                    </div>\n\n                    <!-- 12. Governing Law -->\n                    <div id=\"governing-law\" class=\"content-section mb-5\">\n                        <h3 class=\"section-heading mb-4\">12. Governing Law and Dispute Resolution</h3>\n                        \n                        <h5 class=\"mb-3\">Governing Law</h5>\n                        <p>These Terms are governed by the laws of the State of California, United States, without regard to conflict of law principles.</p>\n                        \n                        <h5 class=\"mb-3 mt-4\">Dispute Resolution</h5>\n                        <p>Before filing any legal action, we encourage you to contact us to resolve disputes informally. If informal resolution is unsuccessful:</p>\n                        <ul>\n                            <li>For disputes under $10,000, either party may elect binding arbitration</li>\n                            <li>For larger disputes, either party may bring legal action in the courts of California</li>\n                            <li>Both parties waive the right to participate in class actions or collective proceedings</li>\n                        </ul>\n                    </div>\n\n                    <!-- 13. Contact Information -->\n                    <div id=\"contact\" class=\"content-section mb-5\">\n                        <h3 class=\"section-heading mb-4\">13. Contact Information</h3>\n                        \n                        <p>If you have questions about these Terms, please contact us:</p>\n                        \n                        <div class=\"contact-info\">\n                            <div class=\"row\">\n                                <div class=\"col-md-6\">\n                                    <h6>Legal Department</h6>\n                                    <p>\n                                        <i class=\"fas fa-envelope me-2\"></i>legal@sglr.com<br>\n                                        <i class=\"fas fa-phone me-2\"></i>+1 (555) 123-4567\n                                    </p>\n                                </div>\n                                <div class=\"col-md-6\">\n                                    <h6>Mailing Address</h6>\n                                    <p>\n                                        SGLR Laboratory Management System<br>\n                                        123 Science Park Drive<br>\n                                        Research City, RC 12345<br>\n                                        United States\n                                    </p>\n                                </div>\n                            </div>\n                        </div>\n                        \n                        <div class=\"final-note mt-4 p-3 bg-light rounded\">\n                            <p class=\"mb-0\"><strong>Effective Date:</strong> These Terms are effective as of December 15, 2024, and replace any prior agreements between you and SGLR regarding the subject matter herein.</p>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </div>\n</section>\n\n@endsection\n\n@push('styles')\n<style>\n.toc-link {\n    display: block;\n    padding: 0.5rem 0;\n    color: var(--text-color);\n    text-decoration: none;\n    font-size: 0.9rem;\n    transition: color 0.3s ease;\n}\n\n.toc-link:hover,\n.toc-link.active {\n    color: var(--primary-color);\n}\n\n.section-heading {\n    color: var(--dark-color);\n    font-weight: 600;\n    border-bottom: 2px solid var(--primary-color);\n    padding-bottom: 0.5rem;\n}\n\n.content-section {\n    line-height: 1.7;\n}\n\n.content-section ul {\n    padding-left: 1.5rem;\n}\n\n.content-section li {\n    margin-bottom: 0.5rem;\n}\n\n.prohibition-item,\n.limit-item {\n    padding: 0.75rem;\n    background: var(--light-color);\n    border-radius: 8px;\n    height: 100%;\n    font-size: 0.9rem;\n}\n\n.disclaimer-notice .alert {\n    border-left: 4px solid #f0ad4e;\n}\n\n.liability-limits .limit-item {\n    border-left: 3px solid var(--primary-color);\n}\n\n.contact-info {\n    background: var(--light-color);\n    padding: 2rem;\n    border-radius: 12px;\n    margin-top: 1rem;\n}\n\n.final-note {\n    border-left: 4px solid var(--success-color);\n}\n\n@media (max-width: 991.98px) {\n    .toc-wrapper {\n        position: relative !important;\n        top: auto !important;\n        margin-bottom: 2rem;\n    }\n}\n\n@media (max-width: 768px) {\n    .prohibited-activities .col-md-6,\n    .liability-limits .col-md-6 {\n        margin-bottom: 1rem;\n    }\n}\n</style>\n@endpush\n\n@push('scripts')\n<script>\ndocument.addEventListener('DOMContentLoaded', function() {\n    // Smooth scrolling for TOC links\n    document.querySelectorAll('.toc-link').forEach(link => {\n        link.addEventListener('click', function(e) {\n            e.preventDefault();\n            const target = document.querySelector(this.getAttribute('href'));\n            if (target) {\n                target.scrollIntoView({\n                    behavior: 'smooth',\n                    block: 'start'\n                });\n            }\n        });\n    });\n\n    // Update active TOC link on scroll\n    const sections = document.querySelectorAll('[id]');\n    const tocLinks = document.querySelectorAll('.toc-link');\n\n    function updateActiveTocLink() {\n        let current = '';\n        sections.forEach(section => {\n            const sectionTop = section.offsetTop - 120;\n            if (window.pageYOffset >= sectionTop) {\n                current = '#' + section.getAttribute('id');\n            }\n        });\n\n        tocLinks.forEach(link => {\n            link.classList.remove('active');\n            if (link.getAttribute('href') === current) {\n                link.classList.add('active');\n            }\n        });\n    }\n\n    window.addEventListener('scroll', updateActiveTocLink);\n    updateActiveTocLink(); // Initial call\n});\n</script>\n@endpush