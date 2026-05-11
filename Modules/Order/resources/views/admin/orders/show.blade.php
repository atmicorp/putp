<x-app-sidebar>
   <x-slot name="title">Order</x-slot>

    <x-slot name="breadcrumb">
        <span>Order</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.orders.index') }}" style="color:#ea580c;text-decoration:none;">Order List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">{{ $order->order_code }}</span>
    </x-slot>

    <style>
        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; }

        /* ── Alerts ── */
        .alert {
            padding: 12px 16px; border-radius: 10px; font-size: 13px;
            margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
            font-weight: 500;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* ── Back Link ── */
        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; color: #6b7280; text-decoration: none;
            margin-bottom: 20px; font-weight: 500; transition: color 0.15s;
            padding: 6px 0;
        }
        .back-link:hover { color: #ea580c; }

        /* ── Layout ── */
        .detail-layout {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .detail-main { width: 100%; }
        .detail-sidebar { width: 100%; }

        @media (min-width: 960px) {
            .detail-layout {
                display: grid;
                grid-template-columns: 1fr 340px;
                gap: 20px;
                align-items: start;
            }
            .detail-sidebar {
                position: sticky;
                top: 20px;
            }
        }

        /* ── Cards ── */
        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 14px;
        }
        .card:last-child { margin-bottom: 0; }

        .card-header {
            padding: 14px 18px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .card-header-left { display: flex; align-items: center; gap: 10px; }
        .card-icon {
            width: 34px; height: 34px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            background: #fff7ed; flex-shrink: 0;
        }
        .card-title    { font-size: 13.5px; font-weight: 700; color: #1c1917; }
        .card-subtitle { font-size: 11.5px; color: #9ca3af; margin-top: 1px; }
        .card-body     { padding: 18px; }

        /* ── Order Hero ── */
        .order-hero {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }
        .order-code-big {
            font-size: 22px; font-weight: 800; color: #1c1917;
            letter-spacing: -0.5px; font-family: monospace;
            word-break: break-all;
        }
        .order-meta { font-size: 12px; color: #9ca3af; margin-top: 4px; line-height: 1.5; }

        @media (max-width: 480px) {
            .order-code-big { font-size: 19px; }
        }

        /* ── Badges ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700;
            white-space: nowrap; flex-shrink: 0;
        }
        .badge-draft        { background: #f3f4f6; color: #6b7280; }
        .badge-offered      { background: #eff6ff; color: #2563eb; }
        .badge-approved     { background: #f0fdf4; color: #16a34a; }
        .badge-rejected     { background: #fef2f2; color: #dc2626; }
        .badge-processing   { background: #fff7ed; color: #ea580c; }
        .badge-done         { background: #f0fdf4; color: #15803d; }
        .badge-form_required{ background: #fefce8; color: #ca8a04; }
        .dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
        .dot-draft        { background: #9ca3af; }
        .dot-offered      { background: #3b82f6; }
        .dot-approved     { background: #16a34a; }
        .dot-rejected     { background: #dc2626; }
        .dot-processing   { background: #ea580c; }
        .dot-done         { background: #15803d; }
        .dot-form_required{ background: #ca8a04; }

        /* ── Info Grid ── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 540px) {
            .info-grid { grid-template-columns: 1fr; gap: 14px; }
        }
        .info-label {
            font-size: 10.5px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.5px; color: #9ca3af; margin-bottom: 4px;
        }
        .info-val { font-size: 13.5px; font-weight: 600; color: #1c1917; }
        .info-sub { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }

        /* ── Inline Edit ── */
        .edit-display {
            display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
        }
        .edit-form {
            display: none; margin-top: 6px;
            display: none; flex-wrap: wrap; gap: 6px; align-items: center;
        }

        /* ── Items Table ── */
        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .items-table { width: 100%; border-collapse: collapse; min-width: 520px; }
        .items-table th {
            padding: 10px 14px; text-align: left; font-size: 10.5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6; white-space: nowrap;
        }
        .items-table td { padding: 12px 14px; border-bottom: 1px solid #f9fafb; font-size: 13px; }
        .items-table tr:last-child td { border-bottom: none; }
        .items-table tbody tr:hover { background: #fffbf7; }
        .pkg-name { font-weight: 600; color: #1c1917; }
        .pkg-info { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }
        .text-right { text-align: right; }
        .price-cell { font-weight: 600; color: #1c1917; }

        /* Mobile card style for items */
        @media (max-width: 600px) {
            .items-table th { padding: 8px 12px; font-size: 10px; }
            .items-table td { padding: 10px 12px; }
        }

        /* ── Total Section ── */
        .total-section { padding: 14px 18px; border-top: 2px solid #f3f4f6; }
        .total-line {
            display: flex; justify-content: space-between; align-items: center;
            padding: 4px 0; font-size: 13px; color: #6b7280;
        }
        .total-line.grand {
            font-size: 15px; font-weight: 700; color: #1c1917;
            padding-top: 10px; border-top: 1px solid #f3f4f6; margin-top: 6px;
        }
        .total-line.grand .val { color: #ea580c; }

        /* ── Notes ── */
        .notes-block {
            background: #fafafa; border: 1px solid #f3f4f6; border-radius: 8px;
            padding: 12px 14px; font-size: 13px; color: #374151;
            line-height: 1.6; white-space: pre-wrap;
        }

        /* ── Doc Tabs ── */
        .doc-tabs {
            display: flex;
            border-bottom: 1px solid #f0ede9;
            padding: 0 12px;
            gap: 2px;
            overflow-x: auto;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }
        .doc-tabs::-webkit-scrollbar { display: none; }
        .doc-tab {
            display: flex; align-items: center; gap: 5px;
            padding: 10px 12px; border: none; background: transparent;
            font-size: 12px; font-weight: 500; color: #9ca3af;
            cursor: pointer; border-bottom: 2px solid transparent;
            margin-bottom: -1px; white-space: nowrap; transition: color 0.15s;
        }
        .doc-tab:hover { color: #374151; }
        .doc-tab.active { color: #ea580c; border-bottom-color: #ea580c; }

        /* ── Doc Panel ── */
        .doc-panel { padding: 16px; }
        .doc-panel-inner {
            display: flex; align-items: center; gap: 14px;
            background: #fafaf9; border: 1px solid #f0ede9;
            border-radius: 10px; padding: 14px 16px;
            flex-wrap: wrap;
        }
        .doc-icon-wrap {
            flex-shrink: 0; width: 46px; height: 46px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .doc-icon-blue   { background: #eff6ff; }
        .doc-icon-orange { background: #fff7ed; }
        .doc-icon-purple { background: #f5f3ff; }
        .doc-icon-green  { background: #f0fdf4; }
        .doc-icon-teal   { background: #f0fdfa; }
        .doc-panel-text { flex: 1; min-width: 0; }
        .doc-panel-title { font-size: 13.5px; font-weight: 600; color: #1c1917; margin-bottom: 3px; }
        .doc-panel-desc  { font-size: 12px; color: #78716c; line-height: 1.5; }

        .btn-open-pdf {
            flex-shrink: 0; display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 14px; background: #1c1917; color: #fff; border-radius: 7px;
            font-size: 12.5px; font-weight: 500; text-decoration: none;
            transition: background 0.15s; white-space: nowrap;
        }
        .btn-open-pdf:hover { background: #374151; }
        .btn-open-pdf--disabled {
            background: #e5e7eb !important; color: #9ca3af !important;
            cursor: not-allowed; pointer-events: none;
        }

        @media (max-width: 500px) {
            .doc-panel-inner { flex-direction: column; align-items: flex-start; gap: 12px; }
            .btn-open-pdf { width: 100%; justify-content: center; }
            .doc-icon-wrap { width: 40px; height: 40px; }
        }

        /* ── Sidebar Cards ── */
        .sidebar-card {
            background: #fff; border: 1px solid #e5e7eb;
            border-radius: 14px; overflow: hidden; margin-bottom: 12px;
        }
        .sidebar-card:last-child { margin-bottom: 0; }
        .sidebar-card-header {
            padding: 13px 16px; border-bottom: 1px solid #f3f4f6;
            font-size: 13px; font-weight: 700; color: #1c1917;
            display: flex; align-items: center; gap: 8px;
        }
        .sidebar-card-body { padding: 16px; }

        /* ── Sidebar Grid (mobile: 2 cols for small cards) ── */
        .sidebar-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }
        @media (min-width: 540px) and (max-width: 959px) {
            .sidebar-grid {
                grid-template-columns: 1fr 1fr;
            }
            .sidebar-grid .sidebar-card-full { grid-column: span 2; }
        }

        /* ── Buttons ── */
        .btn-copy {
            width: 100%; padding: 10px; background: #fff; color: #1c1917;
            border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: all 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            margin-bottom: 8px; min-height: 44px;
        }
        .btn-copy:hover { border-color: #ea580c; color: #ea580c; }
        .btn-copy.copied { background: #f0fdf4; border-color: #bbf7d0; color: #16a34a; }

        .btn-send {
            width: 100%; padding: 12px; background: #ea580c; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 700;
            cursor: pointer; transition: all 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            min-height: 44px;
        }
        .btn-send:hover { background: #c2410c; box-shadow: 0 4px 14px rgba(234,88,12,0.3); }
        .btn-send:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-open {
            width: 100%; padding: 9px; background: #fff; color: #374151;
            border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 12.5px; font-weight: 600;
            cursor: pointer; transition: all 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            text-decoration: none; margin-top: 8px; min-height: 40px;
        }
        .btn-open:hover { border-color: #6b7280; }

        .btn-edit-sm {
            padding: 3px 10px; font-size: 11.5px; font-weight: 500;
            border: 1px solid #d1d5db; background: #fff; color: #374151;
            border-radius: 6px; cursor: pointer; transition: all 0.15s;
            white-space: nowrap; min-height: 28px;
        }
        .btn-edit-sm:hover { border-color: #ea580c; color: #ea580c; }

        .btn-save-sm {
            padding: 5px 12px; font-size: 12px; font-weight: 600;
            border: none; background: #ea580c; color: #fff;
            border-radius: 6px; cursor: pointer; min-height: 32px;
        }
        .btn-cancel-sm {
            padding: 5px 10px; font-size: 12px; font-weight: 500;
            border: 1px solid #d1d5db; background: #fff; color: #6b7280;
            border-radius: 6px; cursor: pointer; min-height: 32px;
        }

        /* ── Link & Token Box ── */
        .link-box {
            background: #fafafa; border: 1px solid #e5e7eb; border-radius: 8px;
            padding: 10px 12px; font-size: 11.5px; color: #6b7280;
            word-break: break-all; line-height: 1.5; margin-bottom: 10px;
            font-family: monospace;
        }
        .token-box {
            background: #1c1917; border-radius: 8px; padding: 10px 12px;
            font-family: monospace; font-size: 10.5px; color: #fbbf24;
            word-break: break-all; letter-spacing: 0.5px; margin-bottom: 10px;
        }

        /* ── Sent Info ── */
        .sent-info {
            font-size: 12px; color: #6b7280; text-align: center;
            margin-top: 8px; display: flex; align-items: center; justify-content: center; gap: 5px;
        }

        /* ── Timeline ── */
        .timeline { }
        .tl-item { display: flex; gap: 12px; margin-bottom: 14px; }
        .tl-item:last-child { margin-bottom: 0; }
        .tl-dot {
            width: 8px; height: 8px; border-radius: 50%; background: #e5e7eb;
            flex-shrink: 0; margin-top: 4px;
        }
        .tl-dot.active { background: #ea580c; }
        .tl-key { font-size: 12px; font-weight: 600; color: #374151; }
        .tl-val { font-size: 11.5px; color: #9ca3af; margin-top: 1px; }

        /* ── Sent Badge ── */
        .sent-badge {
            display: flex; align-items: center; gap: 6px;
            background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px;
            padding: 10px 12px; font-size: 12.5px; color: #1d4ed8; margin-bottom: 12px;
        }

        /* ── Status badge - not available ── */
        .status-note {
            font-size: 12.5px; color: #6b7280; text-align: center; padding: 8px 0;
        }

        /* ── Divider ── */
        .divider { border: none; border-top: 1px solid #f3f4f6; margin: 14px 0; }

        /* ── Mobile sidebar order ── */
        @media (max-width: 959px) {
            .detail-sidebar { margin-top: 0; }
            /* Show sidebar between hero and main on mobile — handled by DOM order */
        }

        /* ── input form ── */
        .form-control-sm {
            padding: 6px 10px; border: 1px solid #d1d5db; border-radius: 6px;
            font-size: 13px; outline: none; transition: border-color 0.15s;
            min-height: 36px;
        }
        .form-control-sm:focus { border-color: #ea580c; }

        /* ── Responsive table scroll hint ── */
        .scroll-hint {
            display: none;
            font-size: 11px; color: #9ca3af; text-align: right;
            padding: 4px 16px 0; align-items: center; gap: 4px; justify-content: flex-end;
        }
        @media (max-width: 640px) { .scroll-hint { display: flex; } }
    </style>

    {{-- Back --}}
    <a href="{{ route('admin.orders.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Order List
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="detail-layout">

        {{-- ═══════════════ LEFT / MAIN ═══════════════ --}}
        <div class="detail-main">

            {{-- ── Order Summary ── --}}
            <div class="card">
                <div class="card-body">

                    {{-- Hero --}}
                    <div class="order-hero">
                        <div>
                            <div class="order-code-big">{{ $order->order_code }}</div>
                            <div class="order-meta">
                                Dibuat {{ $order->created_at->format('d M Y, H:i') }}<br>
                                PIC: {{ $order->pic->name ?? '-' }}
                            </div>
                        </div>
                        <span class="badge badge-{{ $order->status }}">
                            <span class="dot dot-{{ $order->status }}"></span>
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>

                    {{-- Info Grid --}}
                    <div class="info-grid">
                        <div>
                            <div class="info-label">Nama Perusahaan</div>
                            <div class="info-val">{{ $order->company->name }}</div>
                        </div>
                        <div>
                            <div class="info-label">Nama Kontak</div>
                            <div class="info-val">{{ $order->contact->name }}</div>
                        </div>
                        <div>
                            <div class="info-label">Email Kontak</div>
                            <div class="info-val" style="font-size:13px;word-break:break-all;">{{ $order->contact->email }}</div>
                        </div>
                        @if($order->sent_at)
                        <div>
                            <div class="info-label">Terkirim pada</div>
                            <div class="info-val">{{ $order->sent_at->format('d M Y, H:i') }}</div>
                            <div class="info-sub">Email penawaran dikirim</div>
                        </div>
                        @endif
                        <div>
                            <div class="info-label">Access Token</div>
                            <div class="info-val" style="font-size:11px;font-family:monospace;color:#6b7280;word-break:break-all;">
                                {{ Str::limit($order->access_token, 24) }}
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Tujuan Pengujian</div>
                            <div class="info-val" style="font-size:13px;">{{ $order->tujuan_pengujian ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="info-label">Waktu yang Diharapkan</div>
                            <div class="info-val" style="font-size:13px;">
                                {{ $order->waktu_diharapkan
                                    ? \Carbon\Carbon::parse($order->waktu_diharapkan)->translatedFormat('l - d F Y')
                                    : '-' }}
                            </div>
                        </div>

                        {{-- Waktu Pelaksanaan --}}
                        <div>
                            <div class="info-label">Waktu Pelaksanaan</div>

                            <div id="waktu-display" class="edit-display">
                                <span id="waktu-text" class="info-val" style="font-size:13px;">
                                    {{ $order->waktu_pelaksanaan
                                        ? \Carbon\Carbon::parse($order->waktu_pelaksanaan)->translatedFormat('l - d F Y')
                                        : '-' }}
                                </span>

                                <button
                                    type="button"
                                    class="btn-edit-sm"
                                    onclick="toggleEdit('waktu')">
                                    Edit
                                </button>
                            </div>

                            <div
                                id="waktu-form"
                                style="display:none; margin-top:8px; flex-wrap:wrap; gap:6px; align-items:center;">

                                <input
                                    type="date"
                                    id="waktu-input"
                                    class="form-control-sm"
                                    value="{{ $order->waktu_pelaksanaan
                                        ? \Carbon\Carbon::parse($order->waktu_pelaksanaan)->format('Y-m-d')
                                        : '' }}">

                                <button
                                    type="button"
                                    class="btn-save-sm"
                                    onclick="saveField('waktu')">
                                    Simpan
                                </button>

                                <button
                                    type="button"
                                    class="btn-cancel-sm"
                                    onclick="cancelEdit('waktu')">
                                    Batal
                                </button>
                            </div>
                        </div>

                        {{-- Lokasi Pelaksanaan --}}
                        <div>
                            <div class="info-label">Lokasi Pelaksanaan</div>

                            <div id="lokasi-display" class="edit-display">
                                <span id="lokasi-text" class="info-val" style="font-size:13px;">
                                    {{ $order->lokasi_pelaksanaan ?? '-' }}
                                </span>

                                <button
                                    type="button"
                                    class="btn-edit-sm"
                                    onclick="event.preventDefault(); toggleEdit('lokasi')">
                                    Edit
                                </button>
                            </div>

                            <div
                                id="lokasi-form"
                                style="display:none; margin-top:8px; flex-wrap:wrap; gap:6px; align-items:center;">

                                <input
                                    type="text"
                                    id="lokasi-input"
                                    class="form-control-sm"
                                    placeholder="Masukkan lokasi..."
                                    value="{{ $order->lokasi_pelaksanaan ?? '' }}">

                                <button
                                    type="button"
                                    class="btn-save-sm"
                                    onclick="event.preventDefault(); saveField('lokasi')">
                                    Simpan
                                </button>

                                <button
                                    type="button"
                                    class="btn-cancel-sm"
                                    onclick="event.preventDefault(); cancelEdit('lokasi')">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Offer Items ── --}}
            @if($order->offer && $order->offer->details->count())
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">
                                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <div class="card-title">Item Penawaran</div>
                                <div class="card-subtitle">{{ $order->offer->details->count() }} paket dipilih</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn-open" style="margin:0;width:auto;font-size:12px;padding:7px 12px;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/>
                            </svg>
                            Edit Harga
                        </a>
                    </div>

                    <div class="scroll-hint">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        Geser untuk lihat selengkapnya
                    </div>

                    <div class="table-wrap">
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Paket</th>
                                    <th>Qty</th>
                                    <th class="text-right">Harga Satuan</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-right">Nama Mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach($order->offer->details as $detail)
                                    @php $sub = $detail->qty * $detail->price; $grandTotal += $sub; @endphp
                                    <tr>
                                        <td>
                                            <div class="pkg-name">{{ $detail->package?->name ?? 'Paket dihapus' }}</div>
                                            @if($detail->package?->machine)
                                                <div class="pkg-info">Mesin: {{ $detail->package->machine->name }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $detail->qty }}</td>
                                        <td class="price-cell">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                        <td class="price-cell">Rp {{ number_format($sub, 0, ',', '.') }}</td>
                                        <td class="price-cell">{{ $detail->nama_mahasiswa ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="total-section">
                        <div class="total-line grand">
                            <span>Total</span>
                            <span class="val">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body" style="text-align:center;padding:36px 20px;color:#9ca3af;font-size:13px;">
                        <div style="font-size:30px;margin-bottom:10px;">📭</div>
                        <div style="font-weight:600;color:#374151;">Belum ada item penawaran</div>
                        <div style="margin-top:4px;">Order ini belum memiliki penawaran.</div>
                    </div>
                </div>
            @endif

            {{-- ── Document Tabs ── --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon">
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-title">Dokumen</div>
                            <div class="card-subtitle">Lembar resmi order</div>
                        </div>
                    </div>
                </div>

                <div class="doc-tabs">
                    <button type="button" class="doc-tab active" onclick="switchDocTab('permintaan')">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        PKS
                    </button>
                    <button type="button" class="doc-tab" onclick="switchDocTab('perjanjian')">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Perjanjian
                    </button>
                    <button type="button" class="doc-tab" onclick="switchDocTab('kesanggupan')">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Kesanggupan
                    </button>
                    <button type="button" class="doc-tab" onclick="switchDocTab('bap')">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M15 11l-3 3-1.5-1.5"/>
                        </svg>
                        BAP
                    </button>
                    <button type="button" class="doc-tab" onclick="switchDocTab('laporan')">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M15 11l-3 3-1.5-1.5"/>
                        </svg>
                        Laporan
                    </button>
                </div>

                {{-- Panel: PKS --}}
                <div id="docPanelPermintaan" class="doc-panel">
                    <div class="doc-panel-inner">
                        <div class="doc-icon-wrap doc-icon-blue">
                            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="doc-panel-text">
                            <div class="doc-panel-title">Surat Permohonan Kerjasama (PKS)</div>
                            <div class="doc-panel-desc">Dokumen permohonan untuk order <strong>{{ $order->order_code }}</strong>.</div>
                        </div>
                        @php $canOpen = $order->canOpenPermohonanPdf(); @endphp
                        @if ($canOpen)
                            <a href="{{ route('orders.guest.permohonan_kerjasama', [$order->company->slug, $order->access_token]) }}" target="_blank" class="btn-open-pdf">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Buka PDF
                            </a>
                        @else
                            <span class="btn-open-pdf btn-open-pdf--disabled">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Belum Tersedia
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Panel: Perjanjian --}}
                <div id="docPanelPerjanjian" class="doc-panel" style="display:none;">
                    <div class="doc-panel-inner">
                        <div class="doc-icon-wrap doc-icon-orange">
                            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="doc-panel-text">
                            <div class="doc-panel-title">Perjanjian Kerjasama</div>
                            @php
                                $canOpen = $order->canOpenMouKesanggupanPdf();
                                $reason = null;
                                if ($order->status !== \App\Models\Order::STATUS_APPROVED)       $reason = 'Menunggu approval';
                                elseif (blank($order->waktu_pelaksanaan))                         $reason = 'Waktu pelaksanaan belum diisi';
                                elseif (blank($order->lokasi_pelaksanaan))                        $reason = 'Lokasi pelaksanaan belum diisi';
                                elseif (!$order->offer || $order->offer->details->isEmpty())      $reason = 'Detail penawaran belum tersedia';
                            @endphp
                            <div class="doc-panel-desc" id="perjanjian-desc">
                                @if(!$canOpen && $reason)
                                    <span style="color:#ea580c;">⚠ {{ $reason }}</span>
                                @else
                                    Dokumen perjanjian resmi untuk order <strong>{{ $order->order_code }}</strong>.
                                @endif
                            </div>
                        </div>
                        <div class="doc-panel-action" id="perjanjian-action">

                            @if ($canOpen)
                                <a
                                    href="{{ route('orders.guest.perjanjian_kerjasama', [$order->company->slug, $order->access_token]) }}"
                                    target="_blank"
                                    class="btn-open-pdf">

                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>

                                    Buka PDF
                                </a>
                            @else
                                <span
                                    class="btn-open-pdf btn-open-pdf--disabled"
                                    title="{{ $reason }}">

                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>

                                    Belum Tersedia
                                </span>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- Panel: Kesanggupan --}}
                <div id="docPanelKesanggupan" class="doc-panel" style="display:none;">
                    <div class="doc-panel-inner">
                        <div class="doc-icon-wrap doc-icon-purple">
                            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#7c3aed" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="doc-panel-text">
                            <div class="doc-panel-title">Surat Kesanggupan Kerjasama</div>
                            @php
                                $canOpen = $order->canOpenMouKesanggupanPdf();
                                $reason = null;
                                if ($order->status !== \App\Models\Order::STATUS_APPROVED)       $reason = 'Menunggu approval';
                                elseif (blank($order->waktu_pelaksanaan))                         $reason = 'Waktu pelaksanaan belum diisi';
                                elseif (blank($order->lokasi_pelaksanaan))                        $reason = 'Lokasi pelaksanaan belum diisi';
                                elseif (!$order->offer || $order->offer->details->isEmpty())      $reason = 'Detail penawaran belum tersedia';
                            @endphp
                            <div class="doc-panel-desc" id="kesanggupan-desc">
                                @if(!$canOpen && $reason)
                                    <span style="color:#ea580c;">⚠ {{ $reason }}</span>
                                @else
                                    Dokumen kesanggupan pelaksanaan untuk order <strong>{{ $order->order_code }}</strong>.
                                @endif
                            </div>
                        </div>
                        <div class="doc-panel-action" id="kesanggupan-action">

                            @if ($canOpen)
                                <a
                                    href="{{ route('orders.guest.kesanggupan_kerjasama', [$order->company->slug, $order->access_token]) }}"
                                    target="_blank"
                                    class="btn-open-pdf">

                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>

                                    Buka PDF
                                </a>
                            @else
                                <span
                                    class="btn-open-pdf btn-open-pdf--disabled"
                                    title="{{ $reason }}">

                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>

                                    Belum Tersedia
                                </span>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- Panel: BAP --}}
                <div id="docPanelBap" class="doc-panel" style="display:none;">
                    <div class="doc-panel-inner">
                        <div class="doc-icon-wrap doc-icon-green">
                            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M15 11l-3 3-1.5-1.5"/>
                            </svg>
                        </div>
                        <div class="doc-panel-text">
                            <div class="doc-panel-title">Berita Acara Penyelesaian</div>
                            <div class="doc-panel-desc">Bukti penyelesaian pekerjaan untuk order <strong>{{ $order->order_code }}</strong>.</div>
                        </div>
                        @php $canOpen = $order->canOpenBapPdf(); @endphp
                        @if ($canOpen)
                            <a href="{{ route('orders.guest.bap', [$order->company->slug, $order->access_token]) }}" target="_blank" class="btn-open-pdf">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Buka PDF
                            </a>
                        @else
                            <span class="btn-open-pdf btn-open-pdf--disabled">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Belum Tersedia
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Panel: Laporan --}}
                <div id="docPanelLaporan" class="doc-panel" style="display:none;">
                    <div class="doc-panel-inner">
                        <div class="doc-icon-wrap doc-icon-teal">
                            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#0d9488" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M15 11l-3 3-1.5-1.5"/>
                            </svg>
                        </div>
                        <div class="doc-panel-text">
                            <div class="doc-panel-title">Laporan Kegiatan Kerjasama</div>
                            <div class="doc-panel-desc">Laporan hasil kegiatan untuk order <strong>{{ $order->order_code }}</strong>.</div>
                        </div>
                        @php $canOpen = $order->canOpenLaporanKegiatanPdf(); @endphp
                        @if ($canOpen)
                            <a href="{{ route('orders.guest.laporan_kegiatan', [$order->company->slug, $order->access_token]) }}" target="_blank" class="btn-open-pdf">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Buka PDF
                            </a>
                        @else
                            <span class="btn-open-pdf btn-open-pdf--disabled">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Belum Tersedia
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Notes & Terms ── --}}
            @if($order->offer && ($order->offer->notes || $order->offer->terms))
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">
                                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="card-title">Catatan & Syarat</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($order->offer->notes)
                            <div style="margin-bottom:14px;">
                                <div class="info-label" style="margin-bottom:8px;">Catatan</div>
                                <div class="notes-block">{{ $order->offer->notes }}</div>
                            </div>
                        @endif
                        @if($order->offer->terms)
                            <div>
                                <div class="info-label" style="margin-bottom:8px;">Syarat & Ketentuan</div>
                                <div class="notes-block">{{ $order->offer->terms }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>{{-- end .detail-main --}}


        {{-- ═══════════════ RIGHT / SIDEBAR ═══════════════ --}}
        <div class="detail-sidebar">
            <div class="sidebar-grid">

                {{-- Notifikasi Internal --}}
                <div class="sidebar-card sidebar-card-full">
                    <div class="sidebar-card-header">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        Notifikasi Internal
                    </div>
                    <div class="sidebar-card-body">
                        <p style="font-size:12px;color:#6b7280;line-height:1.6;margin:0 0 12px;">
                            Kirim notifikasi ke user internal untuk memproses order ini.
                        </p>
                        <form id="notifyInternalForm" action="{{ route('admin.orders.notifyInternal', $order) }}" method="POST">
                            @csrf
                            <button type="button" class="btn-send"
                                style="background:#111827;"
                                onmouseover="this.style.background='#000'"
                                onmouseout="this.style.background='#111827'"
                                onclick="confirmNotifyInternal()">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13"/><path stroke-linecap="round" stroke-linejoin="round" d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                                Kirim Notifikasi
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Kirim Penawaran --}}
                <div class="sidebar-card sidebar-card-full">
                    <div class="sidebar-card-header">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Kirim Penawaran
                    </div>
                    <div class="sidebar-card-body">
                        @if($order->status === 'submit')
                            <p style="font-size:12px;color:#6b7280;line-height:1.6;margin:0 0 12px;">
                                Kirim ke <strong style="color:#1c1917;">{{ $order->customer_email }}</strong>
                            </p>
                            <form id="sendOfferForm" action="{{ route('admin.orders.sendOffer', $order) }}" method="POST">
                                @csrf
                                <button type="button" class="btn-send" onclick="confirmSendOffer()">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Kirim Email Penawaran
                                </button>
                            </form>
                        @elseif($order->status === 'offered')
                            <div class="sent-badge">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Email berhasil dikirim
                            </div>
                            <form id="sendOfferForm" action="{{ route('admin.orders.sendOffer', $order) }}" method="POST">
                                @csrf
                                <button type="button" class="btn-send" style="background:#3b82f6;"
                                    onmouseover="this.style.background='#1d4ed8'"
                                    onmouseout="this.style.background='#3b82f6'"
                                    onclick="confirmResendOffer()">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Kirim Ulang
                                </button>
                            </form>
                            @if($order->sent_at)
                                <div class="sent-info">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    Terkirim {{ $order->sent_at->diffForHumans() }}
                                </div>
                            @endif
                        @else
                            <div class="status-note">
                                Status <strong>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</strong><br>
                                <span style="font-size:11.5px;">Tidak bisa kirim ulang.</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Link Customer --}}
                <div class="sidebar-card sidebar-card-full">
                    <div class="sidebar-card-header">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Link Customer
                    </div>
                    <div class="sidebar-card-body">
                        <div style="font-size:11px;color:#9ca3af;margin-bottom:6px;font-weight:600;letter-spacing:0.3px;">URL PENAWARAN</div>
                        <div class="link-box" id="guestLinkBox">{{ $guestLink }}</div>
                        <button type="button" class="btn-copy" id="copyLinkBtn" onclick="copyLink()">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                            <span id="copyLinkText">Salin Link</span>
                        </button>
                        <a href="{{ $guestLink }}" target="_blank" class="btn-open">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Buka di Tab Baru
                        </a>
                    </div>
                </div>

                {{-- Access Token --}}
                <div class="sidebar-card sidebar-card-full">
                    <div class="sidebar-card-header">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        Access Token
                    </div>
                    <div class="sidebar-card-body">
                        <div class="token-box">{{ $order->access_token }}</div>
                        <button type="button" class="btn-copy" id="copyTokenBtn" onclick="copyToken()">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                            <span id="copyTokenText">Salin Token</span>
                        </button>
                        <p style="font-size:11px;color:#9ca3af;margin:8px 0 0;line-height:1.5;">
                            Token autentikasi akses customer tanpa login.
                        </p>
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="sidebar-card sidebar-card-full">
                    <div class="sidebar-card-header">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Timeline
                    </div>
                    <div class="sidebar-card-body">
                        <div class="timeline">
                            <div class="tl-item">
                                <div class="tl-dot active"></div>
                                <div>
                                    <div class="tl-key">Order dibuat</div>
                                    <div class="tl-val">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-dot {{ $order->sent_at ? 'active' : '' }}"></div>
                                <div>
                                    <div class="tl-key">Penawaran dikirim</div>
                                    <div class="tl-val">{{ $order->sent_at ? $order->sent_at->format('d M Y, H:i') : 'Menunggu...' }}</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-dot {{ in_array($order->status, ['approved','processing','done']) ? 'active' : '' }}"></div>
                                <div>
                                    <div class="tl-key">Disetujui customer</div>
                                    <div class="tl-val">{{ in_array($order->status, ['approved','processing','done']) ? 'Selesai' : 'Menunggu...' }}</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-dot {{ $order->status === 'done' ? 'active' : '' }}"></div>
                                <div>
                                    <div class="tl-key">Done</div>
                                    <div class="tl-val">{{ $order->status === 'done' ? 'Selesai' : 'Menunggu...' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- end .sidebar-grid --}}
        </div>{{-- end .detail-sidebar --}}

    </div>{{-- end .detail-layout --}}


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmNotifyInternal() {
            Swal.fire({
                title: 'Kirim Notifikasi?',
                text: 'Kirim notifikasi internal untuk order {{ $order->order_code }}?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#111827',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('notifyInternalForm').submit();
                }
            });
        }

        function confirmSendOffer() {
            Swal.fire({
                title: 'Kirim Penawaran?',
                text: 'Kirim email penawaran ke {{ $order->contact->email }}?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#EA580C',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('sendOfferForm').submit();
                }
            });
        }

        function confirmResendOffer() {
            Swal.fire({
                title: 'Kirim Ulang?',
                text: 'Email penawaran akan dikirim ulang ke {{ $order->contact->email }}.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Kirim Ulang!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('sendOfferForm').submit();
                }
            });
        }
    </script>

    <script>
        function copyLink() {
            const link = document.getElementById('guestLinkBox').textContent.trim();
            navigator.clipboard.writeText(link).then(() => {
                const btn = document.getElementById('copyLinkBtn');
                const txt = document.getElementById('copyLinkText');
                btn.classList.add('copied');
                txt.textContent = 'Tersalin!';
                setTimeout(() => { btn.classList.remove('copied'); txt.textContent = 'Salin Link'; }, 2000);
            });
        }

        function copyToken() {
            const token = @json($order->access_token);
            navigator.clipboard.writeText(token).then(() => {
                const btn = document.getElementById('copyTokenBtn');
                const txt = document.getElementById('copyTokenText');
                btn.classList.add('copied');
                txt.textContent = 'Tersalin!';
                setTimeout(() => { btn.classList.remove('copied'); txt.textContent = 'Salin Token'; }, 2000);
            });
        }

        function switchDocTab(tab) {
            const panels = {
                permintaan: 'docPanelPermintaan',
                perjanjian: 'docPanelPerjanjian',
                kesanggupan: 'docPanelKesanggupan',
                bap: 'docPanelBap',
                laporan: 'docPanelLaporan',
            };

            Object.values(panels).forEach(id => {
                document.getElementById(id).style.display = 'none';
            });

            document.getElementById(panels[tab]).style.display = 'block';

            document.querySelectorAll('.doc-tab').forEach(btn => btn.classList.remove('active'));
            event.currentTarget.classList.add('active');
        }
    </script>


    <script>
        const perjanjianPdfUrl =
            "{{ route('orders.guest.perjanjian_kerjasama', [$order->company->slug, $order->access_token]) }}";

        const kesanggupanPdfUrl =
            "{{ route('orders.guest.kesanggupan_kerjasama', [$order->company->slug, $order->access_token]) }}";
    </script>


    {{-- edit waktu dan lokasi pelaksanaan --}}
    <script>
        const updateUrl = "{{ route('orders.update-execution', $order) }}";
        const csrfToken = "{{ csrf_token() }}";

        function toggleEdit(field) {
            document.getElementById(field + '-display').style.display = 'none';
            document.getElementById(field + '-form').style.display = 'flex';

            const input = document.getElementById(field + '-input');

            if (input) {
                input.focus();
            }
        }

        function cancelEdit(field) {
            document.getElementById(field + '-display').style.display = 'flex';
            document.getElementById(field + '-form').style.display = 'none';
        }

        async function saveField(field) {

            window.event?.preventDefault();

            const input = document.getElementById(field + '-input').value;

            const body = {};

            if (field === 'waktu') {
                body.waktu_pelaksanaan = input || null;
            }

            if (field === 'lokasi') {
                body.lokasi_pelaksanaan = input || null;
            }

            try {

                const res = await fetch(updateUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(body),
                });

                if (!res.ok) {
                    console.error(await res.text());
                    throw new Error('Request gagal');
                }

                const data = await res.json();

                console.log('updated:', data);

                if (data.success) {

                    if (field === 'waktu') {
                        document.getElementById('waktu-text').textContent =
                            data.waktu_pelaksanaan;
                    }

                    if (field === 'lokasi') {
                        document.getElementById('lokasi-text').textContent =
                            data.lokasi_pelaksanaan;
                    }

                    if (data.can_open_pdf) {

                        console.log('OPEN PDF ENABLED');

                        const perjanjianDesc =
                            document.getElementById('perjanjian-desc');

                        if (perjanjianDesc) {

                            perjanjianDesc.innerHTML =
                                `Dokumen perjanjian resmi untuk order <strong>{{ $order->order_code }}</strong>.`;
                        }

                        const kesanggupanDesc =
                            document.getElementById('kesanggupan-desc');

                        if (kesanggupanDesc) {

                            kesanggupanDesc.innerHTML =
                                `Dokumen kesanggupan pelaksanaan untuk order <strong>{{ $order->order_code }}</strong>.`;
                        }

                        // =========================
                        // PERJANJIAN
                        // =========================

                        const perjanjianAction =
                            document.getElementById('perjanjian-action');

                        if (perjanjianAction) {

                            perjanjianAction.innerHTML = `
                                <a
                                    href="${perjanjianPdfUrl}"
                                    target="_blank"
                                    class="btn-open-pdf">
                                    Buka PDF
                                </a>
                            `;
                        }

                        // =========================
                        // KESANGGUPAN
                        // =========================

                        const kesanggupanAction =
                            document.getElementById('kesanggupan-action');

                        if (kesanggupanAction) {

                            kesanggupanAction.innerHTML = `
                                <a
                                    href="${kesanggupanPdfUrl}"
                                    target="_blank"
                                    class="btn-open-pdf">
                                    Buka PDF
                                </a>
                            `;
                        }
                    }

                    cancelEdit(field);
                }

            } catch (e) {

                console.error('ERROR SAVE FIELD:', e);

                alert(e.message);
            }
        }
    </script>
</x-app-sidebar>