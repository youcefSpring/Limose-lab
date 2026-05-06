<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? config('app.name', 'RLMS') }} - {{ $settings['site_tagline'] ?? 'نظام إدارة معمل الأبحاث' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @php
        $primaryColor = $settings['primary_color'] ?? '#8C1515';
        $primaryDark = $settings['button_hover_color'] ?? '#6B0F0F';
        $secondaryColor = $settings['secondary_color'] ?? '#F9F6F2';
        $textColor = $settings['text_color'] ?? '#4D4F53';
        $accentColor = $settings['accent_color'] ?? '#FF6B35';
        $logoUrl = $settings['primary_logo'] ?? null;
    @endphp

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --cardinal-red: {{ $primaryColor }};
            --cardinal-dark: {{ $primaryDark }};
            --sandstone: {{ $secondaryColor }};
            --sandstone-dark: #D4D1CB;
            --cool-gray: {{ $textColor }};
            --light-sage: #E4F2E7;
            --accent: {{ $accentColor }};
        }
        body { font-family: 'Tajawal', sans-serif; color: var(--cool-gray); overflow-x: hidden; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Tajawal', serif; color: var(--cardinal-red); }

        nav { position: fixed; top: 0; width: 100%; padding: 1.5rem 5%; display: flex; justify-content: space-between; align-items: center; z-index: 1000; transition: all 0.3s ease; background: rgba(255, 255, 255, 0.98); box-shadow: 0 2px 15px rgba(0,0,0,0.08); backdrop-filter: blur(10px); }
        nav.scrolled { background: rgba(255, 255, 255, 1); box-shadow: 0 2px 20px rgba(0,0,0,0.12); }
        .logo { font-family: 'Tajawal', serif; font-size: 1.75rem; font-weight: 700; color: var(--cardinal-red); text-decoration: none; }
        .nav-links { display: flex; gap: 2rem; list-style: none; align-items: center; }
        .nav-links a { text-decoration: none; color: var(--cool-gray); font-weight: 500; transition: color 0.3s; }
        .nav-links a:hover { color: var(--cardinal-red); }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; z-index: 1001; }
        .hamburger span { width: 28px; height: 3px; background: var(--cardinal-red); border-radius: 3px; transition: all 0.3s ease; }
        .hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(8px, 8px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(8px, -8px); }

        .btn-primary { background: var(--cardinal-red); color: white !important; padding: 0.875rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s; border: none; cursor: pointer; display: inline-block; font-size: 1rem; box-shadow: 0 2px 10px rgba(140, 21, 21, 0.2); }
        .btn-primary:hover { background: var(--cardinal-dark); transform: translateY(-2px); box-shadow: 0 5px 20px rgba(140, 21, 21, 0.4); }
        .btn-secondary { background: white; color: var(--cardinal-red) !important; padding: 0.875rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; border: 2px solid var(--cardinal-red); transition: all 0.3s; cursor: pointer; display: inline-block; font-size: 1rem; }
        .btn-secondary:hover { background: var(--cardinal-red); color: white !important; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(140, 21, 21, 0.3); }
        .btn-contact { background: transparent; color: var(--cool-gray) !important; padding: 0.875rem 2rem; text-decoration: none; font-weight: 500; transition: all 0.3s; cursor: pointer; display: inline-block; font-size: 1rem; border: none; }
        .btn-contact:hover { color: var(--cardinal-red) !important; }

        .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; background: linear-gradient(135deg, var(--sandstone) 0%, #fff 100%); overflow: hidden; }
        .hero-content { max-width: 1200px; margin: 0 auto; padding: 0 5%; text-align: center; z-index: 2; position: relative; }
        .hero h1 { font-size: 3rem; line-height: 1.4; margin-bottom: 1.5rem; animation: fadeInUp 1s ease; }
        .hero p { font-size: 1.25rem; color: var(--cool-gray); margin-bottom: 2rem; animation: fadeInUp 1s ease 0.2s backwards; }
        .hero-buttons { display: flex; gap: 1rem; justify-content: center; animation: fadeInUp 1s ease 0.4s backwards; }

        .blob { position: absolute; border-radius: 50%; filter: blur(60px); opacity: 0.3; animation: float 20s ease-in-out infinite; }
        .blob1 { width: 500px; height: 500px; background: var(--cardinal-red); top: -10%; left: -10%; animation-delay: 0s; }
        .blob2 { width: 400px; height: 400px; background: #4D4F53; bottom: -10%; right: -10%; animation-delay: 7s; }
        .blob3 { width: 300px; height: 300px; background: var(--light-sage); top: 50%; right: 10%; animation-delay: 14s; }
        .grid-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: linear-gradient(rgba(140, 21, 21, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(140, 21, 21, 0.03) 1px, transparent 1px); background-size: 50px 50px; pointer-events: none; }

        section { padding: 6rem 5%; }
        .section-title { text-align: center; font-size: 2.5rem; margin-bottom: 1rem; }
        .section-subtitle { text-align: center; font-size: 1.1rem; color: var(--cool-gray); margin-bottom: 4rem; }

        .features { background: white; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto; }
        .feature-card { padding: 2rem; background: var(--sandstone); border-radius: 15px; transition: all 0.3s; border: 2px solid transparent; }
        .feature-card:hover { transform: translateY(-10px); border-color: var(--cardinal-red); box-shadow: 0 15px 40px rgba(0,0,0,0.1); }
        .feature-icon { font-size: 3rem; margin-bottom: 1rem; }
        .feature-card h3 { font-size: 1.3rem; margin-bottom: 1rem; }
        .feature-card p { line-height: 1.6; }

        .about { background: var(--sandstone); position: relative; overflow: hidden; }
        .about-content { max-width: 900px; margin: 0 auto; text-align: center; }
        .about-content p { font-size: 1.1rem; line-height: 1.8; margin-bottom: 1.5rem; color: var(--cool-gray); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3rem; }
        .stat-card { text-align: center; padding: 2rem; background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .stat-number { font-size: 2.5rem; font-weight: 700; color: var(--cardinal-red); font-family: 'Tajawal', serif; }
        .stat-label { font-size: 0.95rem; color: var(--cool-gray); margin-top: 0.5rem; }

        .team { background: white; }
        .team-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto; }
        .team-card { text-align: center; padding: 2rem; background: var(--sandstone); border-radius: 15px; transition: all 0.3s; }
        .team-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .team-avatar { width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, var(--cardinal-red), var(--cardinal-dark)); margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; font-family: 'Tajawal', serif; }
        .team-name { font-size: 1.3rem; margin-bottom: 0.5rem; }
        .team-role { color: var(--cool-gray); font-size: 0.95rem; margin-bottom: 1rem; }
        .team-bio { font-size: 0.9rem; line-height: 1.6; color: var(--cool-gray); }

        .research { background: var(--sandstone); }
        .research-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto; }
        .research-card { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s; }
        .research-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .research-image { width: 100%; height: 150px; background: linear-gradient(135deg, var(--cardinal-red), var(--cardinal-dark)); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
        .research-content { padding: 1.5rem; }
        .research-card h3 { font-size: 1.2rem; margin-bottom: 0.75rem; }
        .research-card p { line-height: 1.6; color: var(--cool-gray); margin-bottom: 0.75rem; font-size: 0.9rem; }
        .research-meta { font-size: 0.8rem; color: #999; }

        .events { background: white; }
        .events-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto; }
        .event-card { background: var(--sandstone); border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s; }
        .event-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        .event-header { background: linear-gradient(135deg, var(--cardinal-red), var(--cardinal-dark)); padding: 1.5rem; color: white; text-align: center; }
        .event-date { font-size: 2.5rem; font-weight: 700; font-family: 'Tajawal', serif; line-height: 1; }
        .event-month { font-size: 1rem; text-transform: uppercase; letter-spacing: 2px; margin-top: 0.5rem; }
        .event-content { padding: 1.5rem; }
        .event-card h3 { font-size: 1.2rem; margin-bottom: 1rem; }
        .event-info { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem; }
        .event-info-item { display: flex; align-items: center; gap: 0.5rem; color: var(--cool-gray); font-size: 0.85rem; }
        .event-info-icon { font-size: 1rem; }
        .event-description { line-height: 1.6; color: var(--cool-gray); margin-bottom: 1rem; font-size: 0.9rem; }
        .event-attendees { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid rgba(0,0,0,0.1); }
        .attendees-avatars { display: flex; }
        .attendee-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--cardinal-red), var(--cardinal-dark)); border: 2px solid white; margin-left: -0.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; font-weight: 600; }
        .attendees-count { font-size: 0.8rem; color: var(--cool-gray); }
        .btn-rsvp { width: 100%; background: var(--cardinal-red); color: white; padding: 0.875rem; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s; border: none; cursor: pointer; display: inline-block; text-align: center; font-size: 0.95rem; }
        .btn-rsvp:hover { background: var(--cardinal-dark); transform: translateY(-2px); box-shadow: 0 5px 20px rgba(140, 21, 21, 0.3); }

        .contact { background: var(--sandstone); }
        .contact-container { max-width: 1200px; margin: 0 auto; }
        .contact-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
        .contact-info { text-align: center; padding: 1.5rem; background: var(--sandstone); border-radius: 15px; }
        .contact-icon { font-size: 2rem; margin-bottom: 0.75rem; }
        .contact-info h3 { font-size: 1.1rem; margin-bottom: 0.5rem; }
        .contact-info p { color: var(--cool-gray); font-size: 0.9rem; }
        .contact-bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .contact-form { background: var(--sandstone); padding: 1.5rem; border-radius: 15px; }
        .contact-map { border-radius: 15px; overflow: hidden; background: var(--sandstone); min-height: 350px; }
        .map-placeholder { display: flex; align-items: center; justify-content: center; height: 100%; min-height: 350px; background: var(--sandstone); color: var(--cool-gray); border-radius: 15px; padding: 1.5rem; font-size: 0.9rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--cool-gray); font-size: 0.9rem; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.625rem; border: 2px solid var(--sandstone-dark); border-radius: 8px; font-family: 'Tajawal', sans-serif; font-size: 0.95rem; transition: border-color 0.3s; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: var(--cardinal-red); }
        .form-group textarea { resize: vertical; min-height: 100px; }

        footer { background: var(--cool-gray); color: white; padding: 2.5rem 5%; text-align: center; }
        footer p { color: #ccc; font-size: 0.9rem; }
        .footer-links { margin-top: 1.5rem; display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap; font-size: 0.85rem; }
        .footer-links a { color: #ccc; text-decoration: none; transition: color 0.3s; }
        .footer-links a:hover { color: white; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translate(0, 0) rotate(0deg); } 33% { transform: translate(30px, -50px) rotate(120deg); } 66% { transform: translate(-20px, 20px) rotate(240deg); } }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero p { font-size: 1rem; }
            .hamburger { display: flex; }
            .nav-links { position: fixed; top: 0; left: -100%; width: 280px; height: 100vh; background: white; flex-direction: column; padding: 6rem 2rem 2rem; box-shadow: 5px 0 20px rgba(0,0,0,0.1); transition: left 0.3s ease; align-items: flex-start; gap: 1.5rem; }
            .nav-links.active { left: 0; }
            .nav-links li { width: 100%; }
            .nav-links a { display: block; padding: 0.75rem 0; width: 100%; }
            .hero-buttons { flex-direction: column; }
            .contact-bottom-grid { grid-template-columns: 1fr; }
            .contact-map iframe { min-height: 250px; }
            .section-title { font-size: 1.75rem; }
            section { padding: 3rem 5%; }
        }
    </style>
</head>
<body>
    <nav id="navbar">
        @if($logoUrl && file_exists(public_path('storage/' . $logoUrl)))
            <a href="/" class="logo">
                <img src="{{ asset('storage/' . $logoUrl) }}" alt="{{ $settings['site_name'] ?? 'RLMS' }}" style="max-height: 40px; max-width: 180px;">
            </a>
        @else
            <a href="/" class="logo">RLMS</a>
        @endif

        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>

        <ul class="nav-links" id="navLinks">
            <li><a href="#features">الميزات</a></li>
            <li><a href="#about">عن المختبر</a></li>
            <li><a href="#team">الفريق</a></li>
            <li><a href="#research">البحث</a></li>
            <li><a href="#events">الفعاليات</a></li>
            <li><a href="#contact" class="btn-contact">اتصل بنا</a></li>
            <li>
                <select onchange="window.location.href=this.value" class="bg-transparent text-sm font-medium cursor-pointer border-none outline-none">
                    <option value="{{ route('locale.switch', 'ar') }}" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>AR</option>
                    <option value="{{ route('locale.switch', 'en') }}" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                    <option value="{{ route('locale.switch', 'fr') }}" {{ app()->getLocale() === 'fr' ? 'selected' : '' }}>FR</option>
                </select>
            </li>
            @auth
                <li><a href="{{ url('/dashboard') }}" class="btn-primary">لوحة التحكم</a></li>
            @else
                <li><a href="{{ route('login') }}" class="btn-secondary">تسجيل الدخول</a></li>
                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}" class="btn-primary">ابدأ الآن</a></li>
                @endif
            @endauth
        </ul>
    </nav>

    <section class="hero">
        <div class="blob blob1"></div>
        <div class="blob blob2"></div>
        <div class="blob blob3"></div>
        <div class="grid-overlay"></div>

        <div class="hero-content">
            @if($logoUrl && file_exists(public_path('storage/' . $logoUrl)))
                <img src="{{ asset('storage/' . $logoUrl) }}" alt="{{ $settings['site_name'] ?? 'RLMS' }}" style="max-height: 100px; margin-bottom: 1.5rem;">
            @endif
            <h1>نظام إدارة<br>معمل الأبحاث</h1>
            <p>قم بتبسيط عمليات البحث باستخدام منصة إدارة المختبرات الشاملة لدينا</p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary">اذهب للوحة التحكم</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">ابدأ الآن</a>
                    <a href="{{ route('login') }}" class="btn-secondary">تسجيل الدخول</a>
                @endauth
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <h2 class="section-title">الميزات القوية</h2>
        <p class="section-subtitle">كل ما تحتاجه لإدارة معمل البحث الخاص بك بكفاءة</p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔬</div>
                <h3>إدارة المعدات</h3>
                <p>تتبع وإدارة جميع معدات ومواد المختبر الخاصة بك في نظام مركزي واحد.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>نظام الحجز</h3>
                <p>قم بتبسيط حجز المعدات من خلال نظام الحجز والموافقة البديهي ours.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>تتبع المشاريع</h3>
                <p>إدارة مشاريع البحث، والتعاون مع أعضاء الفريق، وتتبع التقدم في الوقت الفعلي.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧪</div>
                <h3>سجلات التجارب</h3>
                <p>توثيق التجارب وإرفاق الملفات والحفاظ على سجلات بحث شاملة بسهولة.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📆</div>
                <h3>إدارة الفعاليات</h3>
                <p>تنظيم فعاليات وملدوات واجتماعات المختبر مع تتبع RSVP والإشعارات.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚙️</div>
                <h3>تتبع الصيانة</h3>
                <p>جدولة وتتبع صيانة المعدات لضمان العمليات المثلى للمختبر.</p>
            </div>
        </div>
    </section>

    <section class="about" id="about">
        <h2 class="section-title">عن مختبرنا</h2>
        <div class="about-content">
            <p>مختبر البحث الخاص بنا مكرس لتعزيز المعرفة العلمية من خلال البحث الابتكاري والتعاون. باستخدام المعدات الحديثة وفريق من الباحثين المتفانين، نسعى لإحداث مساهمات كبيرة في مجموعتنا مع رعاية الجيل القادم من العلماء.</p>
            <p>تتيح لنا منصة RLMS إدارة مواردنا بكفاءة، وتنسيق الأنشطة البحثية، والحفاظ على سجلات شاملة لجهودنا العلمية.</p>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">٥٠٠+</div>
                    <div class="stat-label">قطعة معدات</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">٥٠+</div>
                    <div class="stat-label">مشاريع نشطة</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">١٠٠+</div>
                    <div class="stat-label">باحثين</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">٢٠٠+</div>
                    <div class="stat-label">منشورات</div>
                </div>
            </div>
        </div>
    </section>

    <section class="team" id="team">
        <h2 class="section-title">فريقنا</h2>
        <p class="section-subtitle">لقاء العقول اللامعة التي تدفع بحثنا إلى الأمام</p>

        <div class="team-grid">
            <div class="team-card">
                <div class="team-avatar">ب</div>
                <h3 class="team-name">الباحث الرئيسي</h3>
                <p class="team-role">مدير المختبر</p>
                <p class="team-bio">قيادة البحث الرائد في إدارة المعامل والابتكار العلمي.</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">ب</div>
                <h3 class="team-name">الباحث الأول</h3>
                <p class="team-role">قائد البحث</p>
                <p class="team-bio">التخصص في تصميم التجارب وتحليل البيانات للمشاريع البحثية المعقدة.</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">ع</div>
                <h3 class="team-name">عالم المختبر</h3>
                <p class="team-role">متخصص المعدات</p>
                <p class="team-bio">إدارة معدات المختبر وضمان ظروف البحث المثلى.</p>
            </div>
            <div class="team-card">
                <div class="team-avatar">م</div>
                <h3 class="team-name">مساعد البحث</h3>
                <p class="team-role">طاقم الدعم</p>
                <p class="team-bio">دعم الأنشطة البحثية والحفاظ على بروتوكولات المختبر.</p>
            </div>
        </div>
    </section>

    <section class="research" id="research">
        <h2 class="section-title">مجالات البحث</h2>
        <p class="section-subtitle">استكشف مشاريع البحث والمنشورات الحالية لدينا</p>

        <div class="research-grid">
            <div class="research-card">
                <div class="research-image">🧬</div>
                <div class="research-content">
                    <h3>البيولوجيا الجزيئية</h3>
                    <p>تحليل الآليات الخلوية والتفاعلات الجزيئية لفهم العمليات البيولوجية الأساسية.</p>
                    <p class="research-meta">١٥ مشروع نشط | ٤٥ منشور</p>
                </div>
            </div>
            <div class="research-card">
                <div class="research-image">🔬</div>
                <div class="research-content">
                    <h3>الكيمياء التحليلية</h3>
                    <p>تطوير طرق تحليلية متقدمة للتوصيف الكيميائي ومراقبة الجودة.</p>
                    <p class="research-meta">١٢ مشروع نشط | ٣٨ منشور</p>
                </div>
            </div>
            <div class="research-card">
                <div class="research-image">🧪</div>
                <div class="research-content">
                    <h3>علم المواد</h3>
                    <p>استكشاف المواد الجديدة وتطبيقاتها في التكنولوجيا والصناعة.</p>
                    <p class="research-meta">١٠ مشاريع نشطة | ٣٢ منشور</p>
                </div>
            </div>
        </div>
    </section>

    <section class="events" id="events">
        <h2 class="section-title">الفعاليات القادمة</h2>
        <p class="section-subtitle">انضممنا للحلقات والورش وعروض البحث</p>

        @if($upcomingEvents->count() > 0)
        <div class="events-grid">
            @foreach($upcomingEvents as $event)
            <div class="event-card">
                <div class="event-header">
                    <div class="event-date">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                    <div class="event-month">{{ \Carbon\Carbon::parse($event->event_date)->format('F Y') }}</div>
                </div>
                <div class="event-content">
                    <h3>{{ $event->title }}</h3>
                    <div class="event-info">
                        <div class="event-info-item">
                            <span class="event-info-icon">🕐</span>
                            <span>{{ $event->event_time ?? 'كل اليوم' }}</span>
                        </div>
                        <div class="event-info-item">
                            <span class="event-info-icon">📍</span>
                            <span>{{ $event->location ?? 'سيحدد لاحقاً' }}</span>
                        </div>
                    </div>
                    <p class="event-description">{{ Str::limit($event->description, 100) }}</p>
                    <div class="event-attendees">
                        <div class="attendees-avatars">
                            <div class="attendee-avatar">{{ $event->confirmedAttendees()->count() }}</div>
                        </div>
                        <span class="attendees-count">{{ $event->confirmedAttendees()->count() }} مشترك</span>
                    </div>
                    @auth
                        <a href="{{ route('events.show', $event) }}" class="btn-rsvp">عرض التفاصيل</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-rsvp">سجل الآن</a>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p style="text-align: center; color: var(--cool-gray);">لا توجد فعاليات قادمة في الوقت الحالي. تحقق قريباً!</p>
        @endif
    </section>

    <section class="contact" id="contact">
        <h2 class="section-title">اتصل بنا</h2>
        <p class="section-subtitle"> nous adorerions avoir de vos nouvelles</p>

        <div class="contact-container">
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-icon">📍</div>
                    <h3>{{ __('messages.Location') }}</h3>
                    <p>{!! nl2br(e($settings['location_address'] ?? 'مبنى البحث، الحرم الجامعي، المدينة، الدولة')) !!}</p>
                </div>
                <div class="contact-info">
                    <div class="contact-icon">📧</div>
                    <h3>{{ __('messages.Email') }}</h3>
                    <p>{{ $settings['contact_email_2'] ?? 'info@lab.edu' }}</p>
                    <p>{{ $settings['contact_email'] ?? 'lab@research.edu' }}</p>
                </div>
                <div class="contact-info">
                    <div class="contact-icon">📞</div>
                    <h3>{{ __('messages.Phone') }}</h3>
                    <p>{{ $settings['contact_phone'] ?? '+1 (555) 123-4567' }}</p>
                    <p>{{ $settings['contact_hours'] ?? 'الأحد-الخميس، ٩ص-٥م' }}</p>
                </div>
            </div>

            <div class="contact-bottom-grid">
                <div class="contact-form">
                    @csrf
                    @if(session('success'))
                        <div class="mb-4 p-3 rounded-lg bg-emerald-500/10 text-emerald-600 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('contact.store') }}">
                        <div class="form-group">
                            <label for="name">الاسم</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">الموضوع</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">الرسالة</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%;">إرسال الرسالة</button>
                    </form>
                </div>
                <div class="contact-map">
                    @php
                        $mapEmbed = $settings['map_embed'] ?? '';
                        $mapSrc = $mapEmbed;
                        if (preg_match('/src="([^"]+)"/', $mapEmbed, $matches)) {
                            $mapSrc = $matches[1];
                        }
                    @endphp
                    @if(!empty($mapSrc))
                        <iframe src="{{ $mapSrc }}" width="100%" height="100%" style="border:0; min-height: 350px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <div class="map-placeholder"><p>لم يتم تكوين خريطة. أضف كود الخريطة في الإعدادات.</p></div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'RLMS') }}. جميع الحقوق محفوظة.</p>
        <p style="margin-top: 0.5rem; font-size: 0.85rem;">نظام إدارة معمل الأبحاث</p>
        <div class="footer-links">
            <a href="#features">الميزات</a>
            <a href="#about">عن المختبر</a>
            <a href="#team">الفريق</a>
            <a href="#research">البحث</a>
            <a href="#events">الفعاليات</a>
            <a href="#contact">اتصل بنا</a>
            @auth
                <a href="{{ url('/dashboard') }}">لوحة التحكم</a>
            @else
                <a href="{{ route('login') }}">تسجيل الدخول</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">التسجيل</a>
                @endif
            @endauth
        </div>
    </footer>

    <script>
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });
        document.addEventListener('click', (e) => {
            if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
</body>
</html>