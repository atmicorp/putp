<x-app-sidebar>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="breadcrumb">
        <span class="current">Dashboard</span>
    </x-slot>

    <style>
        /* ── Google Font ── */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@600&display=swap');

        * { box-sizing: border-box; }

        body, .dash-wrap { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Base ── */
        .dash-wrap { padding: 0; }

        .dash-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 20px; gap: 12px;
        }
        .dash-title {
            font-size: 22px; font-weight: 800; letter-spacing: -0.5px;
            color: #1c1917; line-height: 1.2;
        }
        .dash-subtitle {
            font-size: 12.5px; color: #9ca3af; margin-top: 4px; font-weight: 500;
        }
        .dash-avatar {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, #ea580c, #f59e0b);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 800; color: #fff;
            flex-shrink: 0;
        }

        /* ══════════════════════════════
           KPI Cards — 2x2 grid on mobile,
           4-col on desktop
        ══════════════════════════════ */
        .kpi-scroll-wrap {
            margin-bottom: 20px;
        }

        .kpi-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .kpi-card {
            background: #fff; border: 1px solid #f0ede9; border-radius: 16px;
            padding: 14px 16px; position: relative; overflow: hidden;
        }
        .kpi-card::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px; border-radius: 0 0 16px 16px;
        }
        .kpi-card:nth-child(1)::after { background: #ea580c; }
        .kpi-card:nth-child(2)::after { background: #f59e0b; }
        .kpi-card:nth-child(3)::after { background: #3b82f6; }
        .kpi-card:nth-child(4)::after { background: #10b981; }

        .kpi-icon {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 12px;
        }
        .kpi-card:nth-child(1) .kpi-icon { background: #fff7ed; }
        .kpi-card:nth-child(2) .kpi-icon { background: #fffbeb; }
        .kpi-card:nth-child(3) .kpi-icon { background: #eff6ff; }
        .kpi-card:nth-child(4) .kpi-icon { background: #f0fdf4; }

        .kpi-label {
            font-size: 10.5px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.7px; color: #9ca3af;
        }
        .kpi-value {
            font-size: 28px; font-weight: 800; color: #1c1917;
            margin-top: 4px; line-height: 1; letter-spacing: -1px;
        }
        .kpi-desc { font-size: 11px; color: #c4b5ad; margin-top: 5px; font-weight: 500; }

        /* ══════════════════════════════
           Filter Bar
        ══════════════════════════════ */
        .filter-bar {
            background: #fff; border: 1px solid #f0ede9; border-radius: 14px;
            padding: 12px 14px; margin-bottom: 16px;
        }
        .filter-bar-top {
            display: flex; align-items: center; gap: 10px; margin-bottom: 10px;
        }
        .filter-bar-label {
            font-size: 11px; font-weight: 700; color: #9ca3af;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .filter-tabs {
            display: flex; gap: 3px; background: #f3f4f6;
            border-radius: 9px; padding: 3px; flex: 1; overflow-x: auto;
            scrollbar-width: none;
        }
        .filter-tabs::-webkit-scrollbar { display: none; }
        .filter-tab {
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 700;
            cursor: pointer; border: none; background: transparent; color: #6b7280;
            transition: all 0.15s; font-family: 'Plus Jakarta Sans', sans-serif;
            white-space: nowrap; flex-shrink: 0;
        }
        .filter-tab.active {
            background: #fff; color: #ea580c;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .filter-bottom {
            display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
        }
        .filter-inputs {
            display: none; align-items: center; gap: 6px; flex-wrap: wrap; flex: 1;
        }
        .filter-inputs.show { display: flex; }
        .filter-input {
            padding: 6px 10px; border: 1.5px solid #f0ede9; border-radius: 8px;
            font-size: 12px; color: #374151; background: #fafafa;
            font-family: 'Plus Jakarta Sans', sans-serif; outline: none;
            transition: border-color 0.15s; flex: 1; min-width: 120px;
        }
        .filter-input:focus { border-color: #ea580c; background: #fff; }
        .filter-sep { font-size: 12px; color: #d1d5db; font-weight: 700; }

        .filter-action-row {
            display: flex; gap: 6px; align-items: center; width: 100%; margin-top: 2px;
        }
        .filter-apply-btn {
            flex: 1; padding: 8px 14px; border-radius: 9px; font-size: 12.5px; font-weight: 700;
            cursor: pointer; border: none; background: #ea580c; color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif; transition: background 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 5px;
        }
        .filter-apply-btn:hover { background: #c2410c; }
        .filter-apply-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .filter-reset-btn {
            padding: 8px 14px; border-radius: 9px; font-size: 12px; font-weight: 700;
            cursor: pointer; border: 1.5px solid #f0ede9; background: #fff; color: #6b7280;
            font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.15s;
        }
        .filter-reset-btn:hover { border-color: #9ca3af; color: #374151; }

        .filter-active-badge {
            display: none; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            background: #fff7ed; color: #ea580c;
            font-size: 11px; font-weight: 700; border: 1px solid #fed7aa;
            width: 100%; margin-top: 6px; justify-content: center;
        }
        .filter-active-badge.show { display: flex; }

        /* ══════════════════════════════
           Chart Card
        ══════════════════════════════ */
        .section-card {
            background: #fff; border: 1px solid #f0ede9; border-radius: 16px;
            overflow: hidden; position: relative; margin-bottom: 14px;
        }
        .section-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px; border-bottom: 1px solid #f9f7f5;
        }
        .section-title { font-size: 13px; font-weight: 800; color: #1c1917; }
        .section-sub   { font-size: 11px; color: #9ca3af; margin-top: 2px; font-weight: 500; }
        .section-body  { padding: 16px; }

        /* ── Loading ── */
        .chart-loading {
            display: none; position: absolute; inset: 0;
            background: rgba(255,255,255,0.8); border-radius: 16px;
            align-items: center; justify-content: center; z-index: 10;
        }
        .chart-loading.visible { display: flex; }
        .spinner {
            width: 22px; height: 22px; border: 3px solid #f3f4f6;
            border-top-color: #ea580c; border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ══════════════════════════════
           Status Distribution
        ══════════════════════════════ */
        .status-list { display: flex; flex-direction: column; gap: 8px; }
        .status-row  { display: flex; align-items: center; gap: 8px; }
        .status-row-label {
            min-width: 100px;
        }
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: 700;
            white-space: nowrap;
        }
        .badge-draft         { background: #f3f4f6; color: #6b7280; }
        .badge-offered       { background: #eff6ff; color: #2563eb; }
        .badge-approved      { background: #f0fdf4; color: #16a34a; }
        .badge-rejected      { background: #fef2f2; color: #dc2626; }
        .badge-processing    { background: #faf5ff; color: #7c3aed; }
        .badge-done          { background: #f0fdf4; color: #15803d; }
        .badge-submit        { background: #fefce8; color: #ca8a04; }

        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .dot-draft         { background: #9ca3af; }
        .dot-offered       { background: #3b82f6; }
        .dot-approved      { background: #16a34a; }
        .dot-rejected      { background: #dc2626; }
        .dot-processing    { background: #7c3aed; }
        .dot-done          { background: #15803d; }
        .dot-submit        { background: #ca8a04; }

        .status-bar-wrap  {
            flex: 1; background: #f3f4f6; border-radius: 20px; height: 7px; overflow: hidden;
        }
        .status-bar       { height: 100%; border-radius: 20px; transition: width 0.6s ease; }
        .status-row-count {
            font-size: 11.5px; font-weight: 700; color: #6b7280;
            min-width: 24px; text-align: right;
            font-family: 'JetBrains Mono', monospace;
        }

        /* ══════════════════════════════
           Recent Orders Table
           → Card list on mobile
        ══════════════════════════════ */
        .table-card {
            background: #fff; border: 1px solid #f0ede9; border-radius: 16px;
            overflow: hidden;
        }
        .table-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px; border-bottom: 1px solid #f9f7f5;
        }
        .table-toolbar-title { font-size: 13px; font-weight: 800; color: #1c1917; }
        .table-toolbar-sub   { font-size: 11px; color: #9ca3af; margin-top: 2px; font-weight: 500; }
        .see-all-link {
            font-size: 12px; font-weight: 700; color: #ea580c;
            text-decoration: none; white-space: nowrap;
        }
        .see-all-link:hover { text-decoration: underline; }

        /* Desktop table (hidden on mobile) */
        .desktop-table { display: none; }
        .desktop-table table { width: 100%; border-collapse: collapse; }
        .desktop-table thead th {
            padding: 10px 20px; text-align: left; font-size: 10.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        .desktop-table tbody tr { border-bottom: 1px solid #f9f7f5; transition: background 0.1s; }
        .desktop-table tbody tr:last-child { border-bottom: none; }
        .desktop-table tbody tr:hover { background: #fff7ed; }
        .desktop-table td { padding: 13px 20px; font-size: 13px; vertical-align: middle; }

        /* Mobile card list */
        .mobile-orders { display: flex; flex-direction: column; }
        .mobile-order-card {
            padding: 14px 16px; border-bottom: 1px solid #f9f7f5;
            display: flex; flex-direction: column; gap: 8px;
            transition: background 0.1s;
        }
        .mobile-order-card:last-child { border-bottom: none; }
        .mobile-order-card:hover { background: #fff7ed; }
        .mobile-order-row-top {
            display: flex; align-items: center; justify-content: space-between; gap: 8px;
        }
        .mobile-order-row-bottom {
            display: flex; align-items: center; justify-content: space-between; gap: 8px;
        }
        .order-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px; font-weight: 600; color: #ea580c;
            letter-spacing: 0.3px;
        }
        .customer-name  { font-size: 13px; font-weight: 700; color: #1c1917; }
        .customer-email { font-size: 11px; color: #9ca3af; margin-top: 1px; }
        .date-text      { font-size: 11px; color: #9ca3af; font-weight: 500; }
        .creator-text   { font-size: 11px; color: #9ca3af; font-weight: 500; }

        .act-btn {
            padding: 5px 12px; border-radius: 7px; font-size: 11.5px; font-weight: 700;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.15s;
            white-space: nowrap;
        }
        .act-view       { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .act-view:hover { background: #ffedd5; }

        /* Empty state */
        .empty-state {
            text-align: center; padding: 48px 20px;
        }
        .empty-state-icon { font-size: 36px; margin-bottom: 10px; }
        .empty-state-title { font-size: 14px; font-weight: 700; color: #1c1917; }
        .empty-state-sub   { font-size: 12px; color: #9ca3af; margin-top: 4px; }

        /* ══════════════════════════════
           RESPONSIVE BREAKPOINTS
        ══════════════════════════════ */

        @media (min-width: 900px) {
            .kpi-row { grid-template-columns: repeat(4, 1fr); gap: 14px; }

            /* Side-by-side chart + status */
            .mid-row {
                display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
            }
            .mid-row .section-card { margin-bottom: 0; }

            /* Show desktop table, hide mobile cards */
            .desktop-table { display: block; }
            .mobile-orders { display: none; }

            .filter-bar-top { margin-bottom: 0; }
            .filter-bar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; padding: 10px 14px; }
            .filter-bar-top { margin-bottom: 0; flex: none; }
            .filter-bottom { flex: 1; }
            .filter-action-row { width: auto; margin-top: 0; }
            .filter-active-badge { width: auto; margin-top: 0; }
            .filter-inputs { flex: none; }
        }

        @media (min-width: 1100px) {
            .dash-title { font-size: 24px; }
        }

        /* ── Small mobile tweaks ── */
        @media (max-width: 360px) {
            .kpi-card { padding: 12px 12px; }
            .kpi-value { font-size: 22px; }
            .kpi-label { font-size: 9.5px; }
        }

        #monthlyChart { width: 100% !important; }
    </style>

    <div class="dash-header">
        <div>
            <div class="dash-title">Dashboard</div>
            <p class="dash-subtitle">{{ now()->format('l, d F Y') }}</p>
        </div>
        <div class="dash-avatar" title="{{ auth()->user()->name }}">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>

    {{-- ═══ KPI Cards ═══ --}}
    <div class="kpi-scroll-wrap">
        <div class="kpi-row">
            <div class="kpi-card">
                <div class="kpi-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="kpi-label">Total Order</div>
                <div class="kpi-value">{{ $totalOrders }}</div>
                <div class="kpi-desc">Semua order</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="kpi-label">Active</div>
                <div class="kpi-value">{{ $activeOrders }}</div>
                <div class="kpi-desc">Sedang berjalan</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="2.2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="kpi-label">Bulan Ini</div>
                <div class="kpi-value">{{ $newThisMonth }}</div>
                <div class="kpi-desc">{{ now()->format('M Y') }}</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#10b981" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="kpi-label">Done</div>
                <div class="kpi-value">{{ $doneOrders }}</div>
                <div class="kpi-desc">Selesai</div>
            </div>
        </div>
    </div>

    {{-- ═══ Filter Bar ═══ --}}
    <div class="filter-bar" id="filterBar">
        <div class="filter-bar-top">
            <span class="filter-bar-label">Filter</span>
            <div class="filter-tabs">
                <button class="filter-tab active" data-type="default" onclick="switchTab(this,'default')">6 Bulan</button>
                <button class="filter-tab"        data-type="month"   onclick="switchTab(this,'month')">Bulan</button>
                <button class="filter-tab"        data-type="week"    onclick="switchTab(this,'week')">Minggu</button>
                <button class="filter-tab"        data-type="range"   onclick="switchTab(this,'range')">Range</button>
            </div>
        </div>

        <div class="filter-bottom">
            {{-- Input: Month --}}
            <div class="filter-inputs" id="input-month">
                <input type="month" id="monthPicker" class="filter-input"
                       value="{{ now()->format('Y-m') }}" max="{{ now()->format('Y-m') }}">
            </div>
            {{-- Input: Week --}}
            <div class="filter-inputs" id="input-week">
                <input type="week" id="weekPicker" class="filter-input"
                       value="{{ now()->format('Y') }}-W{{ now()->format('W') }}">
            </div>
            {{-- Input: Range --}}
            <div class="filter-inputs" id="input-range">
                <input type="date" id="dateFrom" class="filter-input"
                       value="{{ now()->subDays(29)->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
                <span class="filter-sep">→</span>
                <input type="date" id="dateTo" class="filter-input"
                       value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
            </div>

            <div class="filter-action-row">
                <button class="filter-apply-btn" id="applyBtn" onclick="applyFilter()">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Terapkan
                </button>
                <button class="filter-reset-btn" id="resetBtn" style="display:none" onclick="resetFilter()">
                    Reset
                </button>
            </div>

            <div class="filter-active-badge" id="filterBadge"></div>
        </div>
    </div>

    {{-- ═══ Mid Row: Chart + Status ═══ --}}
    <div class="mid-row">
        {{-- Chart --}}
        <div class="section-card">
            <div class="section-header">
                <div>
                    <div class="section-title">Order per Periode</div>
                    <div class="section-sub" id="chartSubtitle">6 bulan terakhir</div>
                </div>
            </div>
            <div class="section-body" style="position:relative">
                <div class="chart-loading" id="chartLoading"><div class="spinner"></div></div>
                <canvas id="monthlyChart" height="220"></canvas>
            </div>
        </div>

        {{-- Status Distribution --}}
        <div class="section-card">
            <div class="section-header">
                <div>
                    <div class="section-title">Status Order</div>
                    <div class="section-sub">Distribusi status aktif</div>
                </div>
            </div>
            <div class="section-body" style="position:relative">
                <div class="chart-loading" id="statusLoading"><div class="spinner"></div></div>
                @php
                    $barColors = [
                        'draft'      => '#9ca3af',
                        'submit'     => '#ca8a04',
                        'offered'    => '#2563eb',
                        'rejected'   => '#dc2626',
                        'approved'   => '#059669',
                        'processing' => '#7c3aed',
                        'done'       => '#16a34a',
                    ];
                    $total = max($totalOrders, 1);
                @endphp
                <div class="status-list" id="statusList">
                    @foreach($statuses as $key => $s)
                        @php $cnt = $countByStatus[$key] ?? 0; @endphp
                        <div class="status-row" data-status="{{ $key }}">
                            <span class="status-row-label">
                                <span class="badge badge-{{ $key }}">
                                    <span class="dot dot-{{ $key }}"></span>
                                    {{ $s['label'] }}
                                </span>
                            </span>
                            <div class="status-bar-wrap">
                                <div class="status-bar"
                                     data-color="{{ $barColors[$key] ?? '#9ca3af' }}"
                                     style="width:{{ round($cnt/$total*100) }}%; background:{{ $barColors[$key] ?? '#9ca3af' }};"></div>
                            </div>
                            <span class="status-row-count">{{ $cnt }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ Recent Orders ═══ --}}
    <div class="table-card">
        <div class="table-toolbar">
            <div>
                <div class="table-toolbar-title">Order Terbaru</div>
                <div class="table-toolbar-sub">8 order terakhir</div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="see-all-link">Lihat semua →</a>
        </div>

        @if($recentOrders->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <div class="empty-state-title">Belum ada order</div>
                <div class="empty-state-sub">Order baru akan muncul di sini</div>
            </div>
        @else
            {{-- Mobile card list --}}
            <div class="mobile-orders">
                @foreach($recentOrders as $order)
                    <div class="mobile-order-card">
                        <div class="mobile-order-row-top">
                            <div>
                                <div class="customer-name">{{ $order->customer_name }}</div>
                                <div class="customer-email">{{ $order->customer_email }}</div>
                            </div>
                            <span class="badge badge-{{ $order->status }}">
                                <span class="dot dot-{{ $order->status }}"></span>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                        <div class="mobile-order-row-bottom">
                            <div style="display:flex; flex-direction:column; gap:3px;">
                                <span class="order-code">{{ $order->order_code }}</span>
                                <span class="date-text">
                                    {{ $order->created_at->format('d M Y') }}
                                    @if($order->creator) · {{ $order->creator->name }} @endif
                                </span>
                            </div>
                            <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">Detail →</a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Desktop table --}}
            <div class="desktop-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Dibuat oleh</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td><span class="order-code">{{ $order->order_code }}</span></td>
                                <td>
                                    <div class="customer-name">{{ $order->contact->name }}</div>
                                    <div class="customer-email">{{ $order->contact->email }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">
                                        <span class="dot dot-{{ $order->status }}"></span>
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td><span class="date-text">{{ $order->creator?->name ?? '-' }}</span></td>
                                <td><span class="date-text">{{ $order->created_at->format('d M Y') }}</span></td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="act-btn act-view">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        const FILTER_URL    = '{{ route('admin.dashboard.filter') }}';
        const CSRF          = '{{ csrf_token() }}';
        const initialLabels = {!! $chartLabels !!};
        const initialCounts = {!! $chartCounts !!};

        let currentType = 'default';

        // ── Chart ──────────────────────────────────────────────────────────────
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: initialLabels,
                datasets: [{
                    label: 'Order',
                    data: initialCounts,
                    backgroundColor: 'rgba(234,88,12,0.12)',
                    borderColor: '#ea580c',
                    borderWidth: 2,
                    borderRadius: 6,
                    hoverBackgroundColor: 'rgba(234,88,12,0.25)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1c1917',
                        titleColor: '#fff',
                        bodyColor: '#d1d5db',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: { label: c => ` ${c.parsed.y} order` }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 },
                            color: '#9ca3af', maxRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f9f7f5' },
                        ticks: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 },
                            color: '#9ca3af', stepSize: 1, precision: 0
                        }
                    }
                }
            }
        });

        // ── Tab switching ──────────────────────────────────────────────────────
        function switchTab(btn, type) {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
            currentType = type;

            ['month', 'week', 'range'].forEach(t => {
                const el = document.getElementById('input-' + t);
                el.classList.toggle('show', t === type);
            });

            if (type === 'default') applyFilter();
        }

        // ── Apply filter ───────────────────────────────────────────────────────
        async function applyFilter() {
            const params = new URLSearchParams({ filter_type: currentType });
            let badgeText = '', subtitleText = '6 bulan terakhir';

            if (currentType === 'month') {
                const v = document.getElementById('monthPicker').value;
                if (!v) return;
                params.set('month', v);
                const d = new Date(v + '-01');
                const lbl = d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                badgeText = lbl; subtitleText = 'Per hari — ' + lbl;
            } else if (currentType === 'week') {
                const v = document.getElementById('weekPicker').value;
                if (!v) return;
                params.set('week', v.replace('W','').replace('-','-'));
                badgeText = 'Minggu ' + v; subtitleText = 'Per hari — ' + v;
            } else if (currentType === 'range') {
                const from = document.getElementById('dateFrom').value;
                const to   = document.getElementById('dateTo').value;
                if (!from || !to) return;
                if (from > to) { alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir.'); return; }
                params.set('date_from', from);
                params.set('date_to',   to);
                badgeText = from + ' → ' + to;
                subtitleText = from + ' s/d ' + to;
            }

            setLoading(true);

            try {
                const res  = await fetch(FILTER_URL + '?' + params.toString(), {
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                });
                const data = await res.json();

                chart.data.labels = data.chart.labels;
                chart.data.datasets[0].data = data.chart.counts;
                chart.update();

                document.getElementById('chartSubtitle').textContent = subtitleText;

                const total = Math.max(data.totalOrders, 1);
                data.statuses.forEach(s => {
                    const row = document.querySelector(`.status-row[data-status="${s.key}"]`);
                    if (!row) return;
                    row.querySelector('.status-bar').style.width = Math.round(s.count/total*100) + '%';
                    row.querySelector('.status-row-count').textContent = s.count;
                });

                const badge = document.getElementById('filterBadge');
                const resetBtn = document.getElementById('resetBtn');
                if (currentType !== 'default') {
                    badge.textContent = '● ' + badgeText;
                    badge.classList.add('show');
                    resetBtn.style.display = 'inline-block';
                } else {
                    badge.classList.remove('show');
                    resetBtn.style.display = 'none';
                }
            } catch (e) {
                console.error('Filter error:', e);
            } finally {
                setLoading(false);
            }
        }

        // ── Reset ─────────────────────────────────────────────────────────────
        function resetFilter() {
            currentType = 'default';
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            document.querySelector('[data-type="default"]').classList.add('active');
            ['month', 'week', 'range'].forEach(t => {
                document.getElementById('input-' + t).classList.remove('show');
            });
            document.getElementById('filterBadge').classList.remove('show');
            document.getElementById('resetBtn').style.display = 'none';
            applyFilter();
        }

        // ── Loader ────────────────────────────────────────────────────────────
        function setLoading(on) {
            document.getElementById('chartLoading').classList.toggle('visible', on);
            document.getElementById('statusLoading').classList.toggle('visible', on);
            document.getElementById('applyBtn').disabled = on;
        }

        // ── Date guard ────────────────────────────────────────────────────────
        document.getElementById('dateFrom').addEventListener('change', function () {
            document.getElementById('dateTo').min = this.value;
        });
    </script>
</x-app-sidebar>