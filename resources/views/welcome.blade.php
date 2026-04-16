<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PUTP — Sistem Pelayanan Tes Material</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('logopoltek.png') }}">
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
            overflow: visible;
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
            display: none;
        }

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

        .stats-strip::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--cream);
            clip-path: ellipse(55% 100% at 50% 0%);
            z-index: 10;
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
        /* ── LAYANAN SECTION START ── */
            /* ── SECTION ── */
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
            
            /* ── CAT TABS ── */
            .cat-tabs { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px; }
            .cat-tab {
                padding: 9px 20px;
                border-radius: 999px;
                border: 1px solid #E2E8F0;
                font-size: 13px;
                font-weight: 500;
                cursor: pointer;
                background: white;
                color: #5A6B80;
                transition: all .2s;
            }
            .cat-tab.active { color: white; border-color: transparent; }

            /* ── SPLIT PANEL LAYOUT ── */
            .layanan-split {
                display: grid;
                grid-template-columns: 340px 1fr;
                gap: 24px;
                align-items: start;
            }

            /* LEFT PANEL — daftar package */
            .pkg-list-panel {
                display: flex;
                flex-direction: column;
                gap: 10px;
                position: sticky;
                top: 24px;
                max-height: calc(100vh - 80px);
                overflow-y: auto;
                scrollbar-width: thin;
                scrollbar-color: #E2E8F0 transparent;
                padding-right: 4px;
            }

            .pkg-list-item {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                padding: 16px 18px;
                background: white;
                border: 1.5px solid #E8EDF2;
                border-radius: 14px;
                cursor: pointer;
                transition: all .22s cubic-bezier(.34,1.2,.64,1);
            }

            .pkg-list-item:hover {
                border-color: var(--active-accent, #EA580C);
                box-shadow: 0 6px 20px rgba(0,0,0,.07);
                transform: translateX(3px);
            }

            .pkg-list-item.active {
                border-color: var(--active-accent, #EA580C);
                background: var(--active-bg, rgba(234,88,12,.04));
                box-shadow: 0 8px 28px rgba(0,0,0,.09);
            }

            .pkg-list-thumb {
                width: 52px;
                height: 52px;
                border-radius: 10px;
                overflow: hidden;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                background: #F1F5F9;
            }

            .pkg-list-thumb img { width: 100%; height: 100%; object-fit: cover; }

            .pkg-list-info { flex: 1; min-width: 0; }

            .pkg-list-num {
                font-size: 10px;
                font-weight: 700;
                letter-spacing: 1.5px;
                color: #94A3B8;
                text-transform: uppercase;
                margin-bottom: 2px;
            }

            .pkg-list-name {
                font-family: 'DM Serif Display', serif;
                font-size: 15px;
                color: var(--navy);
                line-height: 1.3;
                margin-bottom: 4px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .pkg-list-price {
                font-size: 13px;
                font-weight: 600;
                color: var(--active-accent, #EA580C);
            }

            .pkg-list-arrow {
                color: #CBD5E1;
                flex-shrink: 0;
                margin-top: 2px;
                transition: color .2s, transform .2s;
            }

            .pkg-list-item.active .pkg-list-arrow,
            .pkg-list-item:hover .pkg-list-arrow {
                color: var(--active-accent, #EA580C);
                transform: translateX(3px);
            }

            /* RIGHT PANEL — detail package */
            .pkg-detail-panel {
                background: white;
                border: 1.5px solid #E8EDF2;
                border-radius: 20px;
                overflow: hidden;
                animation: panelIn .3s cubic-bezier(.34,1.2,.64,1) both;
            }

            @keyframes panelIn {
                from { opacity: 0; transform: translateX(12px); }
                to   { opacity: 1; transform: translateX(0); }
            }

            .pkg-detail-img {
                width: 100%;
                height: 240px;
                position: relative;
                overflow: hidden;
                background: #F1F5F9;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 72px;
            }

            .pkg-detail-img img { width: 100%; height: 100%; object-fit: cover; }

            .pkg-detail-badge {
                position: absolute;
                top: 14px;
                left: 14px;
                color: white;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 1px;
                padding: 5px 12px;
                border-radius: 8px;
                text-transform: uppercase;
            }

            .pkg-detail-avail {
                position: absolute;
                top: 14px;
                right: 14px;
                font-size: 11px;
                font-weight: 600;
                padding: 5px 12px;
                border-radius: 8px;
            }
            .pkg-detail-avail.avail { background: #D1FAE5; color: #065F46; }
            .pkg-detail-avail.busy  { background: #FEE2E2; color: #991B1B; }

            .pkg-detail-body { padding: 24px 26px; }

            .pkg-detail-eyebrow {
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 1.5px;
                color: #94A3B8;
                text-transform: uppercase;
                margin-bottom: 6px;
            }

            .pkg-detail-title {
                font-family: 'DM Serif Display', serif;
                font-size: 26px;
                color: var(--navy);
                line-height: 1.2;
                margin-bottom: 12px;
            }

            .pkg-detail-desc {
                font-size: 14px;
                color: #5A6B80;
                line-height: 1.7;
                margin-bottom: 22px;
            }

            .pkg-detail-section { margin-bottom: 22px; }

            .pkg-detail-section-label {
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                color: #94A3B8;
                margin-bottom: 12px;
            }

            .pkg-detail-tags { display: flex; flex-wrap: wrap; gap: 8px; }

            .pkg-detail-tag {
                font-size: 12px;
                font-weight: 500;
                padding: 5px 12px;
                border-radius: 8px;
                border: 1px solid #E2E8F0;
                color: #5A6B80;
                background: #F8FAFC;
            }

            .pkg-detail-specs { width: 100%; font-size: 13px; border-collapse: collapse; }
            .pkg-detail-specs td { padding: 9px 0; border-bottom: 1px solid #F1F5F9; }
            .pkg-detail-specs td:first-child { color: #94A3B8; width: 42%; }
            .pkg-detail-specs td:last-child { color: var(--navy); font-weight: 500; text-align: right; }

            .pkg-detail-price-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: var(--price-bg, rgba(234,88,12,.07));
                border-radius: 14px;
                padding: 18px 20px;
                margin-bottom: 16px;
            }

            .pkg-detail-price-label { font-size: 12px; color: #94A3B8; margin-bottom: 2px; }
            .pkg-detail-price-value { font-size: 24px; font-weight: 700; color: var(--price-accent, #EA580C); }
            .pkg-detail-price-unit  { font-size: 12px; color: #94A3B8; }

            .pkg-detail-cart-btn {
                width: 100%;
                padding: 13px;
                border-radius: 12px;
                border: none;
                font-size: 14px;
                font-weight: 700;
                font-family: 'DM Sans', sans-serif;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: all .2s;
                background: var(--price-accent, #EA580C);
                color: white;
            }

            .pkg-detail-cart-btn:hover { opacity: .88; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(0,0,0,.15); }
            .pkg-detail-cart-btn.in-cart { background: #16A34A; }

            /* Empty state */
            .pkg-detail-empty {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 14px;
                padding: 60px 24px;
                color: #94A3B8;
                font-size: 14px;
                text-align: center;
            }

            .pkg-detail-empty svg { opacity: .35; }

            /* ── RESPONSIVE split panel ── */
            @media (max-width: 900px) {
                .layanan-split {
                    grid-template-columns: 1fr;
                }
                .pkg-list-panel {
                    position: static;
                    max-height: none;
                    overflow: visible;
                    flex-direction: row;
                    overflow-x: auto;
                    gap: 10px;
                    padding-bottom: 6px;
                    padding-right: 0;
                    scrollbar-width: thin;
                }
                .pkg-list-item {
                    min-width: 220px;
                    flex-direction: column;
                    gap: 8px;
                }
                .pkg-list-item:hover { transform: translateY(-2px) translateX(0); }
                .pkg-list-arrow { display: none; }
            }
            

            
            /* ── CALENDAR ── */
            .cal-wrap { background: #F8FAFC; border-radius: 12px; padding: 16px; }
            .cal-nav { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
            .cal-title { font-size: 14px; font-weight: 600; color: var(--navy); }
            .cal-btn {
                width: 28px; height: 28px; border-radius: 8px;
                border: 1px solid #E2E8F0; background: white;
                cursor: pointer; display: flex; align-items: center;
                justify-content: center; color: #5A6B80; font-size: 13px; transition: all .2s;
            }
            .cal-btn:hover { border-color: #EA580C; color: #EA580C; }
            .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
            .cal-day-name { font-size: 11px; font-weight: 600; color: #94A3B8; text-align: center; padding: 4px 0; }
            .cal-day {
                aspect-ratio: 1; border-radius: 8px; display: flex;
                align-items: center; justify-content: center;
                font-size: 12px; font-weight: 500; cursor: pointer;
                transition: all .15s; border: 1px solid transparent; color: var(--navy);
            }
            .cal-day.empty    { cursor: default; }
            .cal-day.available { background: #ECFDF5; color: #065F46; }
            .cal-day.available:hover { background: #D1FAE5; }
            .cal-day.busy     { background: #FEF2F2; color: #991B1B; cursor: not-allowed; }
            .cal-day.past     { color: #CBD5E1; background: transparent; cursor: default; }
            .cal-day.today    { border-color: #EA580C; font-weight: 700; }
            .cal-day.selected { background: #EA580C !important; color: white !important; }
            .cal-legend { display: flex; gap: 12px; margin-top: 12px; flex-wrap: wrap; }
            .cal-legend-item { display: flex; align-items: center; gap: 6px; font-size: 11px; color: #5A6B80; }
            .cal-legend-dot { width: 10px; height: 10px; border-radius: 3px; }
            
            /* ── PRICE BOX ── */
            .modal-price-box { border-radius: 12px; padding: 16px; display: flex; align-items: center; justify-content: space-between; margin-top: 4px; }
            .modal-price-label { font-size: 12px; margin-bottom: 2px; opacity: .7; }
            .modal-price-value { font-size: 22px; font-weight: 700; }
            .modal-price-duration { font-size: 13px; opacity: .7; }
            .modal-footer { padding: 16px 24px; border-top: 1px solid #F1F5F9; display: flex; gap: 10px; }
            .mf-btn-cancel {
                flex: 1; padding: 12px; border-radius: 10px;
                border: 1px solid #E2E8F0; background: transparent;
                color: #5A6B80; font-size: 14px; cursor: pointer; transition: all .2s;
            }
            .mf-btn-cancel:hover { background: #F8FAFC; }
            .mf-btn-book {
                flex: 2; padding: 12px; border-radius: 10px;
                border: none; background: #EA580C; color: white;
                font-size: 14px; font-weight: 600; cursor: pointer; transition: all .2s;
            }
            .mf-btn-book:hover { opacity: .9; }
            .mf-btn-book.sky { background: #0EA5E9; }
            .mf-btn-book.grn { background: #10B981; }

        /* ── LAYANAN SECTION END ── */

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

        /* ── PROCESS SECTION ── */
        .process-section {
            padding: 80px 24px;
            background: var(--navy);
            position: relative;
            overflow: hidden;
        }

        .process-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(234,88,12,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(234,88,12,.06) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .process-inner {
            position: relative;
            z-index: 2;
            max-width: 1180px;
            margin: 0 auto;
        }

        .process-section .section-eyebrow { color: var(--teal-l); }
        .process-section .section-title   { color: white; }
        .process-section .section-desc    { color: rgba(255,255,255,.5); }

        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 8px;
        }

        .step {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            padding: 28px 24px;
            position: relative;
            transition: all .25s;
        }

        .step:hover {
            background: rgba(255,255,255,.07);
            border-color: rgba(234,88,12,.35);
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(0,0,0,.3);
        }

        .step-num {
            font-family: 'DM Serif Display', serif;
            font-size: 36px;
            color: var(--teal);
            opacity: .5;
            line-height: 1;
            margin-bottom: 16px;
        }

        .step-title {
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
            color: white;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .step-desc {
            font-size: 13px;
            color: rgba(255,255,255,.5);
            line-height: 1.7;
        }

        /* ── PROCESS RESPONSIVE ── */
        @media (max-width: 1024px) {
            .steps { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 480px) {
            .steps { grid-template-columns: 1fr; }
            .process-section { padding: 60px 20px; }
        }

        .carousel-wrap {
            overflow: hidden;
            padding-top: 4px; /* prevents box-shadow/border clip on hover */
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

        /* ══════════════════════════════════════
        SERVICE CARD NEW
        ══════════════════════════════════════ */
        .service-card-new {
            background: white;
            border: 1.5px solid #E8EDF2;
            border-radius: 20px;
            padding: 28px 26px;
            cursor: pointer;
            transition: all .28s cubic-bezier(.34,1.56,.64,1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .service-card-new::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            opacity: 0;
            transition: opacity .3s;
            background: radial-gradient(circle at 80% 20%, var(--card-bg), transparent 70%);
            pointer-events: none;
        }

        .service-card-new:hover {
            border-color: var(--card-accent);
            transform: translateY(-6px);
            box-shadow: 0 20px 60px -10px color-mix(in srgb, var(--card-accent) 25%, transparent);
        }

        .service-card-new:hover::after { opacity: 1; }

        .scn-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .scn-icon {
            width: 52px;
            height: 52px;
            background: var(--card-bg);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            border: 1.5px solid color-mix(in srgb, var(--card-accent) 20%, transparent);
        }

        .scn-badge {
            font-size: 11px;
            font-weight: 600;
            color: var(--card-accent);
            background: var(--card-bg);
            padding: 4px 10px;
            border-radius: 100px;
            border: 1px solid color-mix(in srgb, var(--card-accent) 20%, transparent);
            letter-spacing: .3px;
        }

        .scn-title {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--navy);
            line-height: 1.2;
        }

        .scn-desc {
            font-size: 14px;
            color: #64748B;
            line-height: 1.65;
            flex: 1;
        }

        .scn-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .scn-tag {
            font-size: 11px;
            font-weight: 500;
            color: #475569;
            background: #F1F5F9;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #E2E8F0;
        }

        .scn-tag-more {
            color: var(--card-accent);
            background: var(--card-bg);
            border-color: color-mix(in srgb, var(--card-accent) 20%, transparent);
        }

        .scn-cta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--card-accent);
            padding-top: 6px;
            border-top: 1px solid #F1F5F9;
            transition: gap .2s;
        }

        .service-card-new:hover .scn-cta { gap: 12px; }

        /* ══════════════════════════════════════
        MODAL
        ══════════════════════════════════════ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 6, 0, .65);
            backdrop-filter: blur(6px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal-box {
            background: white;
            border-radius: 24px;
            width: 100%;
            max-width: 640px;
            max-height: 88vh;
            display: flex;
            flex-direction: column;
            position: relative;
            transform: translateY(24px) scale(.97);
            transition: transform .3s cubic-bezier(.34,1.4,.64,1);
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0,0,0,.25);
        }

        .modal-overlay.open .modal-box {
            transform: translateY(0) scale(1);
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #F1F5F9;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748B;
            transition: all .2s;
            z-index: 10;
        }

        .modal-close:hover { background: #E2E8F0; color: var(--navy); }

        .modal-header {
            padding: 28px 28px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid #F1F5F9;
            background: #FAFBFC;
        }

        .modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
        }

        .modal-eyebrow {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #94A3B8;
            margin-bottom: 4px;
        }

        .modal-title {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--navy);
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .modal-subtitle {
            font-size: 13px;
            color: #64748B;
            line-height: 1.5;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 28px;
            scrollbar-width: thin;
            scrollbar-color: #E2E8F0 transparent;
        }

        .modal-section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #94A3B8;
            margin-bottom: 14px;
        }

        .modal-packages {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .modal-pkg-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 18px;
            background: #F8FAFC;
            border: 1.5px solid #E8EDF2;
            border-radius: 14px;
            transition: all .2s;
        }

        .modal-pkg-item:hover {
            background: white;
            border-color: var(--modal-accent, #EA580C);
            box-shadow: 0 4px 16px rgba(0,0,0,.06);
        }

        .modal-pkg-left {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            flex: 1;
            min-width: 0;
        }

        .modal-pkg-num {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: var(--modal-bg, rgba(234,88,12,.08));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--modal-accent, #EA580C);
            flex-shrink: 0;
            margin-top: 1px;
        }

        .modal-pkg-info { flex: 1; min-width: 0; }

        .modal-pkg-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
            line-height: 1.4;
            margin-bottom: 3px;
        }

        .modal-pkg-desc {
            font-size: 12px;
            color: #94A3B8;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .modal-pkg-price {
            font-size: 13px;
            font-weight: 700;
            color: var(--modal-accent, #EA580C);
            white-space: nowrap;
            background: var(--modal-bg, rgba(234,88,12,.08));
            padding: 4px 10px;
            border-radius: 8px;
            flex-shrink: 0;
            align-self: flex-start;
            margin-top: 2px;
        }

        .modal-pkg-btn {
            border: none;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            transition: transform .15s, background .15s, color .15s, border-color .15s;
            align-self: flex-start;
            margin-top: 2px;
        }

        .modal-pkg-btn.btn-add {
            background: var(--modal-accent, #EA580C);
            color: white;
        }

        .modal-pkg-btn.btn-add:hover { transform: translateY(-1px); }

        .modal-pkg-btn.btn-remove {
            background: #F0FDF4;
            color: #16A34A;
            border: 1.5px solid #86EFAC;
        }

        .modal-pkg-btn.btn-remove:hover {
            background: #FEF2F2;
            color: #EF4444;
            border-color: #FECACA;
        }

        .modal-footer {
            padding: 16px 28px 24px;
            display: flex;
            gap: 10px;
            border-top: 1px solid #F1F5F9;
            flex-wrap: wrap;
        }

        .btn-ghost-dark {
            background: #F1F5F9;
            color: #475569;
            border: 1px solid #E2E8F0;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-ghost-dark:hover { background: #E2E8F0; color: var(--navy); }

        /* Modal responsive */
        @media (max-width: 480px) {
            .modal-box { border-radius: 20px; max-height: 92vh; }
            .modal-header { padding: 22px 20px 16px; flex-direction: column; align-items: flex-start; }
            .modal-body { padding: 16px 20px; }
            .modal-footer { padding: 14px 20px 20px; }
            .modal-pkg-item { flex-direction: column; gap: 10px; }
            .modal-pkg-price { align-self: flex-start; }
        }

        /* ── CART ADDITIONS ── */
        .scn-actions {
            display: flex;
            gap: 8px;
            padding-top: 6px;
            border-top: 1px solid #F1F5F9;
        }
        
        .btn-add-cart {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 14px;
            background: var(--card-bg);
            border: 1.5px solid color-mix(in srgb, var(--card-accent) 25%, transparent);
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            color: var(--card-accent);
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all .2s;
            white-space: nowrap;
        }
        
        .btn-add-cart:hover {
            background: var(--card-accent);
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-add-cart.in-cart {
            background: #F0FDF4;
            border-color: #86EFAC;
            color: #16A34A;
        }
        
        .btn-view-detail {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 14px;
            background: transparent;
            border: 1.5px solid var(--border, #E2E8F0);
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            color: #64748B;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: all .2s;
            white-space: nowrap;
        }
        
        .btn-view-detail:hover {
            background: #F1F5F9;
            color: var(--navy);
        }
        
        /* ── FLOATING CART ── */
        .floating-cart {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 500;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }
        
        .floating-cart-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 100px;
            padding: 14px 22px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            box-shadow: 0 8px 32px rgba(26,15,0,.35);
            transition: all .25s;
            text-decoration: none;
        }
        
        .floating-cart-btn:hover {
            background: var(--teal);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(234,88,12,.4);
        }
        
        .fct-count {
            background: var(--teal);
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s;
        }
        
        .floating-cart-btn:hover .fct-count {
            background: white;
            color: var(--teal);
        }

        /* Floating Status Order — selalu terlihat, di dalam wrapper */
        .floating-status-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: var(--navy);
            border: none;
            border-radius: 999px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(15,23,42,.2);
            transition: all .2s;
            text-decoration: none;
        }

        .floating-status-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(15,23,42,.32);
            background: var(--cream);
        }
        
        .floating-cart-hint {
            background: white;
            border: 1.5px solid var(--border, #E2E8F0);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 13px;
            color: #475569;
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            white-space: nowrap;
            display: none;
            animation: fadeDown .3s ease both;
        }
        
        .floating-cart-hint.show { display: block; }
        
        @media (max-width: 480px) {
            .floating-cart { bottom: 20px; right: 16px; }
            .floating-cart-btn { padding: 13px 18px; font-size: 14px; }
            .floating-status-btn { padding: 10px 16px; font-size: 12px; }
            .scn-actions { flex-direction: column; }
        }
    </style>
</head>
<body>
<div class="floating-cart" id="floatingCartWrapper">
    <div class="floating-cart-hint" id="floatingHint"></div>
    <div id="floatingCart" style="display:none;">
        <a href="{{ route('orders.guest.cart') }}" class="floating-cart-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            Lanjut ke Keranjang
            <span class="fct-count" id="fctCount">0</span>
        </a>
    </div>
    <a href="{{ route('orders.guest.status.form') }}" class="floating-status-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l3 3"/></svg>
        Lihat Status Order
    </a>
</div>
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

{{-- ──────────────────── LAYANAN SECTION ──────────────────── --}}
<div class="section" id="layanan">
    <p class="section-eyebrow">Layanan Kami</p>
    <h2 class="section-title">Apa yang Bisa Kami Uji untuk Anda?</h2>
    <p class="section-desc">
        Didukung peralatan modern dan tenaga ahli berpengalaman,
        kami siap membantu kebutuhan teknis Anda.
    </p>

    @php
        $catIcons    = ['CAT-001' => '🧪', 'CAT-002' => '📐', 'CAT-003' => '⚙️'];
        $catAccents  = ['CAT-001' => '#EA580C', 'CAT-002' => '#0EA5E9', 'CAT-003' => '#10B981'];
        $catBtnClass = ['CAT-001' => '',        'CAT-002' => 'btn-sky',  'CAT-003' => 'btn-grn'];
    @endphp

    {{-- Tabs Kategori --}}
    <div class="cat-tabs" id="catTabs">
        @foreach ($categories as $category)
            <button
                class="cat-tab{{ $loop->first ? ' active' : '' }}"
                data-idx="{{ $loop->index }}"
                data-accent="{{ $catAccents[$category->category_id] ?? '#EA580C' }}"
                onclick="selectCat({{ $loop->index }})">
                {{ $catIcons[$category->category_id] ?? '🔬' }}
                {{ $category->nama_category }}
            </button>
        @endforeach
    </div>

    {{-- Split Panel --}}
    <div class="layanan-split">
        {{-- LEFT: daftar package --}}
        <div class="pkg-list-panel" id="pkgListPanel">
            {{-- diisi JS --}}
        </div>

        {{-- RIGHT: detail package --}}
        <div class="pkg-detail-panel" id="pkgDetailPanel">
            <div class="pkg-detail-empty">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="4"/>
                    <path d="M9 9h6M9 12h6M9 15h4"/>
                </svg>
                <span>Pilih paket di sebelah kiri untuk melihat detailnya</span>
            </div>
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
                <h3 class="step-title">Menghubungi Admin PUTP</h3>
                <p class="step-desc">Anda bisa langsung chat admin kami di WhatsApp untuk sekedar bertanya maupun pembuatan kode akses untuk membuat pesanan</p>
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


{{-- layanan kami --}}
<script>
    const categoryData = {!! $categoryJson !!};

    const catAccents   = { 'CAT-001': '#EA580C', 'CAT-002': '#0EA5E9', 'CAT-003': '#10B981' };
    const catBgMap     = {
        'CAT-001': 'rgba(234,88,12,.06)',
        'CAT-002': 'rgba(14,165,233,.06)',
        'CAT-003': 'rgba(16,185,129,.06)'
    };

    let activeCat     = 0;
    let activePkgIdx  = 0;
    let calYear       = new Date().getFullYear();
    let calMonth      = new Date().getMonth();
    let activePkgData = null;

    /* ── Tab kategori ── */
    function selectCat(idx) {
        activeCat    = idx;
        activePkgIdx = 0;

        const tabs = document.querySelectorAll('.cat-tab');
        tabs.forEach((t, i) => {
            t.classList.toggle('active', i === idx);
            const accent = t.dataset.accent;
            t.style.background = i === idx ? accent : '';
        });

        renderPkgList();
        const cat = categoryData[idx];
        if (cat && cat.packages && cat.packages.length > 0) {
            renderPkgDetail(idx, 0);
        } else {
            showEmptyDetail();
        }
    }

    /* ── Left panel: daftar package ── */
    function renderPkgList() {
        const cat    = categoryData[activeCat];
        const accent = catAccents[cat?.category_id] || '#EA580C';
        const bg     = catBgMap[cat?.category_id]   || 'rgba(234,88,12,.06)';
        const panel  = document.getElementById('pkgListPanel');

        if (!cat || !cat.packages || cat.packages.length === 0) {
            panel.innerHTML = '<p style="color:#94A3B8;font-size:13px;padding:12px;">Tidak ada paket tersedia.</p>';
            return;
        }

        panel.innerHTML = cat.packages.map((pkg, i) => {
            const price = Number(pkg.base_price).toLocaleString('id-ID');
            const num   = String(i + 1).padStart(2, '0');
            const thumb = pkg.image_url
                ? `<img src="${pkg.image_url}" alt="${pkg.name}">`
                : `<span>${pkg.icon || '🔬'}</span>`;

            return `
            <div class="pkg-list-item${i === activePkgIdx ? ' active' : ''}"
                 style="--active-accent:${accent};--active-bg:${bg};"
                 onclick="selectPkg(${i})">
                <div class="pkg-list-thumb">${thumb}</div>
                <div class="pkg-list-info">
                    <div class="pkg-list-num">Paket ${num}</div>
                    <div class="pkg-list-name" title="${pkg.name}">${pkg.name}</div>
                    <div class="pkg-list-price" style="color:${accent}">Rp ${price}</div>
                </div>
                <svg class="pkg-list-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
            </div>`;
        }).join('');
    }

    function selectPkg(pkgIdx) {
        activePkgIdx = pkgIdx;
        renderPkgList();
        renderPkgDetail(activeCat, pkgIdx);
    }

    /* ── Right panel: detail package ── */
    function renderPkgDetail(catIdx, pkgIdx) {
        const cat    = categoryData[catIdx];
        const pkg    = cat.packages[pkgIdx];
        if (!pkg) { showEmptyDetail(); return; }

        activePkgData = pkg;

        const accent = catAccents[cat.category_id] || '#EA580C';
        const bg     = catBgMap[cat.category_id]   || 'rgba(234,88,12,.06)';
        const num    = String(pkgIdx + 1).padStart(2, '0');
        const price  = Number(pkg.base_price).toLocaleString('id-ID');

        const imgContent = pkg.image_url
            ? `<img src="${pkg.image_url}" alt="${pkg.name}">`
            : `<span>${pkg.icon || '🔬'}</span>`;

        const busyCount = (pkg.busy_days || []).length;
        const availHtml = busyCount > 15
            ? `<span class="pkg-detail-avail busy">Jadwal Penuh</span>`
            : `<span class="pkg-detail-avail avail">Tersedia</span>`;

        const tagsHtml = (pkg.tests || []).length
            ? (pkg.tests).map(t => `<span class="pkg-detail-tag">${t}</span>`).join('')
            : '<span style="color:#94A3B8;font-size:13px;">—</span>';

        const specsHtml = (pkg.specs || []).length
            ? `<table class="pkg-detail-specs">${(pkg.specs).map(([k,v]) => `<tr><td>${k}</td><td>${v}</td></tr>`).join('')}</table>`
            : '<span style="color:#94A3B8;font-size:13px;">—</span>';

        const inCart = isInCart(pkg.id);

        document.getElementById('pkgDetailPanel').innerHTML = `
        <div class="pkg-detail-img">
            ${imgContent}
            <span class="pkg-detail-badge" style="background:${accent}">Paket ${num}</span>
            ${availHtml}
        </div>
        <div class="pkg-detail-body">
            <div class="pkg-detail-eyebrow">${cat.nama_category}</div>
            <div class="pkg-detail-title">${pkg.name}</div>
            <p class="pkg-detail-desc">${pkg.description || ''}</p>

            <div class="pkg-detail-section">
                <div class="pkg-detail-section-label">Pengujian yang tersedia</div>
                <div class="pkg-detail-tags">${tagsHtml}</div>
            </div>

            <div class="pkg-detail-section">
                <div class="pkg-detail-section-label">Detail teknis</div>
                ${specsHtml}
            </div>

            <div class="pkg-detail-section">
                <div class="pkg-detail-section-label">Ketersediaan jadwal</div>
                <div class="cal-wrap">
                    <div class="cal-nav">
                        <button class="cal-btn" onclick="calMove(-1)">&#8592;</button>
                        <div class="cal-title" id="calTitle"></div>
                        <button class="cal-btn" onclick="calMove(1)">&#8594;</button>
                    </div>
                    <div class="cal-grid" id="calGrid"></div>
                    <div class="cal-legend">
                        <div class="cal-legend-item">
                            <div class="cal-legend-dot" style="background:#ECFDF5;border:1px solid #A7F3D0;"></div>
                            Tersedia
                        </div>
                        <div class="cal-legend-item">
                            <div class="cal-legend-dot" style="background:#FEF2F2;border:1px solid #FCA5A5;"></div>
                            Penuh / Tidak tersedia
                        </div>
                    </div>
                </div>
            </div>

            <div class="pkg-detail-price-row" style="--price-bg:${bg};--price-accent:${accent};">
                <div>
                    <div class="pkg-detail-price-label">Harga mulai dari</div>
                    <div class="pkg-detail-price-value">Rp ${price}</div>
                </div>
                <div class="pkg-detail-price-unit">${pkg.price_unit || 'per paket'}</div>
            </div>

            <button class="pkg-detail-cart-btn${inCart ? ' in-cart' : ''}"
                    style="--price-accent:${accent};"
                    id="detailCartBtn"
                    onclick="toggleCartFromDetail(${catIdx}, ${pkgIdx})">
                ${inCart
                    ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Hapus dari Keranjang`
                    : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg> Tambah ke Keranjang`
                }
            </button>
        </div>`;

        calYear  = new Date().getFullYear();
        calMonth = new Date().getMonth();
        renderCalendar();
    }

    function showEmptyDetail() {
        document.getElementById('pkgDetailPanel').innerHTML = `
        <div class="pkg-detail-empty">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="3" width="18" height="18" rx="4"/>
                <path d="M9 9h6M9 12h6M9 15h4"/>
            </svg>
            <span>Pilih paket di sebelah kiri untuk melihat detailnya</span>
        </div>`;
    }

    /* ── CALENDAR ── */
    const MONTH_NAMES = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const DAY_NAMES   = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];

    function calMove(dir) {
        calMonth += dir;
        if (calMonth < 0)  { calMonth = 11; calYear--; }
        if (calMonth > 11) { calMonth = 0;  calYear++; }
        renderCalendar();
    }

    function renderCalendar() {
        const titleEl = document.getElementById('calTitle');
        const gridEl  = document.getElementById('calGrid');
        if (!titleEl || !gridEl) return;

        titleEl.textContent = `${MONTH_NAMES[calMonth]} ${calYear}`;

        const today       = new Date(); today.setHours(0,0,0,0);
        const firstDay    = new Date(calYear, calMonth, 1).getDay();
        const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
        const busyDays    = activePkgData ? (activePkgData.busy_days || []) : [];

        let html = DAY_NAMES.map(d => `<div class="cal-day-name">${d}</div>`).join('');
        for (let i = 0; i < firstDay; i++) html += `<div class="cal-day empty"></div>`;

        for (let d = 1; d <= daysInMonth; d++) {
            const date    = new Date(calYear, calMonth, d);
            const isPast  = date < today;
            const isBusy  = busyDays.includes(d);
            const isToday = date.getTime() === today.getTime();

            let cls = 'cal-day';
            if (isPast)      cls += ' past';
            else if (isBusy) cls += ' busy';
            else             cls += ' available';
            if (isToday)     cls += ' today';

            html += `<div class="${cls}">${d}</div>`;
        }

        gridEl.innerHTML = html;
    }

    /* ── Init ── */
    document.addEventListener('DOMContentLoaded', function () {
    init();
    });

    function init() {
        const cart = getCart();
        updateFloatingCart(cart.length);
        selectCat(0);
    }
</script>

{{-- cart --}}
<script>
    // ── CART LOGIC
    const CART_KEY = 'putp_cart';

    function getCart() {
        try { return JSON.parse(localStorage.getItem(CART_KEY) || '[]'); }
        catch { return []; }
    }

    function saveCart(cart) {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
    }

    function isInCart(packageId) {
        return getCart().some(c => c.package_id === packageId);
    }

    function addPackageToCart(pkg) {
        const cart = getCart();
        if (cart.some(c => c.package_id === pkg.id)) return cart;
        cart.push({ package_id: pkg.id, name: pkg.name, price: pkg.base_price, qty: 1 });
        saveCart(cart);
        return cart;
    }

    function removePackageFromCart(packageId) {
        const cart = getCart().filter(c => c.package_id !== packageId);
        saveCart(cart);
        return cart;
    }

    /* Toggle dari right panel detail */
    function toggleCartFromDetail(catIdx, pkgIdx) {
        const cat = categoryData[catIdx];
        const pkg = cat?.packages?.[pkgIdx];
        if (!pkg) return;

        let cart;
        if (isInCart(pkg.id)) {
            cart = removePackageFromCart(pkg.id);
            showWelcomeToast('Dihapus dari keranjang: ' + pkg.name);
        } else {
            cart = addPackageToCart(pkg);
            showWelcomeToast('Ditambahkan ke keranjang: ' + pkg.name);
        }

        updateFloatingCart(cart.length);

        // Re-render detail button
        const btn = document.getElementById('detailCartBtn');
        if (btn) {
            const nowInCart = isInCart(pkg.id);
            btn.classList.toggle('in-cart', nowInCart);
            btn.innerHTML = nowInCart
                ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Hapus dari Keranjang`
                : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg> Tambah ke Keranjang`;
        }

        // Re-render list to reflect state
        renderPkgList();
    }

    function updateFloatingCart(count) {
        const fc    = document.getElementById('floatingCart');
        const badge = document.getElementById('fctCount');
        badge.textContent = count;
        fc.style.display  = count > 0 ? 'block' : 'none';
        badge.style.transform = 'scale(1.4)';
        setTimeout(() => badge.style.transform = '', 200);
    }

    let wToastTimer;
    function showWelcomeToast(msg) {
        const hint = document.getElementById('floatingHint');
        hint.textContent = msg;
        hint.classList.add('show');
        clearTimeout(wToastTimer);
        wToastTimer = setTimeout(() => hint.classList.remove('show'), 3000);
    }

    // Init on load
    (function initCart() {
        updateFloatingCart(getCart().length);
    })();
</script>

</body>
</html>