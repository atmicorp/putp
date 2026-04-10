<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penawaran {{ $order->order_code }} — {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('logopoltek.png') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --orange: #ea580c;
            --orange-light: #fff7ed;
            --orange-border: #fed7aa;
            --dark: #1c1917;
            --mid: #44403c;
            --muted: #78716c;
            --faint: #a8a29e;
            --line: #e7e5e4;
            --bg: #fafaf9;
            --white: #ffffff;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--dark);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* ── TOP BAR ── */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--line);
            padding: 0 24px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand { display: flex; align-items: center; gap: 10px; }

        .brand-mark {
            width: 32px; height: 32px;
            background: var(--orange);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }

        .brand-name { font-size: 15px; font-weight: 700; color: var(--dark); letter-spacing: -0.3px; }
        .topbar-right { font-size: 12px; color: var(--faint); }

        /* ── HERO STRIP ── */
        .hero-strip { background: var(--white); border-bottom: 1px solid var(--line); padding: 32px 24px 28px; }
        .hero-inner { max-width: 760px; margin: 0 auto; }
        .hero-eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--orange); margin-bottom: 10px; }
        .hero-title { font-size: 26px; font-weight: 800; color: var(--dark); letter-spacing: -0.6px; line-height: 1.2; margin-bottom: 8px; }
        .hero-sub { font-size: 13.5px; color: var(--muted); line-height: 1.6; }
        .hero-meta { display: flex; align-items: center; gap: 20px; margin-top: 20px; flex-wrap: wrap; }
        .meta-chip { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--muted); }
        .meta-chip svg { flex-shrink: 0; }

        .status-chip { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 11.5px; font-weight: 700; }
        .status-draft      { background: #f5f5f4; color: #78716c; }
        .status-offered    { background: #eff6ff; color: #2563eb; }
        .status-approved   { background: #f0fdf4; color: #16a34a; }
        .status-rejected   { background: #fef2f2; color: #dc2626; }
        .status-processing { background: #fff7ed; color: #ea580c; }
        .status-done       { background: #f0fdf4; color: #15803d; }
        .status-form_required { background: #fefce8; color: #ca8a04; }

        .sdot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .sdot-draft      { background: #a8a29e; }
        .sdot-offered    { background: #3b82f6; }
        .sdot-approved   { background: #16a34a; }
        .sdot-rejected   { background: #dc2626; }
        .sdot-processing { background: #ea580c; }
        .sdot-done       { background: #15803d; }
        .sdot-form_required { background: #ca8a04; }

        /* ── MAIN LAYOUT ── */
        .main { max-width: 760px; margin: 0 auto; padding: 32px 24px 80px; }
        .sec-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--faint); margin-bottom: 14px; }

        /* ── CARD ── */
        .card { background: var(--white); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; margin-bottom: 20px; }
        .card:last-child { margin-bottom: 0; }

        /* ── ITEMS TABLE ── */
        .offer-table { width: 100%; border-collapse: collapse; }
        .offer-table thead th { padding: 11px 20px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--faint); background: #fafaf9; border-bottom: 1px solid var(--line); }
        .offer-table th.r, .offer-table td.r { text-align: right; }
        .offer-table tbody tr { border-bottom: 1px solid #f5f5f4; transition: background 0.1s; }
        .offer-table tbody tr:last-child { border-bottom: none; }
        .offer-table tbody tr:hover { background: #fffbf7; }
        .offer-table td { padding: 16px 20px; vertical-align: middle; }

        .pkg-num { width: 26px; height: 26px; border-radius: 6px; background: var(--orange-light); color: var(--orange); font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .pkg-name { font-size: 14px; font-weight: 600; color: var(--dark); }
        .pkg-info { font-size: 12px; color: var(--faint); margin-top: 3px; }
        .qty-badge { display: inline-block; padding: 3px 10px; background: #f5f5f4; border-radius: 6px; font-size: 13px; font-weight: 600; color: var(--mid); }
        .price-cell { font-size: 14px; font-weight: 600; color: var(--dark); }
        .sub-cell   { font-size: 14px; font-weight: 700; color: var(--dark); }

        /* ── TOTALS ── */
        .totals { padding: 0 20px 20px; border-top: 2px dashed #f0ede9; margin-top: 0; }
        .total-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f5f5f4; font-size: 13.5px; }
        .total-row:last-child { border-bottom: none; }
        .total-row .lbl { color: var(--muted); }
        .total-row .val { font-weight: 600; color: var(--dark); }
        .total-row.grand { padding-top: 16px; }
        .total-row.grand .lbl { font-size: 15px; font-weight: 700; color: var(--dark); }
        .total-row.grand .val { font-size: 22px; font-weight: 800; color: var(--orange); }

        /* ── NOTES ── */
        .notes-body { padding: 20px; }
        .notes-block { background: #fafaf9; border: 1px solid var(--line); border-radius: 8px; padding: 14px 16px; font-size: 13.5px; color: var(--mid); line-height: 1.7; white-space: pre-wrap; }
        .notes-block + .notes-block { margin-top: 16px; }
        .notes-sub-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--faint); margin-bottom: 8px; }

        /* ── ACTION BAR ── */
        .action-bar {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-top: 1px solid var(--line);
            padding: 16px 24px;
            z-index: 100;
        }
        .action-inner { max-width: 760px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .action-info { font-size: 13px; color: var(--muted); }
        .action-info strong { color: var(--dark); font-weight: 700; }
        .action-btns { display: flex; gap: 10px; }

        .btn-reject {
            padding: 11px 22px; border: 1.5px solid var(--line); border-radius: 9px;
            background: var(--white); font-size: 13.5px; font-weight: 600; color: var(--mid);
            cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 7px;
        }
        .btn-reject:hover { border-color: #fca5a5; color: #dc2626; background: #fef2f2; }

        .btn-approve {
            padding: 11px 28px; border: none; border-radius: 9px;
            background: var(--orange); font-size: 13.5px; font-weight: 700; color: #fff;
            cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s;
            display: inline-flex; align-items: center; gap: 7px; text-decoration: none;
        }
        .btn-approve:hover { background: #c2410c; box-shadow: 0 6px 18px rgba(234,88,12,0.3); transform: translateY(-1px); }

        /* ── RESPONDED BANNER ── */
        .responded-banner { border-radius: 12px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
        .responded-banner.approved { background: #f0fdf4; border: 1px solid #bbf7d0; }
        .responded-banner.rejected { background: #fef2f2; border: 1px solid #fecaca; }
        .responded-icon { font-size: 28px; flex-shrink: 0; }
        .responded-title { font-size: 14px; font-weight: 700; }
        .responded-sub   { font-size: 13px; margin-top: 3px; opacity: 0.75; }
        .responded-banner.approved .responded-title { color: #15803d; }
        .responded-banner.rejected .responded-title { color: #dc2626; }
        .responded-banner.approved .responded-sub   { color: #166534; }
        .responded-banner.rejected .responded-sub   { color: #991b1b; }

        /* ── MODAL BASE ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(28,25,23,0.5);
            backdrop-filter: blur(4px);
            z-index: 200;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-overlay.open { display: flex; }

        .modal {
            background: var(--white);
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            padding: 28px;
            animation: popIn 0.2s ease;
        }

        /* ── SIGNATURE MODAL wider ── */
        .modal.modal-signature { max-width: 560px; }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.95) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
        .modal-icon.approve { background: #f0fdf4; }
        .modal-icon.reject  { background: #fef2f2; }
        .modal-icon.sign    { background: #eff6ff; }

        .modal-title { font-size: 17px; font-weight: 800; color: var(--dark); margin-bottom: 8px; letter-spacing: -0.3px; }
        .modal-desc  { font-size: 13.5px; color: var(--muted); line-height: 1.6; margin-bottom: 22px; }

        .modal-actions { display: flex; gap: 10px; }

        .modal-cancel { flex: 1; padding: 11px; border: 1.5px solid var(--line); border-radius: 8px; background: var(--white); font-size: 13.5px; font-weight: 600; color: var(--mid); cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s; }
        .modal-cancel:hover { border-color: #d6d3d1; }

        .modal-confirm-approve { flex: 2; padding: 11px; border: none; border-radius: 8px; background: var(--orange); font-size: 13.5px; font-weight: 700; color: #fff; cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s; }
        .modal-confirm-approve:hover { background: #c2410c; }

        .modal-confirm-reject { flex: 2; padding: 11px; border: none; border-radius: 8px; background: #dc2626; font-size: 13.5px; font-weight: 700; color: #fff; cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s; }
        .modal-confirm-reject:hover { background: #b91c1c; }

        /* ── SIGNATURE PAD ── */
        .sig-pad-wrap {
            position: relative;
            border: 2px dashed var(--orange-border);
            border-radius: 10px;
            background: #fffbf7;
            overflow: hidden;
            margin-bottom: 12px;
            cursor: crosshair;
        }
        .sig-pad-wrap canvas {
            display: block;
            width: 100%;
            height: 220px;
            touch-action: none;
        }
        .sig-pad-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        .sig-pad-placeholder svg { opacity: 0.3; }
        .sig-pad-placeholder span { font-size: 12px; color: var(--faint); font-weight: 500; }

        .sig-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        /* ── Signature Tabs ── */
        .sig-tabs {
            display: flex;
            gap: 4px;
            background: #f5f5f4;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 14px;
        }

        .sig-tab {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border: none;
            background: transparent;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            color: #78716c;
            cursor: pointer;
            transition: background 0.18s, color 0.18s, box-shadow 0.18s;
        }

        .sig-tab.active {
            background: #fff;
            color: #1c1917;
            box-shadow: 0 1px 4px rgba(0,0,0,0.10);
        }

        .sig-tab:hover:not(.active) {
            color: #44403c;
            background: #ece9e6;
        }

        /* ── Upload Area ── */
        .sig-upload-area {
            border: 2px dashed #d6d3d1;
            border-radius: 10px;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.18s, background 0.18s;
            padding: 20px;
            background: #fafaf9;
            margin-bottom: 8px;
        }

        .sig-upload-area:hover,
        .sig-upload-area.drag-over {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .sig-upload-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-align: center;
            pointer-events: none;
        }

        .sig-upload-placeholder span {
            font-size: 14px;
            color: #78716c;
            font-weight: 500;
        }

        .sig-upload-placeholder small {
            font-size: 12px;
            color: #a8a29e;
        }
        .btn-clear-sig {
            font-size: 12px; font-weight: 600; color: var(--muted);
            background: none; border: 1.5px solid var(--line);
            border-radius: 6px; padding: 5px 12px;
            cursor: pointer; font-family: 'Sora', sans-serif;
            transition: all 0.15s; display: flex; align-items: center; gap: 5px;
        }
        .btn-clear-sig:hover { border-color: #d6d3d1; color: var(--dark); }

        .modal-confirm-sign {
            flex: 2; padding: 11px; border: none; border-radius: 8px;
            background: var(--orange); font-size: 13.5px; font-weight: 700;
            color: #fff; cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s;
        }
        .modal-confirm-sign:hover { background: #c2410c; }
        .modal-confirm-sign:disabled { background: #d6d3d1; cursor: not-allowed; }

        /* ── FOOTER ── */
        .page-footer { text-align: center; padding: 16px 24px 32px; font-size: 12px; color: var(--faint); }

        @media (max-width: 600px) {
            .hero-title { font-size: 20px; }
            .action-inner { flex-direction: column; align-items: stretch; }
            .action-btns { justify-content: stretch; }
            .btn-reject, .btn-approve { flex: 1; justify-content: center; }
            .offer-table thead { display: none; }
            .offer-table td { display: block; padding: 8px 16px; }
            .offer-table td:first-child { padding-top: 14px; }
            .offer-table td:last-child  { padding-bottom: 14px; }
            .offer-table td.r { text-align: left; }
            .modal.modal-signature { max-width: 100%; }
        }
    </style>
</head>
<body>

    {{-- TOP BAR --}}
    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5h6m-6 4h6m-6 4h6M7 3h10a2 2 0 012 2v16l-4-2-4 2-4-2-4 2V5a2 2 0 012-2z"/>
                </svg>
            </div>
            <span class="brand-name">{{ config('app.name') }}</span>
        </div>
        <div class="topbar-right">Penawaran Resmi</div>
    </header>

    {{-- HERO --}}
    <div class="hero-strip">
        <div class="hero-inner">
            <div class="hero-eyebrow">Surat Penawaran</div>
            <h1 class="hero-title">Halo, {{ $order->contact->name }} 👋</h1>
            <p class="hero-sub">
                Berikut adalah penawaran resmi yang telah kami siapkan untuk Anda.
                Silakan tinjau detail di bawah dan berikan respons Anda.
            </p>
            <div class="hero-meta">
                <span class="meta-chip">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    {{ $order->order_code }}
                </span>
                <span class="meta-chip">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $order->created_at->format('d M Y') }}
                </span>
                <span class="status-chip status-{{ $order->status }}">
                    <span class="sdot sdot-{{ $order->status }}"></span>
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
        </div>
    </div>

    {{-- MAIN --}}
    <main class="main">

        {{-- Already responded banner --}}
        @if($order->status === 'approved')
            <div class="responded-banner approved">
                <div class="responded-icon">✅</div>
                <div>
                    <div class="responded-title">Penawaran Telah Disetujui</div>
                    <div class="responded-sub">Anda telah menyetujui penawaran ini. Tim kami akan segera menghubungi Anda.</div>
                </div>
            </div>
        @elseif($order->status === 'rejected')
            <div class="responded-banner rejected">
                <div class="responded-icon">❌</div>
                <div>
                    <div class="responded-title">Penawaran Telah Ditolak</div>
                    <div class="responded-sub">Anda telah menolak penawaran ini. Hubungi kami jika ada pertanyaan.</div>
                </div>
            </div>
        @elseif($order->status === 'done')
            <div class="responded-banner approved">
                <div class="responded-icon">🎉</div>
                <div>
                    <div class="responded-title">Order Selesai</div>
                    <div class="responded-sub">Terima kasih! Order ini telah selesai diproses.</div>
                </div>
            </div>
        @endif

        {{-- Items --}}
        @if($order->offer && $order->offer->details->count())
            <div class="sec-label">Rincian Penawaran</div>
            <div class="card">
                <table class="offer-table">
                    <thead>
                        <tr>
                            <th colspan="2">Paket / Layanan</th>
                            <th class="r">Qty</th>
                            <th class="r">Harga Satuan</th>
                            <th class="r">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($order->offer->details as $i => $detail)
                            @php
                                $sub = $detail->qty * $detail->price;
                                $grandTotal += $sub;
                            @endphp
                            <tr>
                                <td style="width:32px;padding-right:0;">
                                    <div class="pkg-num">{{ $i + 1 }}</div>
                                </td>
                                <td>
                                    <div class="pkg-name">{{ $detail->package?->name ?? 'Paket tidak tersedia' }}</div>
                                    @if($detail->package?->machine)
                                        <div class="pkg-info">
                                            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:3px"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                                            {{ $detail->package->machine->name }}
                                        </div>
                                    @endif
                                    @if($detail->package?->description)
                                        <div class="pkg-info">{{ Str::limit($detail->package->description, 60) }}</div>
                                    @endif
                                </td>
                                <td class="r"><span class="qty-badge">{{ $detail->qty }}</span></td>
                                <td class="r price-cell">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="r sub-cell">Rp {{ number_format($sub, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="totals">
                    @php $itemCount = $order->offer->details->count(); @endphp
                    <div class="total-row">
                        <span class="lbl">Jumlah item</span>
                        <span class="val">{{ $itemCount }} paket</span>
                    </div>
                    <div class="total-row grand">
                        <span class="lbl">Total Penawaran</span>
                        <span class="val">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Notes & Terms --}}
        @if($order->offer && ($order->offer->notes || $order->offer->terms))
            <div class="sec-label" style="margin-top:28px;">Catatan & Syarat</div>
            <div class="card">
                <div class="notes-body">
                    @if($order->offer->notes)
                        <div style="margin-bottom: {{ $order->offer->terms ? '20px' : '0' }}">
                            <div class="notes-sub-label">Catatan</div>
                            <div class="notes-block">{{ $order->offer->notes }}</div>
                        </div>
                    @endif
                    @if($order->offer->terms)
                        <div>
                            <div class="notes-sub-label">Syarat & Ketentuan</div>
                            <div class="notes-block">{{ $order->offer->terms }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="page-footer">
            Penawaran ini dikirimkan secara pribadi kepada <strong>{{ $order->contact->email }}</strong>.<br>
        </div>

    </main>

    {{-- ACTION BAR (only if status allows response) --}}
    @if(in_array($order->status, ['offered', 'form_required']))
        <div class="action-bar">
            <div class="action-inner">
                <div class="action-info">
                    Total: <strong>Rp {{ number_format($grandTotal ?? 0, 0, ',', '.') }}</strong>
                    &nbsp;·&nbsp; {{ $order->offer?->details->count() ?? 0 }} item
                </div>
                <div class="action-btns">
                    <button type="button" class="btn-reject" onclick="openModal('reject')">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak
                    </button>
                    <button type="button" class="btn-approve" onclick="handleApprove()">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Setuju & Konfirmasi
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════
        MODAL: SIGNATURE PAD
    ══════════════════════════════════════════ --}}
    <div class="modal-overlay" id="signModal">
        <div class="modal modal-signature">
            <div class="modal-icon sign">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-2.828 1.172H7v-2a4 4 0 011.172-2.828L9 13z"/>
                </svg>
            </div>
            <div class="modal-title">Tanda Tangan Diperlukan</div>
            <div class="modal-desc">
                Sebelum menyetujui penawaran, silakan bubuhkan tanda tangan Anda.
                Tanda tangan akan disimpan sebagai bukti persetujuan resmi.
            </div>

            {{-- Tab Switcher --}}
            <div class="sig-tabs">
                <button type="button" class="sig-tab active" id="tabDraw" onclick="switchSigTab('draw')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-2.828 1.172H7v-2a4 4 0 011.172-2.828L9 13z"/>
                    </svg>
                    Gambar Tanda Tangan
                </button>
                <button type="button" class="sig-tab" id="tabUpload" onclick="switchSigTab('upload')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Upload Gambar
                </button>
            </div>

            {{-- Panel: Draw --}}
            <div id="panelDraw">
                <div class="sig-pad-wrap" id="sigPadWrap">
                    <canvas id="sigCanvas"></canvas>
                    <div class="sig-pad-placeholder" id="sigPlaceholder">
                        <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#a8a29e" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-2.828 1.172H7v-2a4 4 0 011.172-2.828L9 13z"/>
                        </svg>
                        <span>Tanda tangani di sini</span>
                    </div>
                </div>
                <div class="sig-actions">
                    <button type="button" class="btn-clear-sig" id="btnClearSig">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Ulangi
                    </button>
                </div>
            </div>

            {{-- Panel: Upload --}}
            <div id="panelUpload" style="display:none;">
                <div class="sig-upload-area" id="sigUploadArea">
                    <input type="file" id="sigFileInput" accept="image/*" style="display:none;">
                    <div class="sig-upload-placeholder" id="sigUploadPlaceholder">
                        <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="#a8a29e" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        <span>Klik atau seret gambar tanda tangan ke sini</span>
                        <small>Format: PNG, JPG, GIF · Maks. 2 MB</small>
                    </div>
                    <img id="sigUploadPreview" src="" alt="Preview" style="display:none; max-width:100%; max-height:180px; border-radius:6px; object-fit:contain;">
                    <button type="button" class="btn-clear-sig" id="btnClearUpload" style="display:none; margin-top:8px;">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Gambar
                    </button>
                </div>
            </div>

            {{-- Hidden form --}}
            <form id="signForm"
                action="{{ route('orders.guest.sign', ['slug' => $order->company->slug, 'token' => $order->access_token]) }}"
                method="POST">
                @csrf
                <input type="hidden" name="signature" id="signatureInput">
                <div class="modal-actions">
                    <button type="button" class="modal-cancel" onclick="closeModal('sign')">Batal</button>
                    <button type="submit" class="modal-confirm-sign" id="btnSubmitSign" disabled>
                        Simpan & Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: APPROVE CONFIRMATION --}}
    <div class="modal-overlay" id="approveModal">
        <div class="modal">
            <div class="modal-icon approve">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="modal-title">Setujui Penawaran?</div>
            <div class="modal-desc">
                Dengan menekan <strong>Ya, Setuju</strong> Anda menyatakan telah membaca dan menyetujui semua item serta syarat dalam penawaran ini.
            </div>
            <form action="{{ route('orders.guest.approve', ['slug' => $order->company->slug, 'token' => $order->access_token]) }}" method="POST">
                @csrf
                <div class="modal-actions">
                    <button type="button" class="modal-cancel" onclick="closeModal('approve')">Batal</button>
                    <button type="submit" class="modal-confirm-approve">Ya, Setuju</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: REJECT CONFIRMATION --}}
    <div class="modal-overlay" id="rejectModal">
        <div class="modal">
            <div class="modal-icon reject">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div class="modal-title">Tolak Penawaran?</div>
            <div class="modal-desc">
                Anda akan menolak penawaran ini. Tindakan ini tidak dapat dibatalkan. Tim kami akan mendapat notifikasi.
            </div>
            <form action="{{ route('orders.guest.reject', ['slug' => $order->company->slug, 'token' => $order->access_token]) }}" method="POST">
                @csrf
                <div class="modal-actions">
                    <button type="button" class="modal-cancel" onclick="closeModal('reject')">Batal</button>
                    <button type="submit" class="modal-confirm-reject">Ya, Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ── FLAG dari PHP: apakah contact sudah punya signature? ──
        const hasSignature = {{ $order->contact->signature_path ? 'true' : 'false' }};

        // ── Modal helpers ──
        function openModal(type) {
            document.getElementById(type + 'Modal').classList.add('open');
            if (type === 'sign') {
                setTimeout(resizeCanvas, 50);
            }
        }
        function closeModal(type) {
            document.getElementById(type + 'Modal').classList.remove('open');
        }

        // Close on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) this.classList.remove('open');
            });
        });

        // ── Handle klik tombol Setuju ──
        function handleApprove() {
            if (hasSignature) {
                openModal('approve');
            } else {
                openModal('sign');
            }
        }

        // ══════════════════════════════════════════
        // TAB SWITCHER & UPLOAD HANDLER
        // ══════════════════════════════════════════
        function switchSigTab(tab) {
            const btnSubmit = document.getElementById('btnSubmitSign');
            const inputHidden = document.getElementById('signatureInput');

            document.getElementById('tabDraw').classList.toggle('active', tab === 'draw');
            document.getElementById('tabUpload').classList.toggle('active', tab === 'upload');
            document.getElementById('panelDraw').style.display   = tab === 'draw'   ? '' : 'none';
            document.getElementById('panelUpload').style.display = tab === 'upload' ? '' : 'none';

            // Reset submit state saat pindah tab
            inputHidden.value  = '';
            btnSubmit.disabled = true;

            if (tab === 'draw') {
                // Resize canvas supaya dimensi benar setelah ditampilkan
                if (typeof window.resizeCanvas === 'function') window.resizeCanvas();
            }
        }

        (function () {
            const uploadArea    = document.getElementById('sigUploadArea');
            const fileInput     = document.getElementById('sigFileInput');
            const preview       = document.getElementById('sigUploadPreview');
            const placeholder   = document.getElementById('sigUploadPlaceholder');
            const btnClearUp    = document.getElementById('btnClearUpload');
            const btnSubmit     = document.getElementById('btnSubmitSign');
            const inputHidden   = document.getElementById('signatureInput');

            const MAX_BYTES = 2 * 1024 * 1024; // 2 MB

            // Klik area → buka file picker
            uploadArea.addEventListener('click', function (e) {
                if (e.target === btnClearUp || btnClearUp.contains(e.target)) return;
                fileInput.click();
            });

            // Drag & drop
            uploadArea.addEventListener('dragover', function (e) {
                e.preventDefault();
                uploadArea.classList.add('drag-over');
            });
            uploadArea.addEventListener('dragleave', function () {
                uploadArea.classList.remove('drag-over');
            });
            uploadArea.addEventListener('drop', function (e) {
                e.preventDefault();
                uploadArea.classList.remove('drag-over');
                const file = e.dataTransfer.files[0];
                if (file) handleFile(file);
            });

            // File input change
            fileInput.addEventListener('change', function () {
                if (fileInput.files[0]) handleFile(fileInput.files[0]);
            });

            function handleFile(file) {
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar (PNG, JPG, GIF, dll.)');
                    return;
                }
                if (file.size > MAX_BYTES) {
                    alert('Ukuran gambar maksimal 2 MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    const dataUrl = e.target.result;

                    // Tampilkan preview
                    preview.src = dataUrl;
                    preview.style.display       = 'block';
                    placeholder.style.display   = 'none';
                    btnClearUp.style.display    = 'inline-flex';

                    // Simpan ke hidden input
                    inputHidden.value  = dataUrl;
                    btnSubmit.disabled = false;
                };
                reader.readAsDataURL(file);
            }

            // Tombol hapus gambar
            btnClearUp.addEventListener('click', function (e) {
                e.stopPropagation();
                preview.src             = '';
                preview.style.display   = 'none';
                placeholder.style.display = 'flex';
                btnClearUp.style.display  = 'none';
                fileInput.value           = '';
                inputHidden.value         = '';
                btnSubmit.disabled        = true;
            });
        })();

        // ══════════════════════════════════════════
        // SIGNATURE PAD
        // ══════════════════════════════════════════
        (function () {
            const canvas      = document.getElementById('sigCanvas');
            const ctx         = canvas.getContext('2d');
            const placeholder = document.getElementById('sigPlaceholder');
            const btnClear    = document.getElementById('btnClearSig');
            const btnSubmit   = document.getElementById('btnSubmitSign');
            const inputHidden = document.getElementById('signatureInput');

            let drawing  = false;
            let hasDrawn = false;

            function setDrawingStyle() {
                ctx.strokeStyle = '#1c1917';
                ctx.lineWidth   = 2.5;
                ctx.lineCap     = 'round';
                ctx.lineJoin    = 'round';
            }

            // Resize canvas tanpa menghapus gambar yang sudah ada
            function resizeCanvas() {
                const wrap  = document.getElementById('sigPadWrap');
                const ratio = window.devicePixelRatio || 1;
                const w     = wrap.clientWidth;
                const h     = 220;

                // Simpan gambar sebelum resize (hanya jika sudah ada tanda tangan)
                const imageData = hasDrawn ? canvas.toDataURL('image/png') : null;

                canvas.width        = w * ratio;
                canvas.height       = h * ratio;
                canvas.style.width  = w + 'px';
                canvas.style.height = h + 'px';
                ctx.scale(ratio, ratio);
                setDrawingStyle();

                // Restore gambar setelah resize
                if (imageData) {
                    const img = new Image();
                    img.onload = () => {
                        ctx.drawImage(img, 0, 0, w, h);
                    };
                    img.src = imageData;
                }
            }

            // Resize saat window berubah ukuran (tanpa clearCanvas)
            window.addEventListener('resize', resizeCanvas);

            function getPos(e) {
                const rect = canvas.getBoundingClientRect();
                const src  = e.touches ? e.touches[0] : e;
                return {
                    x: src.clientX - rect.left,
                    y: src.clientY - rect.top,
                };
            }

            function startDraw(e) {
                e.preventDefault();
                drawing = true;
                const pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }

            function draw(e) {
                if (!drawing) return;
                e.preventDefault();
                const pos = getPos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();

                if (!hasDrawn) {
                    hasDrawn = true;
                    placeholder.style.opacity = '0';
                    btnSubmit.disabled = false;
                }
            }

            function endDraw(e) {
                if (!drawing) return;
                e.preventDefault();
                drawing = false;
                ctx.closePath();
                inputHidden.value = canvas.toDataURL('image/png');
            }

            // Mouse events
            canvas.addEventListener('mousedown',  startDraw);
            canvas.addEventListener('mousemove',  draw);
            canvas.addEventListener('mouseup',    endDraw);
            canvas.addEventListener('mouseleave', endDraw);

            // Touch events
            canvas.addEventListener('touchstart', startDraw, { passive: false });
            canvas.addEventListener('touchmove',  draw,      { passive: false });
            canvas.addEventListener('touchend',   endDraw,   { passive: false });

            // Clear canvas sepenuhnya
            function clearCanvas() {
                const ratio = window.devicePixelRatio || 1;
                ctx.clearRect(0, 0, canvas.width / ratio, canvas.height / ratio);
                hasDrawn              = false;
                placeholder.style.opacity = '1';
                btnSubmit.disabled    = true;
                inputHidden.value     = '';
            }

            btnClear.addEventListener('click', clearCanvas);

            // Expose resizeCanvas agar bisa dipanggil dari openModal
            window.resizeCanvas = resizeCanvas;
        })();
    </script>

</body>
</html>