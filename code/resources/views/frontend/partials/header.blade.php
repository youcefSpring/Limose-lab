<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-flask me-2"></i>SGLR
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}" href="{{ route('frontend.about') }}">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('frontend.services') || request()->routeIs('frontend.research') ? 'active' : '' }}" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Solutions
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                        <li><a class="dropdown-item" href="{{ route('frontend.services') }}"><i class="fas fa-cogs me-2"></i>Services</a></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.research') }}"><i class="fas fa-microscope me-2"></i>Research</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.publications') }}"><i class="fas fa-book me-2"></i>Publications</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.team') ? 'active' : '' }}" href="{{ route('frontend.team') }}">Team</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.news') ? 'active' : '' }}" href="{{ route('frontend.news') }}">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.careers') ? 'active' : '' }}" href="{{ route('frontend.careers') }}">Careers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}" href="{{ route('frontend.contact') }}">Contact</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <!-- Language Switcher -->
                <div class="dropdown me-3">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe me-1"></i>
                        @switch(app()->getLocale())
                            @case('ar')
                                العربية
                                @break
                            @case('fr')
                                Français
                                @break
                            @default
                                English
                        @endswitch
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                        <li><a class="dropdown-item" href="{{ route('lang.switch', 'fr') }}">Français</a></li>
                        <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">العربية</a></li>
                    </ul>
                </div>

                @auth
                    <!-- Authenticated User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard.index') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="fas fa-user-circle me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Guest User Buttons -->
                    <a href="{{ route('login') }}" class="btn btn-outline-custom me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary-custom">Get Started</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay d-lg-none" id="mobileMenuOverlay"></div>

<style>
.navbar-toggler {
    border: none;
    padding: 0.25rem 0.5rem;
}

.navbar-toggler:focus {
    box-shadow: none;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

.dropdown-menu {
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    padding: 0.5rem 0;
    margin-top: 0.5rem;
}

.dropdown-item {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background-color: rgba(102, 126, 234, 0.1);
    color: var(--primary-color);
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-color: rgba(0, 0, 0, 0.1);
}

.mobile-menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1040;
    display: none;
}

.mobile-menu-overlay.show {
    display: block;
}

@media (max-width: 991.98px) {
    .navbar-collapse {
        background: white;
        border-radius: 12px;
        margin-top: 1rem;
        padding: 1rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .navbar-nav .nav-link {
        margin: 0.25rem 0;
        padding: 0.75rem 1rem !important;
        border-radius: 8px;
    }

    .d-flex.align-items-center {
        margin-top: 1rem;
        justify-content: center;
    }

    .d-flex.align-items-center > * {
        margin: 0.25rem;
    }
}

/* Search functionality */
.search-box {
    position: relative;
    max-width: 300px;
}

.search-input {
    border: 2px solid var(--border-color);
    border-radius: 25px;
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    width: 100%;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-color);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle mobile menu overlay
    const navbarToggler = document.querySelector('.navbar-toggler');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    if (navbarToggler && mobileMenuOverlay) {
        navbarToggler.addEventListener('click', function() {
            setTimeout(() => {
                if (navbarCollapse.classList.contains('show')) {
                    mobileMenuOverlay.classList.add('show');
                } else {
                    mobileMenuOverlay.classList.remove('show');
                }
            }, 100);
        });

        mobileMenuOverlay.addEventListener('click', function() {
            navbarToggler.click();
            mobileMenuOverlay.classList.remove('show');
        });
    }

    // Close mobile menu when clicking on a nav link
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                navbarToggler.click();
                mobileMenuOverlay.classList.remove('show');
            }
        });
    });
});
</script>