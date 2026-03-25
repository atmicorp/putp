<x-app-sidebar>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="breadcrumb">
        <span class="current">Dashboard</span>
    </x-slot>

    <style>
        /* ── Base ── */
        .dash-title    { font-size: 22px; font-weight: 700; letter-spacing: -0.4px; color: #1c1917; }
        .dash-subtitle { font-size: 13px; color: #6b7280; margin-top: 4px; margin-bottom: 28px; }

        /* ── Top KPI Cards ── */
        .kpi-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }

        .kpi-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 20px 24px; position: relative; overflow: hidden;
        }
        .kpi-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 3px; background: #ea580c; border-radius: 3px 3px 0 0;
        }
        .kpi-card:nth-child(2)::before { background: #f59e0b; }
        .kpi-card:nth-child(3)::before { background: #3b82f6; }
        .kpi-card:nth-child(4)::before { background: #10b981; }

        .kpi-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; }
        .kpi-value { font-size: 30px; font-weight: 700; color: #1c1917; margin-top: 6px; line-height: 1; }
        .kpi-desc  { font-size: 12px; color: #9ca3af; margin-top: 6px; }

        .kpi-icon {
            position: absolute; right: 20px; top: 50%; transform: translateY(-50%);
            width: 40px; height: 40px; border-radius: 10px; display: flex;
            align-items: center; justify-content: center;
            background: #fff7ed;
        }
        .kpi-card:nth-child(2) .kpi-icon { background: #fffbeb; }
        .kpi-card:nth-child(3) .kpi-icon { background: #eff6ff; }
        .kpi-card:nth-child(4) .kpi-icon { background: #f0fdf4; }

        /* ── Filter Bar ── */
        .filter-bar {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            padding: 14px 20px; margin-bottom: 20px;
            display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
        }
        .filter-bar-label {
            font-size: 12px; font-weight: 600; color: #6b7280;
            text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;
        }
        .filter-tabs {
            display: flex; gap: 4px; background: #f3f4f6;
            border-radius: 8px; padding: 3px;
        }
        .filter-tab {
            padding: 5px 14px; border-radius: 6px; font-size: 12.5px; font-weight: 600;
            cursor: pointer; border: none; background: transparent; color: #6b7280;
            transition: all 0.15s; font-family: inherit;
        }
        .filter-tab.active {
            background: #fff; color: #ea580c;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .filter-inputs {
            display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
        }
        .filter-input {
            padding: 5px 10px; border: 1px solid #e5e7eb; border-radius: 7px;
            font-size: 12.5px; color: #374151; background: #fafafa;
            font-family: inherit; outline: none; transition: border-color 0.15s;
        }
        .filter-input:focus { border-color: #ea580c; background: #fff; }
        .filter-sep { font-size: 12px; color: #9ca3af; }

        .filter-apply-btn {
            padding: 5px 14px; border-radius: 7px; font-size: 12.5px; font-weight: 700;
            cursor: pointer; border: none; background: #ea580c; color: #fff;
            font-family: inherit; transition: background 0.15s; display: flex; align-items: center; gap: 5px;
        }
        .filter-apply-btn:hover { background: #c2410c; }
        .filter-apply-btn:disabled { opacity: 0.6; cursor: not-allowed; }

        .filter-reset-btn {
            padding: 5px 12px; border-radius: 7px; font-size: 12px; font-weight: 600;
            cursor: pointer; border: 1px solid #e5e7eb; background: #fff; color: #6b7280;
            font-family: inherit; transition: all 0.15s;
        }
        .filter-reset-btn:hover { border-color: #9ca3af; color: #374151; }

        /* ── Loading state ── */
        .chart-loading {
            display: none; position: absolute; inset: 0;
            background: rgba(255,255,255,0.75); border-radius: 12px;
            align-items: center; justify-content: center; z-index: 10;
        }
        .chart-loading.visible { display: flex; }
        .spinner {
            width: 24px; height: 24px; border: 3px solid #f3f4f6;
            border-top-color: #ea580c; border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Mid row ── */
        .mid-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 28px; }

        /* ── Chart / Section Cards ── */
        .section-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 12px;
            overflow: hidden; position: relative;
        }
        .section-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #f3f4f6;
        }
        .section-title { font-size: 13.5px; font-weight: 700; color: #1c1917; }
        .section-sub   { font-size: 12px; color: #9ca3af; margin-top: 2px; }
        .section-body  { padding: 20px; }

        /* ── Status badges ── */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge-draft         { background: #f3f4f6; color: #6b7280; }
        .badge-offered       { background: #eff6ff; color: #2563eb; }
        .badge-approved      { background: #f0fdf4; color: #16a34a; }
        .badge-rejected      { background: #fef2f2; color: #dc2626; }
        .badge-processing    { background: #fff7ed; color: #ea580c; }
        .badge-done          { background: #f0fdf4; color: #15803d; }
        .badge-submit        { background: #fefce8; color: #ca8a04; }

        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .dot-draft         { background: #9ca3af; }
        .dot-offered       { background: #3b82f6; }
        .dot-approved      { background: #16a34a; }
        .dot-rejected      { background: #dc2626; }
        .dot-processing    { background: #ea580c; }
        .dot-done          { background: #15803d; }
        .dot-submit        { background: #ca8a04; }

        /* ── Status distribution list ── */
        .status-list { display: flex; flex-direction: column; gap: 10px; }
        .status-row  { display: flex; align-items: center; gap: 10px; }
        .status-row-label { font-size: 12.5px; color: #374151; font-weight: 500; min-width: 110px; }
        .status-bar-wrap  { flex: 1; background: #f3f4f6; border-radius: 20px; height: 8px; overflow: hidden; }
        .status-bar       { height: 100%; border-radius: 20px; transition: width 0.6s ease; }
        .status-row-count { font-size: 12px; font-weight: 600; color: #6b7280; min-width: 28px; text-align: right; }

        /* ── Recent orders table ── */
        .table-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        .table-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #f3f4f6;
        }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 11px 20px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        tbody tr { border-bottom: 1px solid #f3f4f6; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff7ed; }
        td { padding: 14px 20px; font-size: 13.5px; vertical-align: middle; }

        .order-code    { font-weight: 700; font-size: 13px; color: #1c1917; font-family: monospace; letter-spacing: 0.3px; }
        .customer-name { font-weight: 600; font-size: 13.5px; color: #1c1917; }
        .customer-email{ font-size: 12px; color: #9ca3af; margin-top: 1px; }
        .date-text     { font-size: 12.5px; color: #6b7280; }

        .act-btn  {
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none;
            font-family: 'Sora', sans-serif; transition: all 0.15s;
        }
        .act-view       { background: #fff7ed; color: #ea580c; }
        .act-view:hover { background: #ffedd5; }

        .see-all-link { font-size: 12.5px; font-weight: 600; color: #ea580c; text-decoration: none; }
        .see-all-link:hover { text-decoration: underline; }

        /* ── Filter active badge ── */
        .filter-active-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px;
            background: #fff7ed; color: #ea580c;
            font-size: 11.5px; font-weight: 600; border: 1px solid #fed7aa;
        }

        #monthlyChart { width: 100% !important; }
    </style>

    <div class="dash-title">Dashboard</div>
    <p class="dash-subtitle">Welcome, {{ auth()->user()->name }} — {{ now()->format('l, d F Y') }}</p>

    {{-- KPI Cards --}}
    <div class="kpi-row">
        <div class="kpi-card">
            <div class="kpi-icon">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="kpi-label">Total Order</div>
            <div class="kpi-value">{{ $totalOrders }}</div>
            <div class="kpi-desc">Semua order</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="kpi-label">Active</div>
            <div class="kpi-value">{{ $activeOrders }}</div>
            <div class="kpi-desc">Sedang berjalan</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="kpi-label">Bulan Ini</div>
            <div class="kpi-value">{{ $newThisMonth }}</div>
            <div class="kpi-desc">Order baru {{ now()->format('M Y') }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#10b981" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="kpi-label">Done</div>
            <div class="kpi-value">{{ $doneOrders }}</div>
            <div class="kpi-desc">Selesai</div>
        </div>
    </div>

    {{-- ═══ FILTER BAR ═══ --}}
    <div class="filter-bar" id="filterBar">
        <span class="filter-bar-label">Filter:</span>

        {{-- Tabs --}}
        <div class="filter-tabs">
            <button class="filter-tab active" data-type="default" onclick="switchTab(this, 'default')">6 Bulan</button>
            <button class="filter-tab"        data-type="month"   onclick="switchTab(this, 'month')">Bulan</button>
            <button class="filter-tab"        data-type="week"    onclick="switchTab(this, 'week')">Minggu</button>
            <button class="filter-tab"        data-type="range"   onclick="switchTab(this, 'range')">Range</button>
        </div>

        {{-- Input: Month --}}
        <div class="filter-inputs" id="input-month" style="display:none">
            <input type="month" id="monthPicker" class="filter-input"
                   value="{{ now()->format('Y-m') }}" max="{{ now()->format('Y-m') }}">
        </div>

        {{-- Input: Week --}}
        <div class="filter-inputs" id="input-week" style="display:none">
            <input type="week" id="weekPicker" class="filter-input"
                   value="{{ now()->format('Y') }}-W{{ now()->format('W') }}">
        </div>

        {{-- Input: Range --}}
        <div class="filter-inputs" id="input-range" style="display:none">
            <input type="date" id="dateFrom" class="filter-input"
                   value="{{ now()->subDays(29)->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
            <span class="filter-sep">→</span>
            <input type="date" id="dateTo" class="filter-input"
                   value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
        </div>

        <button class="filter-apply-btn" id="applyBtn" onclick="applyFilter()">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>
            Terapkan
        </button>

        <button class="filter-reset-btn" id="resetBtn" style="display:none" onclick="resetFilter()">
            Reset
        </button>

        <span class="filter-active-badge" id="filterBadge" style="display:none"></span>
    </div>

    {{-- Mid Row: Chart + Status Distribution --}}
    <div class="mid-row">

        {{-- Monthly Chart --}}
        <div class="section-card">
            <div class="section-header">
                <div>
                    <div class="section-title">Order per Periode</div>
                    <div class="section-sub" id="chartSubtitle">6 bulan terakhir</div>
                </div>
            </div>
            <div class="section-body" style="position:relative">
                <div class="chart-loading" id="chartLoading">
                    <div class="spinner"></div>
                </div>
                <canvas id="monthlyChart" height="200"></canvas>
            </div>
        </div>

        {{-- Status Distribution --}}
        <div class="section-card">
            <div class="section-header">
                <div>
                    <div class="section-title">Status Order</div>
                    <div class="section-sub">Distribusi berdasarkan filter aktif</div>
                </div>
            </div>
            <div class="section-body" style="position:relative">
                <div class="chart-loading" id="statusLoading">
                    <div class="spinner"></div>
                </div>
                @php
                    $barColors = [
                        'draft'         => '#9ca3af',
                        'submit'        => '#ca8a04',
                        'offered'       => '#2563eb',
                        'rejected'      => '#dc2626',
                        'approved'      => '#059669',
                        'processing'    => '#7c3aed',
                        'done'          => '#16a34a',
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
                                     style="width: {{ round($cnt / $total * 100) }}%; background: {{ $barColors[$key] ?? '#9ca3af' }};"></div>
                            </div>
                            <span class="status-row-count">{{ $cnt }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Orders Table --}}
    <div class="table-card">
        <div class="table-toolbar">
            <div>
                <div style="font-size:13.5px; font-weight:700; color:#1c1917;">Order Terbaru</div>
                <div style="font-size:12px; color:#9ca3af; margin-top:2px;">8 order terakhir</div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="see-all-link">Lihat semua →</a>
        </div>

        @if($recentOrders->isEmpty())
            <div style="text-align:center; padding:48px 20px;">
                <div style="font-size:36px; margin-bottom:10px;">📋</div>
                <div style="font-size:14px; font-weight:600; color:#1c1917;">Belum ada order</div>
                <div style="font-size:12px; color:#9ca3af; margin-top:4px;">Order baru akan muncul di sini</div>
            </div>
        @else
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
                                <div class="customer-name">{{ $order->customer_name }}</div>
                                <div class="customer-email">{{ $order->customer_email }}</div>
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
        @endif
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        // ── Initial data from server ──────────────────────────────────────────
        const FILTER_URL    = '{{ route('admin.dashboard.filter') }}';
        const CSRF          = '{{ csrf_token() }}';
        const initialLabels = {!! $chartLabels !!};
        const initialCounts = {!! $chartCounts !!};

        // ── State ─────────────────────────────────────────────────────────────
        let currentType = 'default';

        // ── Chart setup ───────────────────────────────────────────────────────
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: initialLabels,
                datasets: [{
                    label: 'Order',
                    data: initialCounts,
                    backgroundColor: 'rgba(234,88,12,0.15)',
                    borderColor: '#ea580c',
                    borderWidth: 2,
                    borderRadius: 6,
                    hoverBackgroundColor: 'rgba(234,88,12,0.28)',
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
                        callbacks: { label: ctx => ` ${ctx.parsed.y} order` }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Sora, sans-serif', size: 11 }, color: '#9ca3af', maxRotation: 45 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            font: { family: 'Sora, sans-serif', size: 12 },
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
                document.getElementById('input-' + t).style.display = (t === type) ? 'flex' : 'none';
            });

            // Auto-apply for 'default' (no inputs)
            if (type === 'default') applyFilter();
        }

        // ── Apply filter ───────────────────────────────────────────────────────
        async function applyFilter() {
            const params = new URLSearchParams({ filter_type: currentType });
            let badgeText = '6 bulan terakhir';
            let subtitleText = '6 bulan terakhir';

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
                params.set('week', v.replace('W', '').replace('-', '-'));
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

            // Show loaders
            setLoading(true);

            try {
                const res  = await fetch(FILTER_URL + '?' + params.toString(), {
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                });
                const data = await res.json();

                // Update chart
                chart.data.labels   = data.chart.labels;
                chart.data.datasets[0].data = data.chart.counts;
                chart.update();

                // Update subtitle
                document.getElementById('chartSubtitle').textContent = subtitleText;

                // Update status bars
                const total = Math.max(data.totalOrders, 1);
                data.statuses.forEach(s => {
                    const row   = document.querySelector(`.status-row[data-status="${s.key}"]`);
                    if (!row) return;
                    const bar   = row.querySelector('.status-bar');
                    const count = row.querySelector('.status-row-count');
                    const pct   = Math.round(s.count / total * 100);
                    bar.style.width = pct + '%';
                    count.textContent = s.count;
                });

                // Show badge + reset
                if (currentType !== 'default') {
                    document.getElementById('filterBadge').textContent  = '● ' + badgeText;
                    document.getElementById('filterBadge').style.display = 'inline-flex';
                    document.getElementById('resetBtn').style.display    = 'inline-block';
                } else {
                    document.getElementById('filterBadge').style.display = 'none';
                    document.getElementById('resetBtn').style.display    = 'none';
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
                document.getElementById('input-' + t).style.display = 'none';
            });
            document.getElementById('filterBadge').style.display = 'none';
            document.getElementById('resetBtn').style.display    = 'none';
            applyFilter();
        }

        // ── Loader helper ──────────────────────────────────────────────────────
        function setLoading(on) {
            document.getElementById('chartLoading').classList.toggle('visible', on);
            document.getElementById('statusLoading').classList.toggle('visible', on);
            document.getElementById('applyBtn').disabled = on;
        }

        // ── Date-from guard ────────────────────────────────────────────────────
        document.getElementById('dateFrom').addEventListener('change', function () {
            document.getElementById('dateTo').min = this.value;
        });
    </script>
</x-app-sidebar>