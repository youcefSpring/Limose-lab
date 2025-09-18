@extends('frontend.layouts.app')

@section('title', 'Our Team - SGLR Laboratory Management System')
@section('description', 'Meet the expert team behind SGLR, including researchers, developers, and industry leaders driving innovation in laboratory management.')
@section('keywords', 'SGLR team, laboratory management experts, research team, scientific software developers, leadership team')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">
                        Meet Our Expert Team
                    </h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        Behind SGLR's success is a diverse team of researchers, engineers, and visionaries dedicated to advancing laboratory management technology.
                    </p>
                    <div class="hero-stats" data-aos="fade-up" data-aos-delay="200">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <h3 class="mb-1"><span class="counter" data-target="50">0</span>+</h3>
                                <small>Team Members</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h3 class="mb-1"><span class="counter" data-target="15">0</span>+</h3>
                                <small>PhD Researchers</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <h3 class="mb-1"><span class="counter" data-target="25">0</span>+</h3>
                                <small>Countries Represented</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Team -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Leadership Team</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Visionary leaders with decades of experience in scientific research, technology innovation, and business strategy.
                </p>
            </div>
        </div>

        <div class="row">
            <!-- CEO -->
            <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card card-custom text-center p-4 h-100">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                             alt="Dr. Sarah Johnson"
                             class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h5 class="team-name mb-2">Dr. Sarah Johnson</h5>
                    <p class="team-title text-primary mb-3">Chief Executive Officer & Co-Founder</p>
                    <p class="team-bio mb-4">
                        Former Director of MIT's Laboratory Innovation Center with 15+ years of experience in research management and technology commercialization. PhD in Biochemistry from Harvard.
                    </p>
                    <div class="team-stats mb-3">
                        <small class="text-muted">
                            <i class="fas fa-book me-1"></i>45 Publications
                            <span class="mx-2">•</span>
                            <i class="fas fa-award me-1"></i>12 Awards
                        </small>
                    </div>
                    <div class="team-social">
                        <a href="#" class="social-link me-2">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link me-2">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CTO -->
            <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card card-custom text-center p-4 h-100">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                             alt="Prof. Michael Chen"
                             class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h5 class="team-name mb-2">Prof. Michael Chen</h5>
                    <p class="team-title text-primary mb-3">Chief Technology Officer & Co-Founder</p>
                    <p class="team-bio mb-4">
                        Leading expert in AI and machine learning applications for scientific research. Former Principal Scientist at Google Research with 20+ years in technology innovation.
                    </p>
                    <div class="team-stats mb-3">
                        <small class="text-muted">
                            <i class="fas fa-book me-1"></i>67 Publications
                            <span class="mx-2">•</span>
                            <i class="fas fa-award me-1"></i>18 Awards
                        </small>
                    </div>
                    <div class="team-social">
                        <a href="#" class="social-link me-2">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link me-2">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CSO -->
            <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card card-custom text-center p-4 h-100">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b6e6b0e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                             alt="Dr. Emily Rodriguez"
                             class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h5 class="team-name mb-2">Dr. Emily Rodriguez</h5>
                    <p class="team-title text-primary mb-3">Chief Scientific Officer</p>
                    <p class="team-bio mb-4">
                        Renowned researcher in laboratory automation and workflow optimization. Former Department Head at Stanford's Bioengineering Labs with expertise in systems biology.
                    </p>
                    <div class="team-stats mb-3">
                        <small class="text-muted">
                            <i class="fas fa-book me-1"></i>52 Publications
                            <span class="mx-2">•</span>
                            <i class="fas fa-award me-1"></i>15 Awards
                        </small>
                    </div>
                    <div class="team-social">
                        <a href="#" class="social-link me-2">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link me-2">
                            <i class="fab fa-researchgate"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Research Team -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Research & Development Team</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Our world-class research team drives innovation in laboratory management, AI, and scientific workflow optimization.
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Research Team Member 1 -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card-compact card-custom text-center p-3 h-100">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                             alt="Dr. Anna Kim"
                             class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <h6 class="team-name mb-1">Dr. Anna Kim</h6>
                    <p class="team-title text-primary mb-2">Lead AI Researcher</p>
                    <small class="text-muted">Machine Learning & Lab Automation</small>
                </div>
            </div>

            <!-- Research Team Member 2 -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card-compact card-custom text-center p-3 h-100">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                             alt="Prof. David Martinez"
                             class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <h6 class="team-name mb-1">Prof. David Martinez</h6>
                    <p class="team-title text-primary mb-2">Senior Research Scientist</p>
                    <small class="text-muted">Systems Biology & Data Analytics</small>
                </div>
            </div>

            <!-- Research Team Member 3 -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card-compact card-custom text-center p-3 h-100">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                             alt="Dr. Lisa Chang"
                             class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <h6 class="team-name mb-1">Dr. Lisa Chang</h6>
                    <p class="team-title text-primary mb-2">UX Research Lead</p>
                    <small class="text-muted">Human-Computer Interaction</small>
                </div>
            </div>

            <!-- Research Team Member 4 -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="team-card-compact card-custom text-center p-3 h-100">
                    <div class="team-photo mb-3">
                        <img src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                             alt="Dr. James Wilson"
                             class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <h6 class="team-name mb-1">Dr. James Wilson</h6>
                    <p class="team-title text-primary mb-2">Security Researcher</p>
                    <small class="text-muted">Cybersecurity & Data Protection</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Engineering Team -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Engineering Team</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Talented engineers and developers building robust, scalable solutions for the global research community.
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Engineering Team Members -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="team-department-card card-custom p-4 text-center h-100">
                    <div class="department-icon mb-3">
                        <i class="fas fa-code text-primary fa-3x"></i>
                    </div>
                    <h5 class="mb-3">Backend Engineering</h5>
                    <p class="mb-3">12 senior engineers building scalable microservices, APIs, and distributed systems.</p>
                    <ul class="list-unstyled">
                        <li><strong>Tech Stack:</strong> Python, Node.js, Docker</li>
                        <li><strong>Focus:</strong> Performance & Scalability</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="team-department-card card-custom p-4 text-center h-100">
                    <div class="department-icon mb-3">
                        <i class="fas fa-paint-brush text-success fa-3x"></i>
                    </div>
                    <h5 class="mb-3">Frontend Engineering</h5>
                    <p class="mb-3">8 developers creating intuitive user interfaces and seamless user experiences.</p>
                    <ul class="list-unstyled">
                        <li><strong>Tech Stack:</strong> React, Vue.js, TypeScript</li>
                        <li><strong>Focus:</strong> UX/UI & Accessibility</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="team-department-card card-custom p-4 text-center h-100">
                    <div class="department-icon mb-3">
                        <i class="fas fa-mobile-alt text-info fa-3x"></i>
                    </div>
                    <h5 class="mb-3">Mobile Development</h5>
                    <p class="mb-3">6 specialists developing native mobile applications for iOS and Android platforms.</p>
                    <ul class="list-unstyled">
                        <li><strong>Tech Stack:</strong> React Native, Flutter</li>
                        <li><strong>Focus:</strong> Cross-platform Solutions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Global Presence -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Global Team</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Our diverse, international team brings together expertise from leading institutions worldwide.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="global-stats">
                    <h4 class="mb-4">Team Distribution</h4>
                    <div class="stat-bar mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>North America</span>
                            <span>45%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: 45%"></div>
                        </div>
                    </div>
                    <div class="stat-bar mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Europe</span>
                            <span>30%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 30%"></div>
                        </div>
                    </div>
                    <div class="stat-bar mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Asia Pacific</span>
                            <span>20%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 20%"></div>
                        </div>
                    </div>
                    <div class="stat-bar mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Other</span>
                            <span>5%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 5%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="diversity-stats">
                    <h4 class="mb-4">Diversity & Inclusion</h4>
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="diversity-stat">
                                <h3 class="text-primary mb-1">48%</h3>
                                <small>Women in Leadership</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="diversity-stat">
                                <h3 class="text-success mb-1">25+</h3>
                                <small>Countries Represented</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="diversity-stat">
                                <h3 class="text-info mb-1">15+</h3>
                                <small>Languages Spoken</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="diversity-stat">
                                <h3 class="text-warning mb-1">35%</h3>
                                <small>Remote Team Members</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Join Our Team CTA -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <div class="join-team-cta" data-aos="fade-up">
                    <h2 class="section-title mb-4">Join Our Mission</h2>
                    <p class="lead mb-4">
                        Ready to make an impact in scientific research? We're always looking for talented individuals who share our passion for innovation.
                    </p>
                    <div class="cta-buttons">
                        <a href="{{ route('frontend.careers') }}" class="btn btn-primary-custom btn-lg me-3 mb-3">
                            <i class="fas fa-briefcase me-2"></i>View Open Positions
                        </a>
                        <a href="{{ route('frontend.contact') }}" class="btn btn-outline-primary btn-lg mb-3">
                            <i class="fas fa-envelope me-2"></i>Get in Touch
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.team-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.team-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.team-card-compact {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.team-card-compact:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.team-department-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.team-department-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
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

.progress {
    height: 10px;
    border-radius: 5px;
    background: var(--border-color);
}

.progress-bar {
    border-radius: 5px;
}

.diversity-stat h3 {
    font-weight: 700;
    font-size: 2rem;
}

.hero-stats .counter {
    font-size: 2rem;
    font-weight: 700;
}

@media (max-width: 768px) {
    .team-photo img {
        width: 120px !important;
        height: 120px !important;
    }

    .team-card-compact .team-photo img {
        width: 80px !important;
        height: 80px !important;
    }

    .hero-stats .counter {
        font-size: 1.5rem;
    }

    .cta-buttons .btn {
        width: 100%;
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation for hero stats
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

    // Trigger counter animation when hero section comes into view
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(heroSection);
    }

    // Progress bar animation
    const progressBars = document.querySelectorAll('.progress-bar');
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target;
                const width = progressBar.style.width;
                progressBar.style.width = '0%';
                setTimeout(() => {
                    progressBar.style.transition = 'width 1.5s ease-in-out';
                    progressBar.style.width = width;
                }, 100);
                progressObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    progressBars.forEach(bar => {
        progressObserver.observe(bar);
    });

    // Team card hover effects
    document.querySelectorAll('.team-card, .team-card-compact, .team-department-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = this.classList.contains('team-card') ? 'translateY(-10px)' : 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Social link tracking
    document.querySelectorAll('.social-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.querySelector('i').className.includes('linkedin') ? 'linkedin' :
                           this.querySelector('i').className.includes('twitter') ? 'twitter' :
                           this.querySelector('i').className.includes('github') ? 'github' : 'email';
            const teamMember = this.closest('.team-card, .team-card-compact').querySelector('.team-name')?.textContent || 'Unknown';

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'team_social_click', {
                    'platform': platform,
                    'team_member': teamMember
                });
            }

            // Show message for demo
            alert(`${platform} profile for ${teamMember} would open here.`);
        });
    });
});
</script>
@endpush