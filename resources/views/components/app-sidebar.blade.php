@php
    $palette       = ['#ea580c','#f97316','#06b6d4','#10b981','#f59e0b','#ef4444'];
    $avatarColor   = $palette[auth()->id() % count($palette)];
    $avatarInitial = strtoupper(substr(auth()->user()->name ?? 'U', 0, 1));
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'PUTP') }}</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('logopoltek.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ═══════════════════════════════════════════════════
           VARIABLES & RESET
        ═══════════════════════════════════════════════════ */
        :root {
            --sidebar-w: 240px;
            --sidebar-collapsed-w: 64px;
            --topbar-h: 60px;
            --footer-h: 77px;
            --accent: #ea580c;
            --accent-light: #fff7ed;
            --accent-hover: #c2410c;
            --text: #1c1917;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #fffaf5;
            --surface: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,.08);
            --shadow-lg: 0 8px 28px rgba(0,0,0,.12);
            --radius: 10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { -webkit-tap-highlight-color: transparent; }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ═══════════════════════════════════════════════════
           LAYOUT SHELL
        ═══════════════════════════════════════════════════ */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ═══════════════════════════════════════════════════
           MOBILE OVERLAY (backdrop)
        ═══════════════════════════════════════════════════ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            backdrop-filter: blur(2px);
            z-index: 49;
            opacity: 0;
            transition: opacity .25s ease;
        }

        .sidebar-overlay.visible {
            opacity: 1;
        }

        /* ═══════════════════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: width .25s ease, transform .25s ease;
            overflow: hidden;
            will-change: width, transform;
        }

        /* Desktop collapsed state */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-w);
        }

        /* ── Sidebar Header ── */
        .sidebar-header {
            height: var(--topbar-h);
            flex-shrink: 0;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;   
            padding: 0 16px;
            gap: 10px;
        }

        .sidebar-logo-link {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            overflow: hidden;
            white-space: nowrap;
            flex: 1;
            min-width: 0;
            transition: opacity .2s, max-width .25s;
        }

        .sidebar.collapsed .sidebar-logo-link {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
        }

        .sidebar-logo-link img {
            height: 36px;
            width: auto;
            object-fit: contain;
            flex-shrink: 0;
        }

        /* ── Desktop Toggle Btn ── */
        .sidebar-toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .15s, color .15s;
            line-height: 0;
        }

        .sidebar-toggle-btn:hover {
            background: var(--accent-light);
            color: var(--accent);
        }

        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 0;
        }

        /* ── Nav ── */
        .sidebar-nav {
            flex: 1;
            padding: 12px 8px;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--muted);
            padding: 0 10px;
            margin: 14px 0 5px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity .2s;
        }

        .sidebar.collapsed .nav-section-label { opacity: 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--muted);
            font-size: 13.5px;
            font-weight: 500;
            transition: background .15s, color .15s;
            margin-bottom: 2px;
            white-space: nowrap;
            position: relative;
        }

        .nav-item:hover {
            background: var(--accent-light);
            color: var(--accent);
        }

        .nav-item.active {
            background: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
        }

        .nav-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .nav-label {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity .2s, max-width .25s;
            max-width: 160px;
        }

        /* Collapsed state: center icon, hide label */
        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 10px 0;
        }

        .sidebar.collapsed .nav-label {
            opacity: 0;
            max-width: 0;
        }

        /* Tooltip on hover when collapsed */
        .sidebar.collapsed .nav-item::after {
            content: attr(data-label);
            position: absolute;
            left: calc(100% + 12px);
            top: 50%;
            transform: translateY(-50%);
            background: #1c1917;
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 200;
            opacity: 0;
            transition: opacity .15s;
        }

        .sidebar.collapsed .nav-item::before {
            content: '';
            position: absolute;
            left: calc(100% + 6px);
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1c1917;
            pointer-events: none;
            z-index: 200;
            opacity: 0;
            transition: opacity .15s;
        }

        .sidebar.collapsed .nav-item:hover::after,
        .sidebar.collapsed .nav-item:hover::before {
            opacity: 1;
        }

        /* ── Sidebar Footer ── */
        .sidebar-footer {
            padding: 10px 8px;
            border-top: 1px solid var(--border);
            position: relative;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 8px;
            background: var(--bg);
            cursor: pointer;
            transition: background .15s;
            overflow: hidden;
            user-select: none;
        }

        .user-card:hover { background: var(--accent-light); }

        .sidebar.collapsed .user-card {
            justify-content: center;
            padding: 10px 0;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity .2s, max-width .25s;
            max-width: 140px;
        }

        .sidebar.collapsed .user-info {
            opacity: 0;
            max-width: 0;
        }

        .user-name { font-size: 13px; font-weight: 600; color: var(--text); overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 11px; color: var(--muted); }

        .user-chevron-wrap { flex-shrink: 0; line-height: 0; }
        .sidebar.collapsed .user-chevron-wrap { display: none; }

        /* ── User Popup ── */
        #user-popup {
            display: none;
            position: absolute;
            bottom: calc(100% + 8px);
            left: 8px;
            right: 8px;
            background: var(--surface);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            z-index: 100;
            border: 1px solid rgba(0,0,0,.07);
            animation: popupIn .15s ease;
        }

        @keyframes popupIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .popup-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 16px 16px;
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            gap: 8px;
        }

        .popup-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: {{ $avatarColor }};
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            font-weight: 700;
            box-shadow: 0 0 0 4px rgba(234,88,12,.15);
        }

        .popup-name { font-weight: 600; color: #1a1a2e; font-size: .9rem; text-align: center; }
        .popup-email { font-size: .75rem; color: var(--muted); margin-top: 2px; text-align: center; }

        .popup-divider { height: 1px; background: var(--border); }

        .popup-menu { padding: 6px; }

        .popup-menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            font-size: .875rem;
            transition: background .15s;
            width: 100%;
            border: none;
            background: transparent;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
        }

        .popup-menu-item:hover { background: #f5f5f5; }
        .popup-menu-item.danger { color: #dc2626; }
        .popup-menu-item.danger:hover { background: #fff5f5; }

        /* ═══════════════════════════════════════════════════
           MAIN WRAPPER
        ═══════════════════════════════════════════════════ */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left .25s ease;
            min-width: 0;
        }

        .main-wrapper.collapsed {
            margin-left: var(--sidebar-collapsed-w);
        }

        /* ── Topbar ── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
            gap: 12px;
            flex-shrink: 0;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            flex: 1;
        }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar-breadcrumb .current {
            color: var(--text);
            font-weight: 600;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        /* ── Page Content ── */
        .page-content {
            padding: 28px 28px 112px;
            flex: 1;
        }

        /* ── Footer ── */
        .app-footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 0 24px;
            height: var(--footer-h);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            position: sticky;
            bottom: 0;
            z-index: 40;
        }

        .app-footer-copy {
            font-size: 11.5px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .app-footer-copy strong { color: var(--text); font-weight: 600; }

        .footer-dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--border);
            display: inline-block;
            flex-shrink: 0;
        }

        .app-footer-brand {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            color: var(--muted);
            white-space: nowrap;
        }

        .app-footer-brand span { color: var(--accent); font-weight: 600; }

        /* ── Desktop Toggle Btn in topbar ── */
        .topbar-toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .15s, color .15s;
            line-height: 0;
        }

        .topbar-toggle-btn:hover {
            background: var(--accent-light);
            color: var(--accent);
        }

        /* ── Mobile hamburger ── */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            color: var(--text);
            border-radius: 6px;
            line-height: 0;
            flex-shrink: 0;
            transition: background .15s;
        }

        .mobile-toggle:hover { background: var(--accent-light); }

        /* ═══════════════════════════════════════════════════
           RESPONSIVE BREAKPOINTS
        ═══════════════════════════════════════════════════ */

        /* ── Tablet (641px – 1024px) ── */
        @media (max-width: 1024px) and (min-width: 641px) {
            /* Auto-collapse on tablet */
            .sidebar {
                width: var(--sidebar-collapsed-w);
            }

            .sidebar .sidebar-logo-link {
                opacity: 0;
                max-width: 0;
                pointer-events: none;
            }

            .sidebar .sidebar-header {
                justify-content: center;
                padding: 0;
            }

            .sidebar .nav-section-label { opacity: 0; }

            .sidebar .nav-item {
                justify-content: center;
                padding: 10px 0;
            }

            .sidebar .nav-label {
                opacity: 0;
                max-width: 0;
            }

            .sidebar .user-card {
                justify-content: center;
                padding: 10px 0;
            }

            .sidebar .user-info {
                opacity: 0;
                max-width: 0;
            }

            .sidebar .user-chevron-wrap { display: none; }

            /* Tooltip still works on tablet hover */
            .sidebar .nav-item::after {
                content: attr(data-label);
                position: absolute;
                left: calc(100% + 12px);
                top: 50%;
                transform: translateY(-50%);
                background: #1c1917;
                color: #fff;
                font-size: 12px;
                font-weight: 500;
                padding: 5px 10px;
                border-radius: 6px;
                white-space: nowrap;
                pointer-events: none;
                z-index: 200;
                opacity: 0;
                transition: opacity .15s;
            }

            .sidebar .nav-item::before {
                content: '';
                position: absolute;
                left: calc(100% + 6px);
                top: 50%;
                transform: translateY(-50%);
                border: 5px solid transparent;
                border-right-color: #1c1917;
                pointer-events: none;
                z-index: 200;
                opacity: 0;
                transition: opacity .15s;
            }

            .sidebar .nav-item:hover::after,
            .sidebar .nav-item:hover::before { opacity: 1; }

            .main-wrapper { margin-left: var(--sidebar-collapsed-w); }
            .topbar-toggle-btn { display: none; }
            .page-content { padding: 20px 20px 72px; }
        }

        /* ── Mobile (≤ 640px) ── */
        @media (max-width: 640px) {
            /* Sidebar slides in from left, full width behavior */
            .sidebar {
                width: 260px !important;
                transform: translateX(-100%);
                box-shadow: none;
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: var(--shadow-lg);
            }

            /* Restore all hidden elements when open on mobile */
            .sidebar.open .sidebar-logo-link {
                opacity: 1;
                max-width: 200px;
                pointer-events: auto;
            }

            .sidebar.open .sidebar-header {
                justify-content: space-between;
                padding: 0 16px;
            }

            .sidebar.open .nav-section-label { opacity: 1; }

            .sidebar.open .nav-item {
                justify-content: flex-start;
                padding: 10px 10px;
            }

            .sidebar.open .nav-label {
                opacity: 1;
                max-width: 160px;
            }

            .sidebar.open .user-card {
                justify-content: flex-start;
                padding: 10px;
            }

            .sidebar.open .user-info {
                opacity: 1;
                max-width: 140px;
            }

            .sidebar.open .user-chevron-wrap { display: flex; }

            /* No tooltips on mobile */
            .sidebar .nav-item::after,
            .sidebar .nav-item::before { display: none !important; }

            .sidebar-overlay { display: block; }

            .main-wrapper { margin-left: 0 !important; }

            .topbar-toggle-btn { display: none; }
            .mobile-toggle { display: flex; }

            .topbar { padding: 0 16px; }
            .page-content { padding: 16px 16px 68px; }
            .app-footer { padding: 0 16px; height: 48px; }
            .app-footer-brand { display: none; }
            .app-footer-copy { font-size: 11px; }

            /* User popup fills width on mobile */
            #user-popup { left: 4px; right: 4px; }

            /* Close button inside sidebar on mobile */
            .sidebar-mobile-close {
                display: flex !important;
            }
        }

        /* Hide mobile close btn by default */
        .sidebar-mobile-close {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 6px;
            border-radius: 6px;
            align-items: center;
            justify-content: center;
            line-height: 0;
            flex-shrink: 0;
            transition: background .15s, color .15s;
        }

        .sidebar-mobile-close:hover {
            background: var(--accent-light);
            color: var(--accent);
        }

        /* ═══════════════════════════════════════════════════
           UTILITY
        ═══════════════════════════════════════════════════ */
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            color: var(--muted);
            transition: background .15s, color .15s;
            line-height: 0;
        }

        .icon-btn:hover {
            background: var(--accent-light);
            color: var(--accent);
        }
    </style>
</head>
<body>

{{-- Overlay (mobile backdrop) --}}
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<div class="layout">

    {{-- ── SIDEBAR ──────────────────────────────────────────────── --}}
    <aside class="sidebar" id="sidebar">

        {{-- Header --}}
        <div class="sidebar-header" id="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-logo-link" id="sidebar-logo-full">
                <img src="{{ asset('storage/logo.jpg') }}" alt="{{ config('app.name') }}">
            </a>
            {{-- Mobile close button --}}
            <button class="sidebar-mobile-close" id="sidebar-mobile-close" aria-label="Close menu">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="sidebar-nav" role="navigation" aria-label="Main navigation">
            <div class="nav-section-label">Main</div>

            <a href="{{ route('dashboard') }}"
               data-label="Dashboard"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="nav-label">Dashboard</span>
            </a>

            <div class="nav-section-label">Order</div>

            <a href="{{ route('admin.orders.index') }}"
               data-label="Order"
               class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('admin.orders.*') ? 'page' : 'false' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 5h6m-6 4h6m-6 4h6M7 3h10a2 2 0 012 2v16l-4-2-4 2-4-2-4 2V5a2 2 0 012-2z"/>
                </svg>
                <span class="nav-label">Order</span>
            </a>

            <div class="nav-section-label">Machine</div>

            <a href="{{ route('machine.index') }}"
               data-label="Machine"
               class="nav-item {{ request()->routeIs('machine.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('machine.*') ? 'page' : 'false' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M11.25 2.25h1.5l.5 2.25a7.5 7.5 0 012.25.9l2-1.25 1.05 1.05-1.25 2a7.5 7.5 0 01.9 2.25l2.25.5v1.5l-2.25.5a7.5 7.5 0 01-.9 2.25l1.25 2-1.05 1.05-2-1.25a7.5 7.5 0 01-2.25.9l-.5 2.25h-1.5l-.5-2.25a7.5 7.5 0 01-2.25-.9l-2 1.25-1.05-1.05 1.25-2a7.5 7.5 0 01-.9-2.25L2.25 12v-1.5l2.25-.5a7.5 7.5 0 01.9-2.25l-1.25-2L5.2 4.7l2 1.25a7.5 7.5 0 012.25-.9l.5-2.25z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                <span class="nav-label">Machine</span>
            </a>

            <div class="nav-section-label">Packages</div>

            <a href="{{ route('package.index') }}"
               data-label="Packages"
               class="nav-item {{ request()->routeIs('package.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('package.*') ? 'page' : 'false' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM16 3H8a1 1 0 00-1 1v3h10V4a1 1 0 00-1-1zM8 17v3a1 1 0 001 1h6a1 1 0 001-1v-3"/>
                </svg>
                <span class="nav-label">Packages</span>
            </a>

            <div class="nav-section-label">Management</div>

            <a href="{{ route('users.index') }}"
               data-label="Users"
               class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
               aria-current="{{ request()->routeIs('users.*') ? 'page' : 'false' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="nav-label">Users</span>
            </a>
        </nav>

        {{-- Sidebar Footer (user card) --}}
        <div class="sidebar-footer">

            {{-- User Popup --}}
            <div id="user-popup" role="dialog" aria-label="User menu">
                <div class="popup-header">
                    <div class="popup-avatar">{{ $avatarInitial }}</div>
                    <div>
                        <div class="popup-name">{{ auth()->user()->name ?? 'User' }}</div>
                        <div class="popup-email">{{ auth()->user()->email ?? '' }}</div>
                    </div>
                </div>

                <div class="popup-divider"></div>

                <div class="popup-menu">
                    <a href="{{ route('profile') }}" class="popup-menu-item">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile
                    </a>

                    <div class="popup-divider" style="margin: 4px 0;"></div>

                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="popup-menu-item danger">
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>

            {{-- User Card --}}
            <div class="user-card" id="user-card-trigger" role="button"
                 tabindex="0" aria-haspopup="true" aria-expanded="false">
                <div class="user-avatar" style="background:{{ $avatarColor }}">
                    {{ $avatarInitial }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">Administrator</div>
                </div>
                <span class="user-chevron-wrap">
                    <svg id="user-chevron" style="transition:transform .2s;" width="14" height="14"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                    </svg>
                </span>
            </div>
        </div>
    </aside>

    {{-- ── MAIN WRAPPER ──────────────────────────────────────────── --}}
    <div class="main-wrapper" id="main-wrapper">

        {{-- Topbar --}}
        <header class="topbar" role="banner">
            <div class="topbar-left">
                {{-- Mobile hamburger --}}
                <button class="mobile-toggle" id="mobile-toggle" aria-label="Open menu" aria-expanded="false">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Desktop sidebar toggle --}}
                <button class="topbar-toggle-btn" id="sidebar-toggle-btn"
                        onclick="toggleSidebar()" title="Toggle sidebar" aria-label="Toggle sidebar">
                    <svg id="toggle-icon" width="18" height="18" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11 19l-7-7 7-7M18 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- Breadcrumb --}}
                <nav class="topbar-breadcrumb" aria-label="Breadcrumb">
                    {{ $breadcrumb ?? '' }}
                </nav>
            </div>

            <div class="topbar-actions">
                {{ $topbarActions ?? '' }}
            </div>
        </header>

        {{-- Page Content --}}
        <main class="page-content" role="main">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="app-footer" role="contentinfo">
            <div class="app-footer-copy">
                <span>&copy; 2026</span>
                <span class="footer-dot"></span>
                <strong>IT YKBS</strong>
                <span class="footer-dot"></span>
                <span>All rights reserved.</span>
            </div>
            <div class="app-footer-brand">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.8" style="color:var(--accent)">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span id="footer-day"></span>
                <span class="footer-dot"></span>
                <span id="footer-clock" style="font-variant-numeric: tabular-nums; color:var(--accent); font-weight:600;"></span>
            </div>
        </footer>
    </div>

</div>

<script>
(function () {
    'use strict';

    /* ── Elements ─────────────────────────────────────────────── */
    const sidebar      = document.getElementById('sidebar');
    const mainWrapper  = document.getElementById('main-wrapper');
    const toggleIcon   = document.getElementById('toggle-icon');
    const overlay      = document.getElementById('sidebar-overlay');
    const mobileToggle = document.getElementById('mobile-toggle');
    const mobileClose  = document.getElementById('sidebar-mobile-close');
    const trigger      = document.getElementById('user-card-trigger');
    const popup        = document.getElementById('user-popup');
    const chevron      = document.getElementById('user-chevron');

    const ICON_COLLAPSE = `<path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7M18 19l-7-7 7-7"/>`;
    const ICON_EXPAND   = `<path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M6 5l7 7-7 7"/>`;

    /* ── Breakpoint helpers ──────────────────────────────────── */
    const isMobile  = () => window.innerWidth <= 640;
    const isTablet  = () => window.innerWidth > 640 && window.innerWidth <= 1024;
    const isDesktop = () => window.innerWidth > 1024;

    /* ── Desktop collapse state ──────────────────────────────── */
    let isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

    function applyDesktopState (animate) {
        if (!animate) {
            sidebar.style.transition = 'none';
            mainWrapper.style.transition = 'none';
        }

        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            mainWrapper.classList.add('collapsed');
            toggleIcon.innerHTML = ICON_EXPAND;
        } else {
            sidebar.classList.remove('collapsed');
            mainWrapper.classList.remove('collapsed');
            toggleIcon.innerHTML = ICON_COLLAPSE;
        }

        if (!animate) {
            requestAnimationFrame(() => {
                sidebar.style.transition = '';
                mainWrapper.style.transition = '';
            });
        }
    }

    window.toggleSidebar = function () {
        if (!isDesktop()) return;
        isCollapsed = !isCollapsed;
        localStorage.setItem('sidebar-collapsed', isCollapsed);
        applyDesktopState(true);
    };

    /* ── Mobile sidebar ──────────────────────────────────────── */
    function openMobileSidebar () {
        sidebar.classList.add('open');
        overlay.style.display = 'block';
        requestAnimationFrame(() => overlay.classList.add('visible'));
        mobileToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden'; // prevent background scroll
    }

    function closeMobileSidebar () {
        sidebar.classList.remove('open');
        overlay.classList.remove('visible');
        setTimeout(() => { overlay.style.display = 'none'; }, 250);
        mobileToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    mobileToggle.addEventListener('click', openMobileSidebar);
    mobileClose.addEventListener('click', closeMobileSidebar);
    overlay.addEventListener('click', closeMobileSidebar);

    /* Close sidebar when a nav link is tapped on mobile */
    sidebar.querySelectorAll('.nav-item').forEach(link => {
        link.addEventListener('click', () => {
            if (isMobile()) closeMobileSidebar();
        });
    });

    /* Escape key closes mobile sidebar */
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (isMobile() && sidebar.classList.contains('open')) closeMobileSidebar();
            if (popup.style.display === 'block') closePopup();
        }
    });

    /* ── On resize: reset states properly ───────────────────── */
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (!isMobile()) {
                // Make sure mobile state is cleaned up
                closeMobileSidebar();
            }
            if (isDesktop()) {
                applyDesktopState(false);
            }
        }, 100);
    });

    /* ── Initial state (no flash) ────────────────────────────── */
    if (isDesktop()) {
        applyDesktopState(false);
    }

    /* ── User Popup ──────────────────────────────────────────── */
    function openPopup () {
        popup.style.display = 'block';
        chevron.style.transform = 'rotate(180deg)';
        trigger.setAttribute('aria-expanded', 'true');
    }

    function closePopup () {
        popup.style.display = 'none';
        chevron.style.transform = 'rotate(0deg)';
        trigger.setAttribute('aria-expanded', 'false');
    }

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        popup.style.display === 'block' ? closePopup() : openPopup();
    });

    /* Keyboard accessibility for user card */
    trigger.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            popup.style.display === 'block' ? closePopup() : openPopup();
        }
    });

    document.addEventListener('click', (e) => {
        if (!trigger.contains(e.target) && !popup.contains(e.target)) {
            closePopup();
        }
    });

    /* ── Live Clock ──────────────────────────────────────────── */
    const DAYS = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

    function updateClock () {
        const now = new Date();
        const hh  = String(now.getHours()).padStart(2, '0');
        const mm  = String(now.getMinutes()).padStart(2, '0');
        const ss  = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('footer-day').textContent   = DAYS[now.getDay()];
        document.getElementById('footer-clock').textContent = `${hh}:${mm}:${ss}`;
    }

    updateClock();
    setInterval(updateClock, 1000);

})();
</script>

</body>
</html>