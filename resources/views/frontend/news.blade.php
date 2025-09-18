@extends('frontend.layouts.app')

@section('title', 'News & Updates - SGLR Laboratory Management System')
@section('description', 'Stay updated with the latest news, announcements, and insights from SGLR. Discover industry trends and product updates.')
@section('keywords', 'laboratory news, scientific updates, research news, product announcements, industry insights')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 120px 0 80px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content text-white">
                    <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">
                        Latest News & Insights
                    </h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        Stay informed about the latest developments in laboratory management, scientific research, and technology innovations.
                    </p>
                    <div class="hero-search" data-aos="fade-up" data-aos-delay="200">
                        <div class="search-box mx-auto" style="max-width: 500px;">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-0" placeholder="Search news and articles..." id="newsSearch">
                                <button class="btn btn-light" type="button">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Article -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="featured-article card-custom mb-5" data-aos="fade-up">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="featured-image">
                                <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                                     alt="Featured Article"
                                     class="img-fluid h-100 w-100" style="object-fit: cover;">
                                <div class="featured-badge">
                                    <span class="badge bg-primary">Featured</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="featured-content p-5">
                                <div class="article-meta mb-3">
                                    <span class="badge bg-light text-dark me-2">Technology</span>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>December 15, 2024
                                    </small>
                                </div>
                                <h2 class="article-title mb-3">
                                    Revolutionary AI System Transforms Laboratory Operations Worldwide
                                </h2>
                                <p class="article-excerpt mb-4">
                                    Our latest AI-powered laboratory management system has been successfully implemented across 200+ research institutions,
                                    resulting in unprecedented efficiency gains and research acceleration. Discover how this breakthrough technology is
                                    reshaping the future of scientific research.
                                </p>
                                <div class="article-stats mb-4">
                                    <span class="stat-item me-3">
                                        <i class="fas fa-eye text-muted me-1"></i>15,420 views
                                    </span>
                                    <span class="stat-item me-3">
                                        <i class="fas fa-thumbs-up text-muted me-1"></i>324 likes
                                    </span>
                                    <span class="stat-item">
                                        <i class="fas fa-share text-muted me-1"></i>89 shares
                                    </span>
                                </div>
                                <a href="#" class="btn btn-primary-custom">
                                    Read Full Article <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Categories & Filter -->
<section class="news-filter bg-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="filter-tabs text-center" data-aos="fade-up">
                    <ul class="nav nav-pills justify-content-center" id="newsCategories">
                        <li class="nav-item">
                            <button class="nav-link active" data-category="all">All News</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="product">Product Updates</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="research">Research</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="industry">Industry Insights</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="company">Company News</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-category="events">Events</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Articles Grid -->
<section class="section-padding">
    <div class="container">
        <div class="row" id="newsGrid">
            <!-- Article 1 -->
            <div class="col-lg-4 col-md-6 mb-4 news-item" data-category="product" data-aos="fade-up" data-aos-delay="100">
                <article class="news-card card-custom h-100">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Product Update"
                             class="img-fluid">
                        <div class="news-date">
                            <span class="day">12</span>
                            <span class="month">Dec</span>
                        </div>
                    </div>
                    <div class="news-content p-4">
                        <div class="news-meta mb-2">
                            <span class="badge bg-success">Product Update</span>
                        </div>
                        <h5 class="news-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">SGLR 3.0: Enhanced User Experience and New Features</a>
                        </h5>
                        <p class="news-excerpt mb-3">
                            Discover the latest improvements in our laboratory management platform, including advanced analytics, streamlined workflows, and enhanced collaboration tools.
                        </p>
                        <div class="news-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Sarah Johnson
                            </small>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 2 -->
            <div class="col-lg-4 col-md-6 mb-4 news-item" data-category="research" data-aos="fade-up" data-aos-delay="200">
                <article class="news-card card-custom h-100">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Research News"
                             class="img-fluid">
                        <div class="news-date">
                            <span class="day">08</span>
                            <span class="month">Dec</span>
                        </div>
                    </div>
                    <div class="news-content p-4">
                        <div class="news-meta mb-2">
                            <span class="badge bg-info">Research</span>
                        </div>
                        <h5 class="news-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">Breakthrough Study: AI Reduces Lab Errors by 85%</a>
                        </h5>
                        <p class="news-excerpt mb-3">
                            A comprehensive study involving 50 research institutions shows how artificial intelligence integration significantly reduces human errors in laboratory operations.
                        </p>
                        <div class="news-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Dr. Michael Chen
                            </small>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 3 -->
            <div class="col-lg-4 col-md-6 mb-4 news-item" data-category="industry" data-aos="fade-up" data-aos-delay="300">
                <article class="news-card card-custom h-100">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Industry Insights"
                             class="img-fluid">
                        <div class="news-date">
                            <span class="day">05</span>
                            <span class="month">Dec</span>
                        </div>
                    </div>
                    <div class="news-content p-4">
                        <div class="news-meta mb-2">
                            <span class="badge bg-warning">Industry Insights</span>
                        </div>
                        <h5 class="news-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">The Future of Laboratory Automation: Trends for 2025</a>
                        </h5>
                        <p class="news-excerpt mb-3">
                            Explore emerging trends in laboratory automation and how they will shape the future of scientific research and discovery in the coming year.
                        </p>
                        <div class="news-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Emma Rodriguez
                            </small>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 4 -->
            <div class="col-lg-4 col-md-6 mb-4 news-item" data-category="company" data-aos="fade-up" data-aos-delay="100">
                <article class="news-card card-custom h-100">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Company News"
                             class="img-fluid">
                        <div class="news-date">
                            <span class="day">02</span>
                            <span class="month">Dec</span>
                        </div>
                    </div>
                    <div class="news-content p-4">
                        <div class="news-meta mb-2">
                            <span class="badge bg-primary">Company News</span>
                        </div>
                        <h5 class="news-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">SGLR Expands to European Market with New Partnerships</a>
                        </h5>
                        <p class="news-excerpt mb-3">
                            We're excited to announce our expansion into the European market through strategic partnerships with leading research institutions across the continent.
                        </p>
                        <div class="news-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Marketing Team
                            </small>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 5 -->
            <div class="col-lg-4 col-md-6 mb-4 news-item" data-category="events" data-aos="fade-up" data-aos-delay="200">
                <article class="news-card card-custom h-100">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Events"
                             class="img-fluid">
                        <div class="news-date">
                            <span class="day">28</span>
                            <span class="month">Nov</span>
                        </div>
                    </div>
                    <div class="news-content p-4">
                        <div class="news-meta mb-2">
                            <span class="badge bg-danger">Events</span>
                        </div>
                        <h5 class="news-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">Join Us at the International Lab Conference 2025</a>
                        </h5>
                        <p class="news-excerpt mb-3">
                            Don't miss our presentation on next-generation laboratory management solutions at the world's largest laboratory conference in Berlin.
                        </p>
                        <div class="news-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Events Team
                            </small>
                            <a href="#" class="btn btn-outline-primary btn-sm">Learn More</a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Article 6 -->
            <div class="col-lg-4 col-md-6 mb-4 news-item" data-category="research" data-aos="fade-up" data-aos-delay="300">
                <article class="news-card card-custom h-100">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                             alt="Research"
                             class="img-fluid">
                        <div class="news-date">
                            <span class="day">25</span>
                            <span class="month">Nov</span>
                        </div>
                    </div>
                    <div class="news-content p-4">
                        <div class="news-meta mb-2">
                            <span class="badge bg-info">Research</span>
                        </div>
                        <h5 class="news-title mb-3">
                            <a href="#" class="text-decoration-none text-dark">New Research Paper: Optimizing Equipment Utilization</a>
                        </h5>
                        <p class="news-excerpt mb-3">
                            Our research team publishes groundbreaking findings on how smart scheduling algorithms can increase equipment utilization by up to 60%.
                        </p>
                        <div class="news-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>Dr. Anna Kim
                            </small>
                            <a href="#" class="btn btn-outline-primary btn-sm">Read Paper</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="row mt-5">
            <div class="col-lg-12 text-center" data-aos="fade-up">
                <button class="btn btn-outline-primary btn-lg" id="loadMoreNews">
                    <i class="fas fa-plus me-2"></i>Load More Articles
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Signup -->
@include('frontend.partials.newsletter')

@endsection

@push('styles')
<style>
.search-box .input-group-text {
    border-radius: 12px 0 0 12px;
}

.search-box .form-control {
    border-radius: 0;
}

.search-box .btn {
    border-radius: 0 12px 12px 0;
    border: 2px solid white;
    border-left: none;
}

.featured-article {
    overflow: hidden;
    position: relative;
}

.featured-image {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.featured-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 2;
}

.article-stats .stat-item {
    font-size: 0.9rem;
    color: var(--text-color);
}

.news-filter {
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
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

.news-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
}

.news-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-card:hover .news-image img {
    transform: scale(1.05);
}

.news-date {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 8px;
    padding: 0.5rem;
    text-align: center;
    min-width: 50px;
}

.news-date .day {
    display: block;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary-color);
    line-height: 1;
}

.news-date .month {
    display: block;
    font-size: 0.8rem;
    color: var(--text-color);
    text-transform: uppercase;
    line-height: 1;
}

.news-title a:hover {
    color: var(--primary-color) !important;
}

.news-item {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.news-item.hidden {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

@media (max-width: 768px) {
    .featured-content {
        padding: 2rem !important;
    }

    .featured-image {
        height: 250px;
    }

    .nav-pills {
        flex-wrap: wrap;
    }

    .nav-pills .nav-link {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    .news-image {
        height: 180px;
    }
}

/* Loading animation */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    border: 2px solid var(--primary-color);
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    transform: translate(-50%, -50%);
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // News category filtering
    const categoryButtons = document.querySelectorAll('#newsCategories .nav-link');
    const newsItems = document.querySelectorAll('.news-item');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.category;

            // Filter news items
            newsItems.forEach(item => {
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
                gtag('event', 'news_filter', {
                    'category': category
                });
            }
        });
    });

    // News search functionality
    const searchInput = document.getElementById('newsSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            newsItems.forEach(item => {
                const title = item.querySelector('.news-title').textContent.toLowerCase();
                const excerpt = item.querySelector('.news-excerpt').textContent.toLowerCase();

                if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
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

    // Load more functionality
    const loadMoreButton = document.getElementById('loadMoreNews');
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
            // Add loading state
            this.classList.add('loading');
            this.disabled = true;

            // Simulate loading more articles
            setTimeout(() => {
                // Remove loading state
                this.classList.remove('loading');
                this.disabled = false;

                // In a real application, you would fetch more articles here
                // For demo purposes, we'll just show a message
                const newsGrid = document.getElementById('newsGrid');
                const noMoreMessage = document.createElement('div');
                noMoreMessage.className = 'col-12 text-center mt-4';
                noMoreMessage.innerHTML = '<p class="text-muted">No more articles to load.</p>';
                newsGrid.appendChild(noMoreMessage);

                // Hide the load more button
                this.style.display = 'none';
            }, 2000);
        });
    }

    // Social sharing (if implemented)
    document.querySelectorAll('.share-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.dataset.platform;
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);

            let shareUrl = '';
            switch (platform) {
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        });
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = '0s';
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
            }
        });
    }, observerOptions);

    // Observe news cards
    newsItems.forEach(item => {
        observer.observe(item);
    });
});
</script>
@endpush