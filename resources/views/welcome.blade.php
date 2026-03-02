<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PUTP — Sistem Pelayanan Tes Material</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy:   #1A0F00;
            --navy-2: #231400;
            --teal:   #EA580C;
            --teal-l: #FB923C;
            --gold:   #FED7AA;
            --cream:  #FFF7ED;
            --muted:  #A8A29E;
            --white:  #FFFFFF;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--navy);
            overflow-x: hidden;
        }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            background: var(--navy);
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(234,88,12,.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(234,88,12,.08) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 100px;
            background: var(--cream);
            clip-path: polygon(0 100%, 100% 100%, 100% 40%, 0 100%);
        }

        /* ── NAV ── */
        nav {
            position: relative;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 48px;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .nav-logo {
            width: 42px;
            height: 42px;
            background: var(--teal);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Serif Display', serif;
            font-size: 13px;
            font-weight: 700;
            color: white;
            letter-spacing: -.5px;
            flex-shrink: 0;
        }

        .nav-name {
            display: flex;
            flex-direction: column;
        }

        .nav-title {
            font-size: 13px;
            font-weight: 600;
            color: white;
            letter-spacing: .5px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .nav-sub {
            font-size: 11px;
            color: var(--muted);
            letter-spacing: .3px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Hamburger */
        .nav-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 6px;
            background: transparent;
            border: none;
            z-index: 200;
        }

        .nav-toggle span {
            display: block;
            width: 24px;
            height: 2px;
            background: white;
            border-radius: 2px;
            transition: all .3s;
        }

        .nav-toggle.active span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }
        .nav-toggle.active span:nth-child(2) {
            opacity: 0;
        }
        .nav-toggle.active span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        /* Mobile Menu Overlay */
        .mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            background: var(--navy-2);
            z-index: 99;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 24px;
            padding: 24px;
        }

        .mobile-menu.open {
            display: flex;
        }

        .mobile-menu .btn {
            width: 100%;
            max-width: 320px;
            justify-content: center;
            font-size: 16px;
            padding: 16px 24px;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
            border: none;
            font-family: 'DM Sans', sans-serif;
            white-space: nowrap;
        }

        .btn-ghost {
            background: transparent;
            color: rgba(255,255,255,.75);
            border: 1px solid rgba(255,255,255,.15);
        }

        .btn-ghost:hover {
            background: rgba(255,255,255,.08);
            color: white;
            border-color: rgba(255,255,255,.3);
        }

        .btn-primary {
            background: var(--teal);
            color: white;
        }

        .btn-primary:hover {
            background: var(--teal-l);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(234,88,12,.35);
        }

        .btn-outline-white {
            background: transparent;
            color: white;
            border: 1.5px solid rgba(255,255,255,.4);
        }

        .btn-outline-white:hover {
            background: rgba(255,255,255,.1);
            border-color: white;
        }

        .btn-lg {
            padding: 14px 32px;
            font-size: 15px;
            border-radius: 10px;
        }

        /* ── HERO BODY ── */
        .hero-body {
            position: relative;
            z-index: 5;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 24px 130px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(234,88,12,.15);
            border: 1px solid rgba(234,88,12,.3);
            color: var(--teal-l);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 28px;
            animation: fadeDown .6s ease both;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            background: var(--teal-l);
            border-radius: 50%;
            animation: pulse 2s infinite;
            flex-shrink: 0;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .5; transform: scale(.7); }
        }

        .hero-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(32px, 6vw, 72px);
            line-height: 1.1;
            color: white;
            max-width: 780px;
            margin-bottom: 24px;
            animation: fadeDown .6s .1s ease both;
        }

        .hero-title em {
            font-style: italic;
            color: var(--teal-l);
        }

        .hero-desc {
            font-size: clamp(15px, 2vw, 17px);
            line-height: 1.7;
            color: rgba(255,255,255,.6);
            max-width: 540px;
            margin-bottom: 40px;
            animation: fadeDown .6s .2s ease both;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeDown .6s .3s ease both;
        }

        /* ── STATS STRIP ── */
        .stats-strip {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: center;
            gap: 0;
            border-top: 1px solid rgba(255,255,255,.07);
            animation: fadeDown .6s .4s ease both;
            flex-wrap: wrap;
        }

        .stat-item {
            flex: 1;
            min-width: 120px;
            max-width: 200px;
            text-align: center;
            padding: 20px 16px;
            border-right: 1px solid rgba(255,255,255,.07);
        }

        .stat-item:last-child { border-right: none; }

        .stat-num {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(20px, 3vw, 28px);
            color: white;
            display: block;
        }

        .stat-lbl {
            font-size: 11px;
            color: var(--muted);
            letter-spacing: .3px;
        }

        /* ── LAYANAN ── */
        .section {
            padding: 80px 24px;
            max-width: 1180px;
            margin: 0 auto;
        }

        .section-eyebrow {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--teal);
            margin-bottom: 12px;
        }

        .section-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(26px, 4vw, 46px);
            color: var(--navy);
            line-height: 1.15;
            max-width: 480px;
            margin-bottom: 16px;
        }

        .section-desc {
            font-size: 16px;
            color: #5A6B80;
            line-height: 1.7;
            max-width: 480px;
            margin-bottom: 48px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(min(100%, 280px), 1fr));
            gap: 16px;
        }

        .service-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 28px 24px;
            transition: all .25s;
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--teal);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .3s;
        }

        .service-card:hover {
            border-color: var(--teal-l);
            box-shadow: 0 16px 48px rgba(234,88,12,.12);
            transform: translateY(-4px);
        }

        .service-card:hover::before { transform: scaleX(1); }

        .service-icon {
            width: 48px;
            height: 48px;
            background: rgba(234,88,12,.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 22px;
        }

        .service-name {
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
            color: var(--navy);
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .service-desc {
            font-size: 14px;
            color: #5A6B80;
            line-height: 1.65;
        }

        /* ── PROSES ── */
        .process-section {
            background: var(--navy);
            padding: 80px 24px;
            position: relative;
            overflow: hidden;
        }

        .process-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(234,88,12,.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(234,88,12,.05) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .process-inner {
            position: relative;
            z-index: 2;
            max-width: 1180px;
            margin: 0 auto;
        }

        .process-section .section-title { color: white; }
        .process-section .section-desc { color: rgba(255,255,255,.5); }
        .process-section .section-eyebrow { color: var(--teal-l); }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(min(100%, 220px), 1fr));
            gap: 4px;
        }

        .step {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 16px;
            padding: 32px 24px;
            position: relative;
            transition: background .2s;
        }

        .step:hover { background: rgba(255,255,255,.07); }

        .step-num {
            font-family: 'DM Serif Display', serif;
            font-size: 44px;
            color: rgba(234,88,12,.25);
            line-height: 1;
            margin-bottom: 16px;
        }

        .step-title {
            font-size: 15px;
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
        }

        .step-desc {
            font-size: 13px;
            color: rgba(255,255,255,.45);
            line-height: 1.65;
        }

        /* ── CTA ── */
        .cta-section {
            padding: 80px 24px;
            max-width: 1180px;
            margin: 0 auto;
            text-align: center;
        }

        .cta-box {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-2) 100%);
            border-radius: 24px;
            padding: 60px 32px;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(234,88,12,.25) 0%, transparent 70%);
        }

        .cta-box::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 240px;
            height: 240px;
            background: radial-gradient(circle, rgba(245,158,11,.1) 0%, transparent 70%);
        }

        .cta-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(26px, 4vw, 44px);
            color: white;
            margin-bottom: 16px;
            position: relative;
            z-index: 2;
        }

        .cta-desc {
            font-size: 16px;
            color: rgba(255,255,255,.55);
            margin-bottom: 36px;
            position: relative;
            z-index: 2;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.65;
        }

        .cta-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        /* ── FOOTER ── */
        footer {
            background: var(--navy-2);
            padding: 32px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-copy {
            font-size: 13px;
            color: rgba(255,255,255,.35);
        }

        .footer-links {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .footer-links a {
            font-size: 13px;
            color: rgba(255,255,255,.35);
            text-decoration: none;
            transition: color .2s;
        }

        .footer-links a:hover { color: var(--teal-l); }

        /* ── ANIMATIONS ── */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─────────────────────────────────────────
           RESPONSIVE BREAKPOINTS
        ───────────────────────────────────────── */

        /* Large Tablets & smaller desktops */
        @media (max-width: 1024px) {
            nav { padding: 20px 32px; }
            .section { padding: 72px 32px; }
            .process-section { padding: 72px 32px; }
            .cta-section { padding: 72px 32px; }
            footer { padding: 32px 32px; }
        }

        /* Tablets */
        @media (max-width: 768px) {
            nav { padding: 16px 20px; }

            /* Show hamburger, hide nav links */
            .nav-toggle { display: flex; }
            .nav-links { display: none; }

            .hero-body {
                padding: 48px 20px 120px;
            }

            .hero-actions .btn-lg {
                padding: 13px 22px;
                font-size: 14px;
            }

            .stats-strip {
                display: grid;
                grid-template-columns: 1fr 1fr;
            }

            .stat-item {
                max-width: 100%;
                border-right: 1px solid rgba(255,255,255,.07);
                border-bottom: 1px solid rgba(255,255,255,.07);
            }

            .stat-item:nth-child(2) { border-right: none; }
            .stat-item:nth-child(3) { border-bottom: none; }
            .stat-item:nth-child(4) { border-right: none; border-bottom: none; }

            .section { padding: 60px 20px; }
            .process-section { padding: 60px 20px; }
            .cta-section { padding: 60px 20px; }

            .cta-box { padding: 48px 24px; }

            footer {
                flex-direction: column;
                text-align: center;
                padding: 28px 20px;
                gap: 12px;
            }

            .footer-links {
                justify-content: center;
            }
        }

        /* Mobile */
        @media (max-width: 480px) {
            nav { padding: 14px 16px; }

            .nav-logo { width: 36px; height: 36px; font-size: 11px; }
            .nav-title { font-size: 11px; }
            .nav-sub { font-size: 10px; }

            .hero-body {
                padding: 40px 16px 110px;
            }

            .badge {
                font-size: 10px;
                padding: 5px 12px;
                margin-bottom: 20px;
            }

            .hero-title { font-size: clamp(28px, 8vw, 40px); }

            .hero-actions {
                flex-direction: column;
                width: 100%;
                gap: 10px;
            }

            .hero-actions .btn-lg {
                width: 100%;
                justify-content: center;
                padding: 15px 20px;
                font-size: 15px;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .cta-box { 
                padding: 40px 20px;
                border-radius: 16px;
            }

            .cta-actions {
                flex-direction: column;
            }

            .cta-actions .btn-lg {
                width: 100%;
                justify-content: center;
            }

            footer { padding: 24px 16px; }

            .section-title { max-width: 100%; }
            .section-desc { max-width: 100%; margin-bottom: 36px; }
        }

        /* Very small screens */
        @media (max-width: 360px) {
            .hero-title { font-size: 26px; }
            .hero-desc { font-size: 14px; }
        }
    </style>
</head>
<body>

{{-- ──────────────────── HERO ──────────────────── --}}
<section class="hero">
    <nav>
        <a href="/" class="nav-brand">
            <div class="nav-logo">PUTP</div>
            <div class="nav-name">
                <span class="nav-title">Politeknik ATMI</span>
                <span class="nav-sub">Surakarta</span>
            </div>
        </a>

        <div class="nav-links">
            <a href="https://wa.me/6285802543185?text=Halo%20PUTP%2C%20saya%20ingin%20bertanya%20mengenai%20layanan%20pengujian%20material" target="_blank" class="btn btn-primary">
                Hubungi via WhatsApp
            </a>
        </div>

        <!-- Hamburger button (mobile only) -->
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="https://wa.me/6285802543185?text=Halo%20PUTP%2C%20saya%20ingin%20bertanya%20mengenai%20layanan%20pengujian%20material" target="_blank" class="btn btn-primary btn-lg" onclick="closeMobileMenu()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Hubungi via WhatsApp
        </a>
        <a href="tel:+62271714466" class="btn btn-outline-white btn-lg" onclick="closeMobileMenu()">📞 +62 271-714466</a>
        <a href="/cdn-cgi/l/email-protection" class="btn btn-ghost btn-lg" onclick="closeMobileMenu()">✉️ Email Kami</a>
    </div>

    <div class="hero-body">
        <div class="badge">
            <span class="badge-dot"></span>
            Sistem Pelayanan Resmi PUTP
        </div>

        <h1 class="hero-title">
            Pengujian Material Plastik<br>
            yang <em>Akurat & Terpercaya</em>
        </h1>

        <p class="hero-desc">
            Pusat Unggulan Teknologi Plastik Politeknik ATMI Surakarta menyediakan
            layanan pengujian spesimen, analisis produk, dan pengembangan material
            untuk kebutuhan industri dan riset.
        </p>

        <div class="hero-actions">
            <a href="https://wa.me/6281234567890?text=Halo%20PUTP%2C%20saya%20ingin%20mengajukan%20permohonan%20pengujian%20material%20plastik" target="_blank" class="btn btn-primary btn-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Ajukan Pengujian via WA
            </a>
            <a href="tel:+62271714466" class="btn btn-outline-white btn-lg">📞 +62 271-714466</a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-item">
            <span class="stat-num">10+</span>
            <span class="stat-lbl">Jenis Pengujian</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">ISO</span>
            <span class="stat-lbl">Standar Internasional</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">7 Hari</span>
            <span class="stat-lbl">Rata-rata Penyelesaian</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">Industri</span>
            <span class="stat-lbl">& Riset Akademik</span>
        </div>
    </div>
</section>

{{-- ──────────────────── LAYANAN ──────────────────── --}}
<div class="section">
    <p class="section-eyebrow">Layanan Kami</p>
    <h2 class="section-title">Apa yang Bisa Kami Uji untuk Anda?</h2>
    <p class="section-desc">Didukung peralatan modern dan tenaga ahli berpengalaman, kami siap membantu kebutuhan teknis Anda.</p>

    <div class="services-grid">
        <div class="service-card">
            <div class="service-icon">🧪</div>
            <h3 class="service-name">Pengujian Spesimen Material</h3>
            <p class="service-desc">Uji tarik, lentur, impak, dan kekerasan material plastik sesuai standar ASTM dan ISO.</p>
        </div>
        <div class="service-card">
            <div class="service-icon">📐</div>
            <h3 class="service-name">Product Development</h3>
            <p class="service-desc">Pendampingan pengembangan produk plastik dari desain hingga prototipe siap produksi.</p>
        </div>
        <div class="service-card">
            <div class="service-icon">✂️</div>
            <h3 class="service-name">Laser Cutting</h3>
            <p class="service-desc">Pemotongan presisi berbagai jenis material plastik dengan teknologi laser cutting modern.</p>
        </div>
        <div class="service-card">
            <div class="service-icon">📊</div>
            <h3 class="service-name">Product Analysis</h3>
            <p class="service-desc">Analisis mendalam terhadap kualitas, cacat, dan performa produk plastik Anda.</p>
        </div>
        <div class="service-card">
            <div class="service-icon">🔄</div>
            <h3 class="service-name">Re-drawing Komponen</h3>
            <p class="service-desc">Rekonstruksi gambar teknik komponen plastik untuk keperluan reproduksi atau reverse engineering.</p>
        </div>
        <div class="service-card">
            <div class="service-icon">🎓</div>
            <h3 class="service-name">Konsultasi & Pelatihan</h3>
            <p class="service-desc">Konsultasi teknis dan pelatihan teknologi plastik untuk civitas akademika maupun praktisi industri.</p>
        </div>
    </div>
</div>

{{-- ──────────────────── PROSES ──────────────────── --}}
<div class="process-section">
    <div class="process-inner">
        <p class="section-eyebrow">Cara Kerja</p>
        <h2 class="section-title">Proses Sederhana, Hasil Akurat</h2>
        <p class="section-desc">Kami merancang alur pelayanan yang efisien agar Anda bisa fokus pada riset dan produksi.</p>

        <div class="steps">
            <div class="step">
                <div class="step-num">01</div>
                <h3 class="step-title">Buat Akun & Login</h3>
                <p class="step-desc">Daftarkan diri Anda secara gratis. Cukup email dan password untuk memulai.</p>
            </div>
            <div class="step">
                <div class="step-num">02</div>
                <h3 class="step-title">Ajukan Permohonan</h3>
                <p class="step-desc">Isi formulir permohonan tes, pilih jenis layanan, dan unggah detail spesimen.</p>
            </div>
            <div class="step">
                <div class="step-num">03</div>
                <h3 class="step-title">Konfirmasi & Pengiriman</h3>
                <p class="step-desc">Tim kami meninjau permohonan, memberikan estimasi biaya dan jadwal pengujian.</p>
            </div>
            <div class="step">
                <div class="step-num">04</div>
                <h3 class="step-title">Terima Laporan</h3>
                <p class="step-desc">Unduh laporan hasil pengujian lengkap dengan data, grafik, dan interpretasi teknis.</p>
            </div>
        </div>
    </div>
</div>

{{-- ──────────────────── CTA ──────────────────── --}}
<div class="cta-section">
    <div class="cta-box">
        <h2 class="cta-title">Siap Mulai Pengujian?</h2>
        <p class="cta-desc">
            Hubungi tim kami atau langsung buat akun dan ajukan permohonan tes material Anda hari ini.
        </p>
        <div class="cta-actions">
            <a href="https://wa.me/6281234567890?text=Halo%20PUTP%2C%20saya%20ingin%20mengajukan%20permohonan%20pengujian%20material%20plastik" target="_blank" class="btn btn-primary btn-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat WhatsApp Sekarang
            </a>
            <a href="/cdn-cgi/l/email-protection#d8a8b7b4b1acbdb3b6b1b398b9acb5b1f6b9bbf6b1bc" class="btn btn-outline-white btn-lg">✉️ Email Kami</a>
        </div>
    </div>
</div>

{{-- ──────────────────── FOOTER ──────────────────── --}}
<footer>
    <span class="footer-copy">
        &copy; {{ date('Y') }} Pusat Unggulan Teknologi Plastik — Politeknik ATMI Surakarta
    </span>
    <div class="footer-links">
        <a href="https://www.atmi.ac.id" target="_blank">atmi.ac.id</a>
        <a href="/cdn-cgi/l/email-protection#e4948b888d90818f8a8d8fa48590898dca8587ca8d80">Kontak</a>
    </div>
</footer>

<script>
    const toggle = document.getElementById('navToggle');
    const menu = document.getElementById('mobileMenu');

    toggle.addEventListener('click', () => {
        toggle.classList.toggle('active');
        menu.classList.toggle('open');
        document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
    });

    function closeMobileMenu() {
        toggle.classList.remove('active');
        menu.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Close menu on resize to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeMobileMenu();
    });
</script>

</body>
</html>