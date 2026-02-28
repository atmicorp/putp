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

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-w: 240px;
            --sidebar-collapsed-w: 64px;
            --accent: #ea580c;
            --accent-light: #fff7ed;
            --accent-hover: #c2410c;
            --text: #1c1917;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #fffaf5;
            --surface: #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ─────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: width 0.25s ease;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-w);
        }

        /* Sidebar Header */
        .sidebar-header {
            height: 60px;
            flex-shrink: 0;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            overflow: hidden;
            transition: opacity 0.2s, width 0.25s;
            white-space: nowrap;
        }

        .sidebar.collapsed .sidebar-logo {
            opacity: 0;
            width: 0;
            pointer-events: none;
        }

        .sidebar.collapsed .sidebar-header {
            justify-content: center;
        }

        /* Toggle Button */
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
            transition: background 0.15s, color 0.15s;
        }

        .sidebar-toggle-btn:hover {
            background: var(--accent-light);
            color: var(--accent);
        }

        @media (max-width: 768px) {
            .sidebar-toggle-btn { display: none; }
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 16px 10px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--muted);
            padding: 0 8px;
            margin: 16px 0 6px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .nav-section-label {
            opacity: 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--muted);
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.15s;
            margin-bottom: 2px;
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 9px 0;
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
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .nav-item .nav-label {
            overflow: hidden;
            transition: opacity 0.2s, width 0.25s;
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-label {
            opacity: 0;
            width: 0;
        }

        /* Tooltip on collapsed */
        .nav-item {
            position: relative;
        }

        .sidebar.collapsed .nav-item:hover::after {
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
        }

        .sidebar.collapsed .nav-item:hover::before {
            content: '';
            position: absolute;
            left: calc(100% + 6px);
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: #1c1917;
            pointer-events: none;
            z-index: 200;
        }

        /* Footer */
        .sidebar-footer {
            padding: 12px 10px;
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
            transition: background 0.15s;
            overflow: hidden;
        }

        .user-card:hover {
            background: var(--accent-light);
        }

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
            transition: opacity 0.2s, width 0.25s;
            white-space: nowrap;
        }

        .sidebar.collapsed .user-info {
            opacity: 0;
            width: 0;
        }

        .user-name { font-size: 13px; font-weight: 600; color: var(--text); overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 11px; color: var(--muted); }

        .user-chevron-wrap {
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .user-chevron-wrap {
            display: none;
        }

        /* Popup */
        #user-popup {
            display: none;
            position: absolute;
            bottom: calc(100% + 8px);
            left: 8px;
            right: 8px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            overflow: hidden;
            z-index: 100;
            border: 1px solid rgba(0,0,0,0.08);
        }

        /* ── MAIN ────────────────────────────────────────── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.25s ease;
        }

        .main-wrapper.collapsed {
            margin-left: var(--sidebar-collapsed-w);
        }

        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--muted);
        }

        .topbar-breadcrumb .current {
            color: var(--text);
            font-weight: 600;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-content {
            padding: 32px;
            flex: 1;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--text);
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.25s; width: var(--sidebar-w) !important; }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0 !important; }
            .mobile-toggle { display: flex; }
            .page-content { padding: 20px; }
            .sidebar-toggle-btn { display: none; }
        }
    </style>
</head>
<body>
<div class="layout">

    {{-- ── SIDEBAR ───────────────────────────────────────── --}}
    <aside class="sidebar" id="sidebar">

        {{-- Header --}}
        <div class="sidebar-header" style="justify-content: center;">
            <a href="{{ route('dashboard') }}" class="sidebar-logo" id="sidebar-logo-full">
                <img src="{{ asset('storage/logo.jpg') }}" alt="{{ config('app.name') }}"
                    style="height:36px; width:auto; object-fit:contain;">
            </a>
        </div>

        {{-- Nav --}}
        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>

            <a href="{{ route('dashboard') }}"
               data-label="Dashboard"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="nav-label">Dashboard</span>
            </a>

            <div class="nav-section-label">Management</div>

            <a href="{{ route('users.index') }}"
               data-label="Users"
               class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="nav-label">Users</span>
            </a>
        </nav>

        {{-- Footer (user card + popup) --}}
        <div class="sidebar-footer">

            {{-- Popup (muncul di atas user card) --}}
            <div id="user-popup">
                {{-- User Info Header --}}
                <div style="
                    display:flex; flex-direction:column; align-items:center;
                    padding:20px 16px 16px; background:#eef4ff; gap:8px;
                ">
                    <div style="
                        width:56px; height:56px; border-radius:50%;
                        background:{{ $avatarColor }}; color:#fff;
                        display:flex; align-items:center; justify-content:center;
                        font-size:1.4rem; font-weight:600;
                        box-shadow:0 0 0 4px rgba(234,88,12,.15);
                    ">
                        {{ $avatarInitial }}
                    </div>
                    <div style="text-align:center;">
                        <div style="font-weight:600; color:#1a1a2e; font-size:.9rem;">
                            {{ auth()->user()->name ?? 'User' }}
                        </div>
                        <div style="font-size:.75rem; color:#666; margin-top:2px;">
                            {{ auth()->user()->email ?? '' }}
                        </div>
                    </div>
                </div>

                <div style="height:1px; background:#f0f0f0;"></div>

                {{-- Menu Items --}}
                <div style="padding:6px;">
                    <a href="{{ route('profile') }}" style="
                        display:flex; align-items:center; gap:10px;
                        padding:10px 12px; border-radius:8px;
                        color:#333; text-decoration:none; font-size:.875rem;
                        transition:background .15s;
                    "
                    onmouseover="this.style.background='#f5f5f5'"
                    onmouseout="this.style.background='transparent'">
                        <svg width="17" height="17" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="1.8" style="color:#555">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profile
                    </a>

                    <div style="height:1px; background:#f0f0f0; margin:4px 0;"></div>

                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" style="
                                width:100%; display:flex; align-items:center; gap:10px;
                                padding:10px 12px; border-radius:8px; border:none; background:transparent;
                                color:#e03131; font-size:.875rem; cursor:pointer; text-align:left;
                                transition:background .15s; font-family: inherit;
                            "
                            onmouseover="this.style.background='#fff5f5'"
                            onmouseout="this.style.background='transparent'">
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

            {{-- User Card (trigger) --}}
            <div class="user-card" id="user-card-trigger">
                <div class="user-avatar" style="background:{{ $avatarColor }}">
                    {{ $avatarInitial }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">Administrator</div>
                </div>
                <span class="user-chevron-wrap">
                    <svg id="user-chevron" style="transition:transform 0.2s;" width="14" height="14"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
                    </svg>
                </span>
            </div>
        </div>
    </aside>

    {{-- ── MAIN WRAPPER ─────────────────────────────────── --}}
    <div class="main-wrapper" id="main-wrapper">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="topbar-breadcrumb">
                {{-- Sidebar toggle (desktop) --}}
                <button class="sidebar-toggle-btn" id="sidebar-toggle-btn" onclick="toggleSidebar()" title="Toggle sidebar">
                    <svg id="toggle-icon" width="18" height="18" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11 19l-7-7 7-7M18 19l-7-7 7-7"/>
                    </svg>
                </button>
                {{-- Mobile hamburger --}}
                <button class="mobile-toggle"
                        onclick="document.getElementById('sidebar').classList.toggle('open')">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                {{ $breadcrumb ?? '' }}
            </div>
            <div class="topbar-actions">
                {{ $topbarActions ?? '' }}
            </div>
        </div>

        {{-- Page Content --}}
        <div class="page-content">
            {{ $slot }}
        </div>
    </div>

</div>

<script>
    // ── Sidebar Collapse ─────────────────────────────────────────
    const sidebar     = document.getElementById('sidebar');
    const mainWrapper = document.getElementById('main-wrapper');
    const toggleIcon  = document.getElementById('toggle-icon');

    const ICON_COLLAPSE = `<path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7M18 19l-7-7 7-7"/>`;
    const ICON_EXPAND   = `<path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M6 5l7 7-7 7"/>`;

    let isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

    function applySidebarState() {
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            mainWrapper.classList.add('collapsed');
            toggleIcon.innerHTML = ICON_EXPAND;
        } else {
            sidebar.classList.remove('collapsed');
            mainWrapper.classList.remove('collapsed');
            toggleIcon.innerHTML = ICON_COLLAPSE;
        }
    }

    function toggleSidebar() {
        isCollapsed = !isCollapsed;
        localStorage.setItem('sidebar-collapsed', isCollapsed);
        applySidebarState();
    }

    // Apply saved state on load (no transition flash)
    sidebar.style.transition = 'none';
    mainWrapper.style.transition = 'none';
    applySidebarState();
    requestAnimationFrame(() => {
        sidebar.style.transition = '';
        mainWrapper.style.transition = '';
    });

    // ── User Popup ───────────────────────────────────────────────
    const trigger = document.getElementById('user-card-trigger');
    const popup   = document.getElementById('user-popup');
    const chevron = document.getElementById('user-chevron');

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = popup.style.display === 'block';
        popup.style.display = isOpen ? 'none' : 'block';
        chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    });

    document.addEventListener('click', () => {
        popup.style.display = 'none';
        chevron.style.transform = 'rotate(0deg)';
    });
</script>

</body>
</html>