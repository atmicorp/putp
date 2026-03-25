<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Order — PUTP Politeknik ATMI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('logopoltek.png') }}">
    <style>
        :root {
            --navy:    #1A0F00;
            --navy-2:  #231400;
            --teal:    #EA580C;
            --teal-l:  #FB923C;
            --gold:    #FED7AA;
            --cream:   #FFF7ED;
            --muted:   #A8A29E;
            --white:   #FFFFFF;
            --slate:   #64748B;
            --border:  #E2E8F0;
            --surface: #F8FAFC;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--navy);
            min-height: 100vh;
        }

        /* ── NAV ── */
        nav {
            background: var(--navy);
            padding: 16px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,.07);
            position: sticky;
            top: 0;
            z-index: 200;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-logo {
            width: 38px; height: 38px;
            background: var(--teal);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'DM Serif Display', serif;
            font-size: 12px; color: white; font-weight: 700;
            flex-shrink: 0;
        }

        .nav-name { display: flex; flex-direction: column; }
        .nav-title { font-size: 13px; font-weight: 600; color: white; letter-spacing: .5px; }
        .nav-sub   { font-size: 11px; color: var(--muted); }

        .nav-right {
            display: flex; align-items: center; gap: 10px;
        }

        .nav-chip {
            display: flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 13px; color: rgba(255,255,255,.7);
            text-decoration: none;
            transition: all .2s;
        }
        .nav-chip:hover { background: rgba(255,255,255,.13); color: white; }

        /* ── SHELL ── */
        .shell {
            max-width: 960px;
            margin: 0 auto;
            padding: 48px 24px 80px;
        }

        /* ── PAGE HEADER ── */
        .page-head {
            margin-bottom: 36px;
        }

        .page-eyebrow {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--teal);
            margin-bottom: 10px;
            display: flex; align-items: center; gap: 8px;
        }

        .page-eyebrow::before {
            content: '';
            display: inline-block;
            width: 20px; height: 2px;
            background: var(--teal);
            border-radius: 2px;
        }

        .page-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(28px, 4vw, 42px);
            color: var(--navy);
            line-height: 1.1;
            margin-bottom: 10px;
        }

        .page-desc {
            font-size: 15px;
            color: var(--slate);
            line-height: 1.65;
            max-width: 500px;
        }

        /* ── TOKEN CARD ── */
        .token-card {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 32px;
            box-shadow: 0 4px 24px rgba(26,15,0,.06);
        }

        .token-card-header {
            padding: 22px 28px 18px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex; align-items: center; gap: 14px;
        }

        .token-icon {
            width: 44px; height: 44px;
            background: rgba(234,88,12,.1);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .token-header-text h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
            color: var(--navy);
            margin-bottom: 2px;
        }

        .token-header-text p {
            font-size: 13px;
            color: var(--slate);
        }

        .token-card-body { padding: 26px 28px; }

        .token-row {
            display: flex;
            gap: 10px;
            align-items: stretch;
        }

        .token-input-wrap {
            flex: 1;
            position: relative;
        }

        .token-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
        }

        .token-input {
            width: 100%;
            padding: 13px 16px 13px 42px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--navy);
            background: white;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            letter-spacing: .5px;
        }

        .token-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(234,88,12,.1);
        }

        .token-input.error {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,.1);
        }

        .btn-lookup {
            display: flex; align-items: center; gap: 8px;
            padding: 13px 24px;
            background: var(--teal);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-lookup:hover {
            background: var(--teal-l);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(234,88,12,.3);
        }

        .token-help {
            font-size: 12px;
            color: var(--muted);
            margin-top: 10px;
            display: flex; align-items: center; gap: 6px;
        }

        .error-msg {
            font-size: 12px;
            color: #EF4444;
            margin-top: 8px;
            display: flex; align-items: center; gap: 6px;
        }

        /* ── RESULT AREA ── */
        @isset($order)
        /* shown when order exists */
        @endisset

        .result-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        /* ── INFO CARD ── */
        .info-card {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(26,15,0,.05);
        }

        .info-card-header {
            padding: 18px 22px 14px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex; align-items: center; justify-content: space-between;
        }

        .info-card-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--muted);
        }

        .info-card-body { padding: 20px 22px; }

        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field-item {}

        .field-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--muted);
            margin-bottom: 5px;
        }

        .field-val {
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
        }

        /* ── STATUS PILLS ── */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .status-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
        }

        .status-pill.draft      { background: rgba(168,162,158,.15); color: #78716C; }
        .status-pill.draft      .status-dot { background: #78716C; }
        .status-pill.submit     { background: rgba(59,130,246,.12); color: #3B82F6; }
        .status-pill.submit     .status-dot { background: #3B82F6; }
        .status-pill.offered    { background: rgba(14,165,233,.12); color: #0EA5E9; }
        .status-pill.offered    .status-dot { background: #0EA5E9; }
        .status-pill.form_required { background: rgba(245,158,11,.12); color: #D97706; }
        .status-pill.form_required .status-dot { background: #F59E0B; animation: blink 1.5s infinite; }
        .status-pill.approved   { background: rgba(16,185,129,.12); color: #059669; }
        .status-pill.approved   .status-dot { background: #10B981; }
        .status-pill.rejected   { background: rgba(239,68,68,.1);  color: #DC2626; }
        .status-pill.rejected   .status-dot { background: #EF4444; }
        .status-pill.processing { background: rgba(234,88,12,.12); color: #C2410C; }
        .status-pill.processing .status-dot { background: var(--teal); animation: blink 1s infinite; }
        .status-pill.done       { background: rgba(16,185,129,.15); color: #065F46; }
        .status-pill.done       .status-dot { background: #10B981; }

        @keyframes blink {
            0%,100% { opacity:1; } 50% { opacity: .3; }
        }

        /* ── ITEMS TABLE ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th {
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--muted);
            border-bottom: 1.5px solid var(--border);
        }

        .items-table td {
            padding: 10px 10px;
            font-size: 13px;
            color: var(--navy);
            border-bottom: 1px solid var(--surface);
            font-weight: 500;
        }

        .items-table tr:last-child td { border-bottom: none; }

        .items-table .text-right { text-align: right; }

        .items-empty {
            font-size: 13px;
            color: var(--muted);
            padding: 16px 0;
            font-style: italic;
        }

        /* ── TIMELINE ── */
        .timeline-card {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(26,15,0,.05);
            margin-bottom: 20px;
        }

        .timeline-card-header {
            padding: 18px 28px 14px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex; align-items: center; gap: 10px;
        }

        .timeline-card-title {
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
            color: var(--navy);
        }

        .timeline-card-body {
            padding: 32px 28px;
        }

        .timeline {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        /* Vertical connector line */
        .timeline::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 20px;
            bottom: 20px;
            width: 2px;
            background: var(--border);
            z-index: 0;
        }

        .tl-step {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding-bottom: 28px;
        }

        .tl-step:last-child { padding-bottom: 0; }

        /* Progress fill line */
        .tl-step.done::after,
        .tl-step.active::after {
            content: '';
            position: absolute;
            left: 19px;
            top: 20px;
            bottom: -8px;
            width: 2px;
            z-index: 0;
        }

        .tl-step.done::after {
            background: #10B981;
        }

        .tl-step.active::after {
            background: linear-gradient(to bottom, var(--teal), transparent);
        }

        .tl-step:last-child::after { display: none; }

        .tl-node {
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
            transition: all .3s;
            border: 2px solid var(--border);
            background: white;
        }

        .tl-step.done   .tl-node { background: #10B981; border-color: #10B981; color: white; }
        .tl-step.active .tl-node { background: var(--teal); border-color: var(--teal); color: white; box-shadow: 0 0 0 6px rgba(234,88,12,.15); }
        .tl-step.pending .tl-node { background: white; border-color: var(--border); color: var(--muted); }
        .tl-step.rejected-node .tl-node { background: #EF4444; border-color: #EF4444; color: white; }

        .tl-content {
            flex: 1;
            padding-top: 8px;
        }

        .tl-label {
            font-size: 15px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 3px;
            line-height: 1.3;
        }

        .tl-step.pending .tl-label { color: var(--muted); }

        .tl-desc {
            font-size: 12px;
            color: var(--slate);
            line-height: 1.5;
        }

        .tl-step.pending .tl-desc { color: var(--border); }

        .tl-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 6px;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
        }

        .tl-badge.current {
            background: rgba(234,88,12,.1);
            color: var(--teal);
            border: 1px solid rgba(234,88,12,.25);
        }

        .tl-badge.done-badge {
            background: rgba(16,185,129,.1);
            color: #059669;
            border: 1px solid rgba(16,185,129,.25);
        }

        .tl-badge.rejected-badge {
            background: rgba(239,68,68,.1);
            color: #DC2626;
            border: 1px solid rgba(239,68,68,.25);
        }

        /* ── EMPTY ITEMS STATE ── */
        .empty-items {
            text-align: center;
            padding: 24px 16px;
            color: var(--muted);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            nav { padding: 14px 20px; }
            .shell { padding: 32px 16px 60px; }
            .result-grid { grid-template-columns: 1fr; }
            .fields-grid { grid-template-columns: 1fr 1fr; }
            .token-row { flex-direction: column; }
            .btn-lookup { justify-content: center; }
        }

        @media (max-width: 480px) {
            .fields-grid { grid-template-columns: 1fr; }
            .timeline-card-body { padding: 24px 20px; }
        }
    </style>
</head>
<body>

{{-- ── NAV ── --}}
<nav>
    <a href="/" class="nav-brand">
        <div class="nav-logo">PUTP</div>
        <div class="nav-name">
            <span class="nav-title">Politeknik ATMI</span>
            <span class="nav-sub">Surakarta</span>
        </div>
    </a>
    <div class="nav-right">
        <a href="{{ route('welcome') }}" class="nav-chip">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><path d="M12 5l-7 7 7 7"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</nav>

{{-- ── SHELL ── --}}
<div class="shell">

    {{-- Page Header --}}
    <div class="page-head">
        <div class="page-eyebrow">Status Order</div>
        <h1 class="page-title">Lacak Progres<br><em style="font-style:italic;color:var(--teal)">Order Anda</em></h1>
        <p class="page-desc">Masukkan kode akses yang dikirimkan oleh tim PUTP untuk melihat status dan progres terbaru pengujian Anda.</p>
    </div>

    {{-- Token Form --}}
    <div class="token-card">
        <div class="token-card-header">
            <div class="token-icon">🔑</div>
            <div class="token-header-text">
                <h2>Kode Akses Order</h2>
                <p>Masukkan access token yang Anda terima dari PUTP</p>
            </div>
        </div>
        <div class="token-card-body">
            <form action="{{ route('orders.guest.status.lookup') }}" method="POST">
                @csrf
                <div class="token-row">
                    <div class="token-input-wrap">
                        <svg class="token-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input
                            type="text"
                            name="token"
                            class="token-input {{ $errors->has('token') ? 'error' : '' }}"
                            value="{{ old('token', $token ?? '') }}"
                            placeholder="Tempel kode akses di sini..."
                            autocomplete="off"
                            spellcheck="false"
                        >
                    </div>
                    <button type="submit" class="btn-lookup">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        Cek Status
                    </button>
                </div>
                @error('token')
                    <div class="error-msg">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </div>
                @enderror
                <div class="token-help">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    Kode akses bersifat rahasia dan hanya dibagikan oleh tim PUTP kepada customer.
                </div>
            </form>
        </div>
    </div>

    {{-- Result Area --}}
    @isset($order)
    @php
        $statusLabel = [
            'draft'         => 'Draft',
            'submit'        => 'Diajukan',
            'offered'       => 'Penawaran Dikirim',
            'form_required' => 'Form Diperlukan',
            'approved'      => 'Disetujui',
            'rejected'      => 'Ditolak',
            'processing'    => 'Sedang Diproses',
            'done'          => 'Selesai',
        ];

        $allSteps = [
            ['key' => 'submit',        'label' => 'Order Diajukan',          'desc' => 'Permintaan pengujian berhasil masuk ke sistem PUTP.'],
            ['key' => 'offered',       'label' => 'Penawaran Dikirim',       'desc' => 'Tim PUTP menyusun dan mengirimkan penawaran harga.'],
            ['key' => 'form_required', 'label' => 'Kelengkapan Form',        'desc' => 'Dokumen atau form tambahan diperlukan dari customer.'],
            ['key' => 'approved',      'label' => 'Disetujui',               'desc' => 'Order telah disetujui dan siap masuk antrian pengujian.'],
            ['key' => 'processing',    'label' => 'Sedang Diproses',         'desc' => 'Sampel sedang dalam proses pengujian di laboratorium.'],
            ['key' => 'done',          'label' => 'Selesai',                 'desc' => 'Pengujian selesai. Laporan hasil siap diserahkan.'],
        ];

        $statusOrder = ['draft','submit','offered','form_required','approved','processing','done'];
        $currentIdx  = array_search($order->status, $statusOrder);
        $isRejected  = $order->status === 'rejected';
    @endphp

    {{-- Info Grid --}}
    <div class="result-grid">

        {{-- Ringkasan Order --}}
        <div class="info-card">
            <div class="info-card-header">
                <span class="info-card-title">Ringkasan Order</span>
                @php $lbl = $statusLabel[$order->status] ?? ucfirst($order->status); @endphp
                <div class="status-pill {{ $order->status }}">
                    <span class="status-dot"></span>
                    {{ $lbl }}
                </div>
            </div>
            <div class="info-card-body">
                <div class="fields-grid">
                    <div class="field-item">
                        <div class="field-label">Kode Order</div>
                        <div class="field-val" style="font-family:monospace;font-size:13px;letter-spacing:.5px;">{{ $order->order_code }}</div>
                    </div>
                    <div class="field-item">
                        <div class="field-label">Tanggal</div>
                        <div class="field-val">{{ $order->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="field-item">
                        <div class="field-label">Customer</div>
                        <div class="field-val">{{ $order->customer_name }}</div>
                    </div>
                    <div class="field-item">
                        <div class="field-label">Email</div>
                        <div class="field-val" style="font-size:12px;font-weight:500;color:var(--slate);">{{ $order->customer_email ?: '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Item Layanan --}}
        <div class="info-card">
            <div class="info-card-header">
                <span class="info-card-title">Item Layanan</span>
                @if($order->offer && $order->offer->details->count())
                    <span style="font-size:12px;color:var(--teal);font-weight:600;">
                        {{ $order->offer->details->count() }} paket
                    </span>
                @endif
            </div>
            <div class="info-card-body" style="padding:14px 22px 0;">
                @if($order->offer && $order->offer->details->count())
                    @php
                        $grandTotal = $order->offer->details->sum(fn($d) => $d->price * $d->qty);
                    @endphp
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Paket Layanan</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->offer->details as $detail)
                                <tr>
                                    <td>{{ $detail->package?->name ?? 'Paket dihapus' }}</td>
                                    <td class="text-right">{{ $detail->qty }}</td>
                                    <td class="text-right" style="white-space:nowrap;color:var(--slate);">
                                        Rp {{ number_format($detail->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right" style="white-space:nowrap;font-weight:600;">
                                        Rp {{ number_format($detail->price * $detail->qty, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Total --}}
                    <div style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        padding:14px 10px 18px;
                        border-top:1.5px dashed var(--border);
                        margin-top:4px;
                    ">
                        <div style="display:flex;align-items:center;gap:6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                            <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);">Total Estimasi</span>
                        </div>
                        <div style="
                            font-family:'DM Serif Display',serif;
                            font-size:18px;
                            color:var(--teal);
                            letter-spacing:-.5px;
                        ">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </div>
                    </div>
                @else
                    <div class="empty-items" style="padding-bottom:20px;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 10px;display:block;opacity:.3"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                        <p style="font-size:13px;color:var(--muted);font-style:italic;">Belum ada item penawaran.<br>Masih dalam tahap penyusunan oleh admin.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Timeline Progress --}}
    <div class="timeline-card">
        <div class="timeline-card-header">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l3 3"/></svg>
            <span class="timeline-card-title">Progres Order</span>
        </div>
        <div class="timeline-card-body">

            @if($isRejected)
            {{-- Rejected special layout --}}
            <div class="timeline">
                {{-- Steps up to current before rejection --}}
                @foreach($allSteps as $i => $step)
                    @php
                        $stepIdx = array_search($step['key'], $statusOrder);
                        $state   = 'pending';
                        if ($stepIdx !== false && $stepIdx < $currentIdx) $state = 'done';
                    @endphp
                    @if($state === 'done')
                    <div class="tl-step done">
                        <div class="tl-node">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div class="tl-content">
                            <div class="tl-label">{{ $step['label'] }}</div>
                            <div class="tl-desc">{{ $step['desc'] }}</div>
                        </div>
                    </div>
                    @endif
                @endforeach

                {{-- Rejected node --}}
                <div class="tl-step rejected-node">
                    <div class="tl-node">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </div>
                    <div class="tl-content">
                        <div class="tl-label">Order Ditolak</div>
                        <div class="tl-desc">Order ini tidak dapat diproses lebih lanjut. Silakan hubungi tim PUTP untuk informasi lebih lanjut.</div>
                        <div class="tl-badge rejected-badge">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            Ditolak
                        </div>
                    </div>
                </div>
            </div>

            @else
            {{-- Normal progress --}}
            <div class="timeline">
                @foreach($allSteps as $i => $step)
                    @php
                        $stepIdx  = array_search($step['key'], $statusOrder);
                        $curIdx   = $currentIdx;

                        if ($stepIdx === false) { $state = 'pending'; }
                        elseif ($stepIdx < $curIdx) { $state = 'done'; }
                        elseif ($stepIdx === $curIdx) { $state = 'active'; }
                        else { $state = 'pending'; }
                    @endphp

                    <div class="tl-step {{ $state }}">
                        <div class="tl-node">
                            @if($state === 'done')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            @elseif($state === 'active')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>
                            @else
                                <span style="font-size:12px;font-weight:700;color:var(--border);">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            @endif
                        </div>
                        <div class="tl-content">
                            <div class="tl-label">{{ $step['label'] }}</div>
                            <div class="tl-desc">{{ $step['desc'] }}</div>
                            @if($state === 'active')
                                <div class="tl-badge current">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l3 3"/></svg>
                                    Posisi saat ini
                                </div>
                            @elseif($state === 'done')
                                <div class="tl-badge done-badge">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Selesai
                                </div>
                            @endif
                        </div>
                    </div>

                @endforeach
            </div>
            @endif

        </div>
    </div>

    {{-- CTA Hubungi --}}
    <div style="text-align:center;margin-top:8px;padding:24px;background:white;border:1.5px solid var(--border);border-radius:16px;">
        <p style="font-size:13px;color:var(--slate);margin-bottom:14px;">Ada pertanyaan mengenai order Anda? Tim kami siap membantu.</p>
        <a href="https://wa.me/6285802543185?text={{ urlencode('Halo PUTP, saya ingin menanyakan status order ' . $order->order_code) }}"
           target="_blank"
           style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;background:var(--teal);color:white;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;transition:all .2s;"
           onmouseover="this.style.background='var(--teal-l)'"
           onmouseout="this.style.background='var(--teal)'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Chat WhatsApp
        </a>
    </div>

    @endisset

</div>

</body>
</html>