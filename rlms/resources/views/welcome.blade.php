<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RLMS') }} - Research Laboratory Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --cardinal-red: #8C1515;
            --cardinal-dark: #6B0F0F;
            --sandstone: #F9F6F2;
            --sandstone-dark: #D4D1CB;
            --cool-gray: #4D4F53;
            --light-sage: #E4F2E7;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            color: var(--cool-gray);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            color: var(--cardinal-red);
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            backdrop-filter: blur(10px);
        }

        nav.scrolled {
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 2px 20px rgba(0,0,0,0.12);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--cardinal-red);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--cool-gray);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--cardinal-red);
        }

        /* Hamburger Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            z-index: 1001;
        }

        .hamburger span {
            width: 28px;
            height: 3px;
            background: var(--cardinal-red);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(8px, -8px);
        }

        .btn-primary {
            background: var(--cardinal-red);
            color: white !important;
            padding: 0.875rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
            font-size: 1rem;
            box-shadow: 0 2px 10px rgba(140, 21, 21, 0.2);
        }

        .btn-primary:hover {
            background: var(--cardinal-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(140, 21, 21, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--cardinal-red) !important;
            padding: 0.875rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid var(--cardinal-red);
            transition: all 0.3s;
            cursor: pointer;
            display: inline-block;
            font-size: 1rem;
        }

        .btn-secondary:hover {
            background: var(--cardinal-red);
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(140, 21, 21, 0.3);
        }

        .btn-contact {
            background: transparent;
            color: var(--cool-gray) !important;
            padding: 0.875rem 2rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
            display: inline-block;
            font-size: 1rem;
            border: none;
        }

        .btn-contact:hover {
            color: var(--cardinal-red) !important;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, var(--sandstone) 0%, #fff 100%);
            overflow: hidden;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 5%;
            text-align: center;
            z-index: 2;
            position: relative;
        }

        .hero h1 {
            font-size: 4rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            animation: fadeInUp 1s ease;
        }

        .hero p {
            font-size: 1.5rem;
            color: var(--cool-gray);
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s backwards;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            animation: fadeInUp 1s ease 0.4s backwards;
        }

        /* Animated Background Blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }

        .blob1 {
            width: 500px;
            height: 500px;
            background: var(--cardinal-red);
            top: -10%;
            left: -10%;
            animation-delay: 0s;
        }

        .blob2 {
            width: 400px;
            height: 400px;
            background: #4D4F53;
            bottom: -10%;
            right: -10%;
            animation-delay: 7s;
        }

        .blob3 {
            width: 300px;
            height: 300px;
            background: var(--light-sage);
            top: 50%;
            right: 10%;
            animation-delay: 14s;
        }

        /* Grid Pattern Overlay */
        .grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(140, 21, 21, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(140, 21, 21, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
        }

        /* Section Styles */
        section {
            padding: 6rem 5%;
        }

        .section-title {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.25rem;
            color: var(--cool-gray);
            margin-bottom: 4rem;
        }

        /* Features Section */
        .features {
            background: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            padding: 2rem;
            background: var(--sandstone);
            border-radius: 15px;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--cardinal-red);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .feature-card p {
            line-height: 1.6;
        }

        /* About Section */
        .about {
            background: var(--sandstone);
            position: relative;
            overflow: hidden;
        }

        .about-content {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .about-content p {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            color: var(--cool-gray);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--cardinal-red);
            font-family: 'Playfair Display', serif;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--cool-gray);
            margin-top: 0.5rem;
        }

        /* Team Section */
        .team {
            background: white;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .team-card {
            text-align: center;
            padding: 2rem;
            background: var(--sandstone);
            border-radius: 15px;
            transition: all 0.3s;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .team-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--cardinal-red), var(--cardinal-dark));
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }

        .team-name {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .team-role {
            color: var(--cool-gray);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .team-bio {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--cool-gray);
        }

        /* Research Section */
        .research {
            background: var(--sandstone);
        }

        .research-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .research-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }

        .research-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .research-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--cardinal-red), var(--cardinal-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }

        .research-content {
            padding: 2rem;
        }

        .research-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .research-card p {
            line-height: 1.6;
            color: var(--cool-gray);
            margin-bottom: 1rem;
        }

        .research-meta {
            font-size: 0.9rem;
            color: #999;
        }

        /* Events Section */
        .events {
            background: white;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .event-card {
            background: var(--sandstone);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .event-header {
            background: linear-gradient(135deg, var(--cardinal-red), var(--cardinal-dark));
            padding: 2rem;
            color: white;
            text-align: center;
        }

        .event-date {
            font-size: 3rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            line-height: 1;
        }

        .event-month {
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0.5rem;
        }

        .event-content {
            padding: 2rem;
        }

        .event-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .event-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .event-info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--cool-gray);
            font-size: 0.95rem;
        }

        .event-info-icon {
            font-size: 1.2rem;
        }

        .event-description {
            line-height: 1.6;
            color: var(--cool-gray);
            margin-bottom: 1.5rem;
        }

        .event-attendees {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0,0,0,0.1);
        }

        .attendees-avatars {
            display: flex;
            margin-left: -0.5rem;
        }

        .attendee-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--cardinal-red), var(--cardinal-dark));
            border: 2px solid white;
            margin-left: -0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .attendees-count {
            font-size: 0.9rem;
            color: var(--cool-gray);
        }

        .btn-rsvp {
            width: 100%;
            background: var(--cardinal-red);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            font-size: 1rem;
        }

        .btn-rsvp:hover {
            background: var(--cardinal-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(140, 21, 21, 0.3);
        }

        /* Contact Section */
        .contact {
            background: var(--sandstone);
        }

        .contact-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .contact-info {
            text-align: center;
            padding: 2rem;
            background: var(--sandstone);
            border-radius: 15px;
        }

        .contact-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .contact-info h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .contact-info p {
            color: var(--cool-gray);
        }

        .contact-form {
            background: var(--sandstone);
            padding: 2rem;
            border-radius: 15px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--cool-gray);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--sandstone-dark);
            border-radius: 8px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--cardinal-red);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Footer */
        footer {
            background: var(--cool-gray);
            color: white;
            padding: 3rem 5%;
            text-align: center;
        }

        footer p {
            color: #ccc;
        }

        .footer-links {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            33% {
                transform: translate(30px, -50px) rotate(120deg);
            }
            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.2rem;
            }

            .hamburger {
                display: flex;
            }

            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                background: white;
                flex-direction: column;
                padding: 6rem 2rem 2rem;
                box-shadow: -5px 0 20px rgba(0,0,0,0.1);
                transition: right 0.3s ease;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links li {
                width: 100%;
            }

            .nav-links a {
                display: block;
                padding: 0.75rem 0;
                width: 100%;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .section-title {
                font-size: 2rem;
            }

            section {
                padding: 4rem 5%;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <a href="/" class="logo">RLMS</a>

        <!-- Hamburger Menu -->
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="#features">Features</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#team">Team</a></li>
            <li><a href="#research">Research</a></li>
            <li><a href="#events">Events</a></li>
            <li><a href="#contact" class="btn-contact">Contact</a></li>
            @auth
                <li><a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a></li>
            @else
                <li><a href="{{ route('login') }}" class="btn-secondary">Login</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}" class="btn-primary">Get Started</a></li>
                @endif
            @endauth
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="blob blob1"></div>
        <div class="blob blob2"></div>
        <div class="blob blob3"></div>
        <div class="grid-overlay"></div>

        <div class="hero-content">
            <h1>Research Laboratory<br>Management System</h1>
            <p>Streamline your research operations with our comprehensive lab management platform</p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                    <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2 class="section-title">Powerful Features</h2>
        <p class="section-subtitle">Everything you need to manage your research laboratory efficiently</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔬</div>
                <h3>Equipment Management</h3>
                <p>Track and manage all your laboratory equipment, materials, and resources in one centralized system.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Reservation System</h3>
                <p>Streamline equipment booking with our intuitive reservation and approval workflow system.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Project Tracking</h3>
                <p>Manage research projects, collaborate with team members, and track progress in real-time.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🧪</div>
                <h3>Experiment Logs</h3>
                <p>Document experiments, attach files, and maintain comprehensive research records effortlessly.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📆</div>
                <h3>Event Management</h3>
                <p>Organize lab events, seminars, and meetings with RSVP tracking and notifications.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">⚙️</div>
                <h3>Maintenance Tracking</h3>
                <p>Schedule and track equipment maintenance to ensure optimal laboratory operations.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <h2 class="section-title">About Our Laboratory</h2>
        <div class="about-content">
            <p>
                Our research laboratory is dedicated to advancing scientific knowledge through innovative research and collaboration.
                With state-of-the-art equipment and a team of dedicated researchers, we strive to make significant contributions
                to our field while fostering the next generation of scientists.
            </p>
            <p>
                The RLMS platform enables us to manage our resources efficiently, coordinate research activities,
                and maintain comprehensive records of our scientific endeavors.
            </p>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Equipment Items</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Active Projects</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Researchers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Publications</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team" id="team">
        <h2 class="section-title">Our Team</h2>
        <p class="section-subtitle">Meet the brilliant minds driving our research forward</p>

        <div class="team-grid">
            <div class="team-card">
                <div class="team-avatar">PI</div>
                <h3 class="team-name">Principal Investigator</h3>
                <p class="team-role">Lab Director</p>
                <p class="team-bio">Leading groundbreaking research in laboratory management and scientific innovation.</p>
            </div>

            <div class="team-card">
                <div class="team-avatar">SR</div>
                <h3 class="team-name">Senior Researcher</h3>
                <p class="team-role">Research Lead</p>
                <p class="team-bio">Specializing in experimental design and data analysis for complex research projects.</p>
            </div>

            <div class="team-card">
                <div class="team-avatar">LS</div>
                <h3 class="team-name">Lab Scientist</h3>
                <p class="team-role">Equipment Specialist</p>
                <p class="team-bio">Managing laboratory equipment and ensuring optimal research conditions.</p>
            </div>

            <div class="team-card">
                <div class="team-avatar">RA</div>
                <h3 class="team-name">Research Assistant</h3>
                <p class="team-role">Support Staff</p>
                <p class="team-bio">Supporting research activities and maintaining laboratory protocols.</p>
            </div>
        </div>
    </section>

    <!-- Research Section -->
    <section class="research" id="research">
        <h2 class="section-title">Research Areas</h2>
        <p class="section-subtitle">Explore our current research projects and publications</p>

        <div class="research-grid">
            <div class="research-card">
                <div class="research-image">🧬</div>
                <div class="research-content">
                    <h3>Molecular Biology</h3>
                    <p>Investigating cellular mechanisms and molecular interactions to understand fundamental biological processes.</p>
                    <p class="research-meta">15 Active Projects | 45 Publications</p>
                </div>
            </div>

            <div class="research-card">
                <div class="research-image">🔬</div>
                <div class="research-content">
                    <h3>Analytical Chemistry</h3>
                    <p>Developing advanced analytical methods for chemical characterization and quality control.</p>
                    <p class="research-meta">12 Active Projects | 38 Publications</p>
                </div>
            </div>

            <div class="research-card">
                <div class="research-image">🧪</div>
                <div class="research-content">
                    <h3>Materials Science</h3>
                    <p>Exploring novel materials and their applications in technology and industry.</p>
                    <p class="research-meta">10 Active Projects | 32 Publications</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="events" id="events">
        <h2 class="section-title">Upcoming Events</h2>
        <p class="section-subtitle">Join us for seminars, workshops, and research presentations</p>

        <div class="events-grid">
            <!-- Event 1 -->
            <div class="event-card">
                <div class="event-header">
                    <div class="event-date">15</div>
                    <div class="event-month">January 2026</div>
                </div>
                <div class="event-content">
                    <h3>Advanced Microscopy Workshop</h3>
                    <div class="event-info">
                        <div class="event-info-item">
                            <span class="event-info-icon">🕐</span>
                            <span>09:00 AM - 05:00 PM</span>
                        </div>
                        <div class="event-info-item">
                            <span class="event-info-icon">📍</span>
                            <span>Lab Building, Room 301</span>
                        </div>
                        <div class="event-info-item">
                            <span class="event-info-icon">👤</span>
                            <span>Dr. Sarah Johnson</span>
                        </div>
                    </div>
                    <p class="event-description">
                        Learn advanced techniques in electron microscopy and confocal imaging.
                        Hands-on session with state-of-the-art equipment.
                    </p>
                    <div class="event-attendees">
                        <div class="attendees-avatars">
                            <div class="attendee-avatar">JD</div>
                            <div class="attendee-avatar">SM</div>
                            <div class="attendee-avatar">AL</div>
                            <div class="attendee-avatar">+12</div>
                        </div>
                        <span class="attendees-count">15 attending</span>
                    </div>
                    <a href="{{ route('login') }}" class="btn-rsvp">RSVP Now</a>
                </div>
            </div>

            <!-- Event 2 -->
            <div class="event-card">
                <div class="event-header">
                    <div class="event-date">22</div>
                    <div class="event-month">January 2026</div>
                </div>
                <div class="event-content">
                    <h3>Research Seminar Series</h3>
                    <div class="event-info">
                        <div class="event-info-item">
                            <span class="event-info-icon">🕐</span>
                            <span>02:00 PM - 04:00 PM</span>
                        </div>
                        <div class="event-info-item">
                            <span class="event-info-icon">📍</span>
                            <span>Conference Hall A</span>
                        </div>
                        <div class="event-info-item">
                            <span class="event-info-icon">👤</span>
                            <span>Prof. Michael Chen</span>
                        </div>
                    </div>
                    <p class="event-description">
                        Presentation on breakthrough findings in molecular biology.
                        Q&A session and networking opportunity with leading researchers.
                    </p>
                    <div class="event-attendees">
                        <div class="attendees-avatars">
                            <div class="attendee-avatar">MC</div>
                            <div class="attendee-avatar">RK</div>
                            <div class="attendee-avatar">TP</div>
                            <div class="attendee-avatar">+25</div>
                        </div>
                        <span class="attendees-count">28 attending</span>
                    </div>
                    <a href="{{ route('login') }}" class="btn-rsvp">RSVP Now</a>
                </div>
            </div>

            <!-- Event 3 -->
            <div class="event-card">
                <div class="event-header">
                    <div class="event-date">05</div>
                    <div class="event-month">February 2026</div>
                </div>
                <div class="event-content">
                    <h3>Lab Safety Training</h3>
                    <div class="event-info">
                        <div class="event-info-item">
                            <span class="event-info-icon">🕐</span>
                            <span>10:00 AM - 12:00 PM</span>
                        </div>
                        <div class="event-info-item">
                            <span class="event-info-icon">📍</span>
                            <span>Training Center</span>
                        </div>
                        <div class="event-info-item">
                            <span class="event-info-icon">👤</span>
                            <span>Safety Officer</span>
                        </div>
                    </div>
                    <p class="event-description">
                        Mandatory safety training for all new lab members.
                        Covers chemical handling, equipment safety, and emergency procedures.
                    </p>
                    <div class="event-attendees">
                        <div class="attendees-avatars">
                            <div class="attendee-avatar">NK</div>
                            <div class="attendee-avatar">LM</div>
                            <div class="attendee-avatar">+8</div>
                        </div>
                        <span class="attendees-count">10 attending</span>
                    </div>
                    <a href="{{ route('login') }}" class="btn-rsvp">RSVP Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <h2 class="section-title">Get In Touch</h2>
        <p class="section-subtitle">We'd love to hear from you</p>

        <div class="contact-container">
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-icon">📍</div>
                    <h3>Location</h3>
                    <p>Research Building<br>University Campus<br>City, Country</p>
                </div>

                <div class="contact-info">
                    <div class="contact-icon">📧</div>
                    <h3>Email</h3>
                    <p>info@rlms.edu<br>lab@research.edu</p>
                </div>

                <div class="contact-info">
                    <div class="contact-icon">📞</div>
                    <h3>Phone</h3>
                    <p>+1 (555) 123-4567<br>Mon-Fri, 9AM-5PM</p>
                </div>
            </div>

            <div class="contact-form">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%;">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'RLMS') }}. All rights reserved.</p>
        <p style="margin-top: 0.5rem; font-size: 0.9rem;">Research Laboratory Management System</p>

        <div class="footer-links">
            <a href="#features">Features</a>
            <a href="#about">About</a>
            <a href="#team">Team</a>
            <a href="#research">Research</a>
            <a href="#events">Events</a>
            <a href="#contact">Contact</a>
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Hamburger menu toggle
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });

        // Close menu when clicking on a link
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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
    </script>
</body>
</html>
