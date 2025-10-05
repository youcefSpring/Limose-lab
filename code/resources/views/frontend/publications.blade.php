@extends('frontend.layouts.app')

@section('title', 'Publications - SGLR Laboratory Management System')
@section('description', 'Explore our comprehensive collection of research publications, whitepapers, and scientific studies in laboratory management and research innovation.')
@section('keywords', 'scientific publications, research papers, laboratory management studies, whitepapers, academic research')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">
                        Research Publications & Resources
                    </h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        Discover cutting-edge research, whitepapers, and studies that are advancing the field of laboratory management and scientific collaboration.
                    </p>
                    <div class="hero-search" data-aos="fade-up" data-aos-delay="200">
                        <div class="search-box mx-auto" style="max-width: 600px;">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0" placeholder="Search publications, authors, or topics..." id="publicationSearch">
                                <button class="btn btn-light" type="button">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Publication Stats -->
<section class="publication-stats py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <h3 class="stat-number text-primary">
                        <span class="counter" data-target="250">0</span>+
                    </h3>
                    <p class="stat-label">Research Papers</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <h3 class="stat-number text-success">
                        <span class="counter" data-target="50">0</span>+
                    </h3>
                    <p class="stat-label">Whitepapers</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <h3 class="stat-number text-info">
                        <span class="counter" data-target="15000">0</span>+
                    </h3>
                    <p class="stat-label">Citations</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                    <h3 class="stat-number text-warning">
                        <span class="counter" data-target="85">0</span>+
                    </h3>
                    <p class="stat-label">Research Partners</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Categories -->
<section class="publication-filter bg-white py-4 border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="filter-tabs" data-aos="fade-up">
                    <ul class="nav nav-pills" id="publicationCategories">
                        <li class="nav-item">
                            <button class="nav-link active" data-category="all">All Publications</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="research">Research Papers</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="whitepaper">Whitepapers</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="case-study">Case Studies</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="technical">Technical Reports</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="filter-controls" data-aos="fade-up" data-aos-delay="100">
                    <select class="form-select d-inline-block w-auto me-2" id="sortBy">
                        <option value="date">Sort by Date</option>
                        <option value="title">Sort by Title</option>
                        <option value="author">Sort by Author</option>
                        <option value="citations">Sort by Citations</option>
                    </select>
                    <button class="btn btn-outline-primary" id="toggleView">
                        <i class="fas fa-th"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Publications -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">Featured Publications</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Highlighted research and publications that have made significant impact in the laboratory management field.
                </p>
            </div>
        </div>

        <div class="row" id="publicationsGrid">
            <!-- Publication 1 -->
            <div class="col-lg-6 mb-4 publication-item" data-category="research" data-aos="fade-up" data-aos-delay="100">
                <article class="publication-card card-custom h-100">
                    <div class="publication-header p-4">
                        <div class="publication-meta mb-3">
                            <span class="badge bg-primary me-2">Research Paper</span>
                            <span class="badge bg-light text-dark">2024</span>
                            <div class="float-end">
                                <span class="citations-count" title="Citations">
                                    <i class="fas fa-quote-right text-muted me-1"></i>127
                                </span>
                            </div>
                        </div>
                        <h4 class="publication-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">AI-Driven Laboratory Equipment Optimization: A Machine Learning Approach</a>
                        </h4>
                        <p class="publication-abstract mb-3">
                            This study presents a novel machine learning framework for optimizing laboratory equipment utilization, resulting in 40% improvement in efficiency and significant cost reductions across multiple research institutions.
                        </p>
                        <div class="publication-authors mb-3">
                            <small class="text-muted">
                                <i class="fas fa-users me-1"></i>
                                Dr. Sarah Johnson, Prof. Michael Chen, Dr. Emily Rodriguez
                            </small>
                        </div>
                        <div class="publication-journal mb-3">
                            <small class="text-muted">
                                <i class="fas fa-journal-whills me-1"></i>
                                Journal of Laboratory Management, Vol. 45, Issue 3
                            </small>
                        </div>
                    </div>
                    <div class="publication-footer p-4 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="publication-actions">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-download me-1"></i>PDF
                                </a>
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i>DOI
                                </a>
                            </div>
                            <div class="publication-stats">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>2,341 views
                                </small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Publication 2 -->
            <div class="col-lg-6 mb-4 publication-item" data-category="whitepaper" data-aos="fade-up" data-aos-delay="200">
                <article class="publication-card card-custom h-100">
                    <div class="publication-header p-4">
                        <div class="publication-meta mb-3">
                            <span class="badge bg-success me-2">Whitepaper</span>
                            <span class="badge bg-light text-dark">2024</span>
                            <div class="float-end">
                                <span class="citations-count" title="Citations">
                                    <i class="fas fa-quote-right text-muted me-1"></i>89
                                </span>
                            </div>
                        </div>
                        <h4 class="publication-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">The Future of Laboratory Collaboration: Building Global Research Networks</a>
                        </h4>
                        <p class="publication-abstract mb-3">
                            An comprehensive analysis of emerging trends in laboratory collaboration, exploring how digital platforms are enabling seamless knowledge sharing across international research communities.
                        </p>
                        <div class="publication-authors mb-3">
                            <small class="text-muted">
                                <i class="fas fa-users me-1"></i>
                                SGLR Research Team, Dr. Anna Kim, Prof. David Martinez
                            </small>
                        </div>
                        <div class="publication-journal mb-3">
                            <small class="text-muted">
                                <i class="fas fa-building me-1"></i>
                                SGLR Publications, Technical Report Series
                            </small>
                        </div>
                    </div>
                    <div class="publication-footer p-4 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="publication-actions">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-download me-1"></i>PDF
                                </a>
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-share me-1"></i>Share
                                </a>
                            </div>
                            <div class="publication-stats">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>1,876 views
                                </small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Publication 3 -->
            <div class="col-lg-6 mb-4 publication-item" data-category="case-study" data-aos="fade-up" data-aos-delay="300">
                <article class="publication-card card-custom h-100">
                    <div class="publication-header p-4">
                        <div class="publication-meta mb-3">
                            <span class="badge bg-info me-2">Case Study</span>
                            <span class="badge bg-light text-dark">2023</span>
                            <div class="float-end">
                                <span class="citations-count" title="Citations">
                                    <i class="fas fa-quote-right text-muted me-1"></i>156
                                </span>
                            </div>
                        </div>
                        <h4 class="publication-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">Digital Transformation at MIT: A Laboratory Management Success Story</a>
                        </h4>
                        <p class="publication-abstract mb-3">
                            A detailed case study examining how MIT implemented SGLR's laboratory management system, resulting in 60% reduction in equipment downtime and improved research productivity.
                        </p>
                        <div class="publication-authors mb-3">
                            <small class="text-muted">
                                <i class="fas fa-users me-1"></i>
                                Prof. James Wilson (MIT), Dr. Lisa Chang, SGLR Implementation Team
                            </small>
                        </div>
                        <div class="publication-journal mb-3">
                            <small class="text-muted">
                                <i class="fas fa-graduation-cap me-1"></i>
                                MIT Technology Review, Case Study Collection
                            </small>
                        </div>
                    </div>
                    <div class="publication-footer p-4 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="publication-actions">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-download me-1"></i>PDF
                                </a>
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-external-link-alt me-1"></i>Full Study
                                </a>
                            </div>
                            <div class="publication-stats">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>3,210 views
                                </small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Publication 4 -->
            <div class="col-lg-6 mb-4 publication-item" data-category="technical" data-aos="fade-up" data-aos-delay="400">
                <article class="publication-card card-custom h-100">
                    <div class="publication-header p-4">
                        <div class="publication-meta mb-3">
                            <span class="badge bg-warning me-2">Technical Report</span>
                            <span class="badge bg-light text-dark">2024</span>
                            <div class="float-end">
                                <span class="citations-count" title="Citations">
                                    <i class="fas fa-quote-right text-muted me-1"></i>73
                                </span>
                            </div>
                        </div>
                        <h4 class="publication-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">Security Framework for Laboratory Data Management Systems</a>
                        </h4>
                        <p class="publication-abstract mb-3">
                            Technical specifications and implementation guidelines for ensuring data security, privacy compliance, and integrity in modern laboratory management systems.
                        </p>
                        <div class="publication-authors mb-3">
                            <small class="text-muted">
                                <i class="fas fa-users me-1"></i>
                                Dr. Robert Taylor, Security Team, Prof. Maria Gonzalez
                            </small>
                        </div>
                        <div class="publication-journal mb-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                SGLR Technical Documentation, Security Series
                            </small>
                        </div>
                    </div>
                    <div class="publication-footer p-4 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="publication-actions">
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-download me-1"></i>PDF
                                </a>
                                <a href="#" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-code me-1"></i>GitHub
                                </a>
                            </div>
                            <div class="publication-stats">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>1,455 views
                                </small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="row mt-5">
            <div class="col-lg-12 text-center" data-aos="fade-up">
                <button class="btn btn-outline-primary btn-lg" id="loadMorePublications">
                    <i class="fas fa-plus me-2"></i>Load More Publications
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Research Impact -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="section-title mb-4">Research Impact & Recognition</h2>
                <p class="lead mb-4">
                    Our publications have made significant contributions to the scientific community and are widely cited in leading journals and conferences.
                </p>

                <div class="impact-metrics">
                    <div class="impact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="impact-icon me-3">
                                <i class="fas fa-medal text-warning fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">25 Research Awards</h5>
                                <p class="text-muted mb-0">International recognition for innovation</p>
                            </div>
                        </div>
                    </div>

                    <div class="impact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="impact-icon me-3">
                                <i class="fas fa-chart-bar text-success fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">H-Index: 45</h5>
                                <p class="text-muted mb-0">Demonstrating research impact and influence</p>
                            </div>
                        </div>
                    </div>

                    <div class="impact-item mb-4">
                        <div class="d-flex align-items-center">
                            <div class="impact-icon me-3">
                                <i class="fas fa-university text-primary fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">100+ Partner Institutions</h5>
                                <p class="text-muted mb-0">Collaborative research network</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('frontend.research') }}" class="btn btn-primary-custom">
                    <i class="fas fa-microscope me-2"></i>View Research Projects
                </a>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="impact-chart-placeholder">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Research Impact Visualization"
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
.publication-stats .stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.publication-stats .stat-label {
    font-weight: 500;
    color: var(--text-color);
}

.publication-filter {
    position: sticky;
    top: 70px;
    z-index: 100;
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.nav-pills .nav-link {
    background: transparent;
    border: 2px solid transparent;
    color: var(--text-color);
    font-weight: 500;
    margin: 0 0.25rem;
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover,
.nav-pills .nav-link.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.publication-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.publication-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
}

.publication-title a:hover {
    color: var(--primary-color) !important;
}

.citations-count {
    font-size: 0.9rem;
    font-weight: 500;
}

.publication-item {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.publication-item.hidden {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
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
    .publication-filter {
        position: relative;
        top: auto;
    }

    .nav-pills {
        flex-wrap: wrap;
    }

    .nav-pills .nav-link {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    .filter-controls {
        margin-top: 1rem;
        text-align: center;
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

                counter.textContent = current.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                }
            }

            requestAnimationFrame(updateCounter);
        });
    }

    // Trigger counter animation when stats section comes into view
    const statsSection = document.querySelector('.publication-stats');
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

    // Publication category filtering
    const categoryButtons = document.querySelectorAll('#publicationCategories .nav-link');
    const publicationItems = document.querySelectorAll('.publication-item');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.category;

            // Filter publication items
            publicationItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.classList.remove('hidden');
                    item.style.display = 'block';
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'publication_filter', {
                    'category': category
                });
            }
        });
    });

    // Publication search functionality
    const searchInput = document.getElementById('publicationSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            publicationItems.forEach(item => {
                const title = item.querySelector('.publication-title').textContent.toLowerCase();
                const abstract = item.querySelector('.publication-abstract').textContent.toLowerCase();
                const authors = item.querySelector('.publication-authors').textContent.toLowerCase();

                if (title.includes(searchTerm) || abstract.includes(searchTerm) || authors.includes(searchTerm)) {
                    item.classList.remove('hidden');
                    item.style.display = 'block';
                } else {
                    item.classList.add('hidden');
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    }

    // Sort functionality
    const sortSelect = document.getElementById('sortBy');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortBy = this.value;
            const grid = document.getElementById('publicationsGrid');
            const items = Array.from(publicationItems);

            items.sort((a, b) => {
                let aValue, bValue;

                switch (sortBy) {
                    case 'title':
                        aValue = a.querySelector('.publication-title').textContent;
                        bValue = b.querySelector('.publication-title').textContent;
                        return aValue.localeCompare(bValue);
                    case 'author':
                        aValue = a.querySelector('.publication-authors').textContent;
                        bValue = b.querySelector('.publication-authors').textContent;
                        return aValue.localeCompare(bValue);
                    case 'citations':
                        aValue = parseInt(a.querySelector('.citations-count').textContent.match(/\d+/)[0]);
                        bValue = parseInt(b.querySelector('.citations-count').textContent.match(/\d+/)[0]);
                        return bValue - aValue; // Descending order
                    case 'date':
                    default:
                        // For this demo, we'll use the badge year
                        aValue = parseInt(a.querySelector('.badge:last-of-type').textContent);
                        bValue = parseInt(b.querySelector('.badge:last-of-type').textContent);
                        return bValue - aValue; // Newest first
                }
            });

            // Reorder items in DOM
            items.forEach(item => grid.appendChild(item));
        });
    }

    // Load more functionality
    const loadMoreButton = document.getElementById('loadMorePublications');
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';

            // Simulate loading more publications
            setTimeout(() => {
                this.innerHTML = 'No more publications to load.';
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-secondary');
            }, 2000);
        });
    }

    // Toggle view functionality
    const toggleViewButton = document.getElementById('toggleView');
    if (toggleViewButton) {
        let isListView = false;

        toggleViewButton.addEventListener('click', function() {
            const grid = document.getElementById('publicationsGrid');

            if (isListView) {
                // Switch to grid view
                publicationItems.forEach(item => {
                    item.className = 'col-lg-6 mb-4 publication-item';
                });
                this.innerHTML = '<i class="fas fa-th"></i>';
                isListView = false;
            } else {
                // Switch to list view
                publicationItems.forEach(item => {
                    item.className = 'col-12 mb-4 publication-item';
                });
                this.innerHTML = '<i class="fas fa-list"></i>';
                isListView = true;
            }
        });
    }

    // Download tracking
    document.querySelectorAll('a[href*="download"], a[href*=".pdf"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const publicationTitle = this.closest('.publication-card').querySelector('.publication-title').textContent;

            // Analytics tracking
            if (typeof gtag !== 'undefined') {
                gtag('event', 'publication_download', {
                    'publication_title': publicationTitle
                });
            }

            // Show download message
            alert('Download functionality would be implemented here.');
        });
    });
});
</script>
@endpush