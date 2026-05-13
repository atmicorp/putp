<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Layanan — PUTP Politeknik ATMI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/jpeg" href="{{ asset('logopoltek.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            width: 38px;
            height: 38px;
            background: var(--teal);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Serif Display', serif;
            font-size: 12px;
            color: white;
            font-weight: 700;
            flex-shrink: 0;
        }

        .nav-title { font-size: 13px; font-weight: 600; color: white; letter-spacing: .5px; }
        .nav-sub   { font-size: 11px; color: var(--muted); }

        .cart-badge-nav {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 8px;
            padding: 8px 16px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
        }

        .cart-badge-nav:hover { background: rgba(255,255,255,.13); }

        .cart-count-bubble {
            background: var(--teal);
            color: white;
            font-size: 11px;
            font-weight: 700;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s;
        }

        /* ── LAYOUT ── */
        .page-wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 40px 24px 80px;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 28px;
            align-items: start;
        }

        /* ── STEP INDICATOR ── */
        .steps-header {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 8px;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .step-num {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid var(--border);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
            flex-shrink: 0;
            transition: all .3s;
        }

        .step-num.active {
            background: var(--teal);
            border-color: var(--teal);
            color: white;
        }

        .step-num.done {
            background: #10B981;
            border-color: #10B981;
            color: white;
        }

        .step-label { font-size: 13px; font-weight: 500; color: var(--muted); transition: color .3s; }
        .step-label.active { color: var(--navy); }

        .step-line { flex: 1; height: 2px; background: var(--border); margin: 0 12px; transition: background .3s; }
        .step-line.done { background: #10B981; }

        /* ── PANEL KIRI ── */
        .panel {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
        }

        .panel-header {
            padding: 22px 26px 18px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }

        .panel-title {
            font-family: 'DM Serif Display', serif;
            font-size: 20px;
            color: var(--navy);
            margin-bottom: 4px;
        }

        .panel-sub { font-size: 13px; color: var(--slate); }

        .panel-body { padding: 24px 26px; }

        /* ── TOKEN FORM ── */
        #tokenPanel .panel-body {
            padding: 32px 26px;
        }

        .token-illustration {
            text-align: center;
            margin-bottom: 28px;
        }

        .token-illustration .big-icon {
            font-size: 56px;
            display: block;
            margin-bottom: 10px;
        }

        .token-illustration p {
            font-size: 14px;
            color: var(--slate);
            line-height: 1.6;
            max-width: 380px;
            margin: 0 auto;
        }

        .form-field { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--slate);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 15px;
            font-family: 'DM Sans', sans-serif;
            color: var(--navy);
            background: white;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            letter-spacing: 1px;
        }

        .form-input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(234,88,12,.1);
        }

        .form-input.error { border-color: #EF4444; box-shadow: 0 0 0 3px rgba(239,68,68,.1); }

        .error-msg {
            display: none;
            font-size: 12px;
            color: #EF4444;
            margin-top: 6px;
            align-items: center;
            gap: 4px;
        }

        .error-msg.show { display: flex; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            border: none;
            transition: all .2s;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--teal);
            color: white;
            width: 100%;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--teal-l);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(234,88,12,.3);
        }

        .btn-primary:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        .btn-ghost {
            background: var(--surface);
            color: var(--slate);
            border: 1.5px solid var(--border);
        }

        .btn-ghost:hover { background: var(--border); color: var(--navy); }

        .btn-danger {
            background: #FEF2F2;
            color: #EF4444;
            border: 1.5px solid #FECACA;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
        }

        .btn-danger:hover { background: #FECACA; }

        /* ── PACKAGE BROWSER ── */
        #browsePanel { display: none; }

        .category-tabs {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .tab-btn {
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            border: 1.5px solid var(--border);
            background: white;
            color: var(--slate);
            cursor: pointer;
            transition: all .2s;
            font-family: 'DM Sans', sans-serif;
        }

        .tab-btn:hover { border-color: var(--teal-l); color: var(--teal); }
        .tab-btn.active { background: var(--teal); border-color: var(--teal); color: white; }

        .search-wrap {
            position: relative;
            margin-bottom: 18px;
        }

        .search-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 11px 16px 11px 42px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .2s;
        }

        .search-input:focus { border-color: var(--teal); }

        .packages-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 480px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
        }

        .pkg-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            transition: all .2s;
        }

        .pkg-row:hover { border-color: var(--teal-l); background: white; }
        .pkg-row.in-cart { border-color: #10B981; background: #F0FDF4; }

        .pkg-row-left { flex: 1; min-width: 0; }

        .pkg-row-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 2px;
        }

        .pkg-row-cat {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .pkg-row-price {
            display: none;
        }

        .add-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--teal);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            flex-shrink: 0;
            font-size: 18px;
            line-height: 1;
        }

        .add-btn:hover { background: var(--teal-l); transform: scale(1.1); }
        .add-btn.remove { background: #10B981; }
        .add-btn.remove:hover { background: #EF4444; }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--muted);
        }

        .empty-state svg { margin-bottom: 12px; opacity: .4; }

        /* ── SIDEBAR CART ── */
        .sidebar { position: sticky; top: 88px; }

        .order-info-card {
            background: var(--navy);
            border-radius: 20px;
            padding: 22px 24px;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
        }

        .order-info-card::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(234,88,12,.3) 0%, transparent 70%);
        }

        .oi-label { font-size: 11px; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .oi-value { font-size: 15px; font-weight: 600; color: white; }
        .oi-row { margin-bottom: 14px; position: relative; z-index: 2; }
        .oi-row:last-child { margin-bottom: 0; }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .status-pill.draft    { background: rgba(234,88,12,.2);  color: var(--teal-l); }
        .status-pill.offered  { background: rgba(14,165,233,.2); color: #38BDF8; }
        .status-pill.form_required { background: rgba(245,158,11,.2); color: #FCD34D; }

        .cart-panel {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
        }

        .cart-header {
            padding: 18px 20px 14px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-title {
            font-family: 'DM Serif Display', serif;
            font-size: 17px;
            color: var(--navy);
        }

        .cart-empty-msg {
            padding: 32px 20px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }

        .cart-items { padding: 12px; }

        .cart-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 10px;
            transition: background .2s;
        }

        .cart-item:hover { background: var(--surface); }

        .ci-num {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            background: rgba(234,88,12,.1);
            color: var(--teal);
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .ci-info { flex: 1; min-width: 0; }
        .ci-name { font-size: 13px; font-weight: 600; color: var(--navy); line-height: 1.4; }
        .ci-price { display: none; }

        .ci-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 2px;
            border-radius: 4px;
            transition: color .2s;
            flex-shrink: 0;
            display: flex;
        }

        .ci-remove:hover { color: #EF4444; }

        .cart-divider { height: 1px; background: var(--border); margin: 8px 12px; }

        .cart-total {
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--border);
            background: var(--surface);
        }

        .cart-total-label { font-size: 13px; color: var(--slate); font-weight: 500; }
        .cart-total-value { font-size: 16px; font-weight: 700; color: var(--navy); }

        .submit-area {
            padding: 16px 20px 20px;
            border-top: 1px solid var(--border);
        }

        .submit-note {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.5;
            margin-top: 10px;
            text-align: center;
        }

        /* ── SUCCESS STATE ── */
        #successPanel {
            display: none;
            grid-column: 1 / -1;
        }

        .success-box {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 24px;
            padding: 60px 40px;
            text-align: center;
            max-width: 540px;
            margin: 0 auto;
        }

        .success-icon {
            width: 72px;
            height: 72px;
            background: #F0FDF4;
            border: 3px solid #86EFAC;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 32px;
        }

        .success-title {
            font-family: 'DM Serif Display', serif;
            font-size: 28px;
            color: var(--navy);
            margin-bottom: 12px;
        }

        .success-desc {
            font-size: 15px;
            color: var(--slate);
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .success-code {
            display: inline-block;
            background: var(--cream);
            border: 1.5px solid var(--gold);
            border-radius: 10px;
            padding: 10px 24px;
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--teal);
            letter-spacing: 2px;
            margin-bottom: 32px;
        }

        /* ── LOADING OVERLAY ── */
        .loading-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26,15,0,.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .loading-overlay.show { display: flex; }

        .spinner {
            width: 44px;
            height: 44px;
            border: 3px solid rgba(255,255,255,.2);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── TOAST (diganti SweetAlert2) ── */

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .page-wrap {
                grid-template-columns: 1fr;
                padding: 24px 16px 60px;
            }
            .sidebar { position: static; }
            nav { padding: 14px 20px; }
        }

        @media (max-width: 480px) {
            .steps-header { gap: 0; }
            .step-label { display: none; }
            .step-line { margin: 0 6px; }
        }

        .swal-custom-popup {
            border-radius: 20px !important;
            font-family: 'DM Sans', sans-serif !important;
            padding-bottom: 0 !important;
        }
        .swal-custom-title {
            font-family: 'DM Serif Display', serif !important;
            font-size: 20px !important;
            color: #1A0F00 !important;
            padding-bottom: 8px !important;
            border-bottom: 1px solid #E2E8F0 !important;
        }
        .swal-custom-html {
            text-align: left !important;
            padding: 20px 26px 4px !important;
        }
        .swal2-actions {
            border-top: 1px solid #E2E8F0;
            padding: 14px 20px !important;
            margin-top: 0 !important;
            gap: 8px !important;
            background: #F8FAFC;
        }
        .swal2-confirm, .swal2-cancel {
            border-radius: 10px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            padding: 11px 20px !important;
        }

        .pkg-row-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        .qty-ctrl { display: flex; align-items: center; gap: 4px; }

        .qty-btn {
            width: 26px; height: 26px;
            border-radius: 50%;
            border: 0.5px solid var(--color-border-secondary);
            background: var(--color-background-secondary);
            cursor: pointer; font-size: 16px; font-weight: 500;
            display: flex; align-items: center; justify-content: center;
            color: var(--color-text-primary);
        }
        .qty-btn:hover { background: var(--color-background-tertiary); }

        .qty-num { min-width: 24px; text-align: center; font-size: 14px; font-weight: 500; }
    </style>
</head>
<body>

<nav>
    <a href="/" class="nav-brand">
        <div class="nav-logo">PUTP</div>
        <div>
            <div class="nav-title">Politeknik ATMI</div>
            <div class="nav-sub">Surakarta</div>
        </div>
    </a>
    <button class="cart-badge-nav" onclick="scrollToCart()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        Keranjang
        <div class="cart-count-bubble" id="navCartCount">0</div>
    </button>
</nav>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>


<div class="page-wrap" id="pageWrap">

    {{-- STEP INDICATOR --}}
    <div class="steps-header" id="stepsHeader">
        <div class="step-item">
            <div class="step-num active" id="s1">1</div>
            <span class="step-label active" id="sl1">Masukkan Kode</span>
        </div>
        <div class="step-line" id="line1"></div>
        <div class="step-item">
            <div class="step-num" id="s2">2</div>
            <span class="step-label" id="sl2">Pilih Layanan</span>
        </div>
        <div class="step-line" id="line2"></div>
        <div class="step-item">
            <div class="step-num" id="s3">3</div>
            <span class="step-label" id="sl3">Konfirmasi</span>
        </div>
    </div>

    {{-- ── PANEL 1: TOKEN ── --}}
    <div id="tokenPanel" style="grid-column: 1 / -1;">
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Masukkan Kode Akses</div>
                <div class="panel-sub">Dapatkan kode dari tim PUTP untuk melanjutkan pemilihan layanan</div>
            </div>
            <div class="panel-body">
                <div class="token-illustration">
                    <span class="big-icon">🔑</span>
                    <p>Kode akses diberikan oleh admin PUTP setelah Anda menghubungi kami. Masukkan kode di bawah untuk melihat dan memilih layanan yang tersedia untuk order Anda.</p>
                </div>

                <div class="form-field">
                    <label class="form-label" for="tokenInput">Kode Akses Order</label>
                    <input type="text"
                           id="tokenInput"
                           class="form-input"
                           placeholder="Contoh: abc123xyz..."
                           autocomplete="off"
                           style="font-family: monospace; font-size: 14px;">
                    <div class="error-msg" id="tokenError">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span id="tokenErrorMsg">Kode tidak valid</span>
                    </div>
                </div>

                <button class="btn btn-primary" id="validateBtn" onclick="validateToken()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk & Lihat Layanan
                </button>

                {{-- ── INFO: Belum punya token? ── --}}
                <div style="margin-top: 12px; text-align: center;">
                    <p style="margin: 0 0 8px; font-size: 13px; color: #888;">Belum punya kode akses?</p>
                    <a href="https://wa.me/6285802543185?text=Halo%20Admin%20PUTP%2C%20saya%20ingin%20mendapatkan%20kode%20akses%20order"
                    target="_blank"
                    style="display: inline-flex; align-items: center; gap: 6px; background: #25D366; color: #fff; text-decoration: none; font-size: 13px; font-weight: 500; padding: 7px 14px; border-radius: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Chat Admin via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── PANEL 2: BROWSE + CART ── --}}
    <div id="browsePanel">
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Pilih Layanan</div>
                <div class="panel-sub" id="browseSub">Klik "+" untuk menambahkan layanan ke keranjang</div>
            </div>
            <div class="panel-body">

                <div class="category-tabs" id="categoryTabs"></div>

                <div class="search-wrap">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" class="search-input" id="searchInput" placeholder="Cari nama layanan..." oninput="filterPackages()">
                </div>

                <div class="packages-list" id="packagesList"></div>
            </div>
        </div>
    </div>

    {{-- ── SIDEBAR ── --}}
    <div class="sidebar" id="sidebarPanel" style="display:none;">

        <div class="order-info-card" id="orderInfoCard">
            <div class="oi-row">
                <div class="oi-label">Nama Customer</div>
                <div class="oi-value" id="siName">—</div>
            </div>
            <div class="oi-row">
                <div class="oi-label">Kode Order</div>
                <div class="oi-value" id="siCode" style="letter-spacing:1px;">—</div>
            </div>
            <div class="oi-row">
                <div class="oi-label">Status</div>
                <div id="siStatus"></div>
            </div>
        </div>

        <div class="cart-panel" id="cartPanel">
            <div class="cart-header">
                <div class="cart-title">🛒 Keranjang</div>
                <button class="btn btn-ghost" style="padding:6px 12px; font-size:12px;" onclick="clearCart()">Kosongkan</button>
            </div>

            <div id="cartEmptyMsg" class="cart-empty-msg">
                Belum ada layanan dipilih.<br>Klik "+" pada layanan di sebelah kiri.
            </div>

            <div id="cartItemsWrap" style="display:none;">
                <div class="cart-items" id="cartItems"></div>
                <div class="cart-divider"></div>
                    <div class="cart-total" style="display:none;">
                        <span class="cart-total-label">Estimasi Total</span>
                        <span class="cart-total-value" id="cartTotal">Rp 0</span>
                    </div>
            </div>

            <div class="submit-area">
                <button class="btn btn-primary" id="submitBtn" onclick="submitCart()" disabled>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Konfirmasi Pilihan
                </button>
                <p class="submit-note">Setelah dikonfirmasi, pilihan ini akan diteruskan ke admin dan tidak dapat diubah lagi.</p>
            </div>
        </div>

    </div>

    {{-- ── SUCCESS ── --}}
    <div id="successPanel">
        <div class="success-box">
            <div class="success-icon">✅</div>
            <h2 class="success-title">Pilihan Berhasil Dikirim!</h2>
            <p class="success-desc">Layanan yang Anda pilih telah diteruskan ke tim PUTP. Admin kami akan segera memproses dan menghubungi Anda.</p>
            <div class="success-code" id="successCode">—</div>
            <p style="font-size:13px; color:var(--muted); margin-bottom:24px;">Simpan kode order di atas sebagai referensi Anda.</p>
            <a href="https://wa.me/6285802543185?text=Halo%20PUTP%2C%20saya%20sudah%20submit%20pilihan%20layanan" target="_blank"
               class="btn btn-primary" style="width:auto; display:inline-flex;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Konfirmasi via WhatsApp
            </a>
            <form action="{{ route('orders.guest.status.lookup') }}" method="POST" style="margin-top:12px;">
                @csrf
                <input type="hidden" name="token" id="statusTokenInput">

                <button type="submit" class="btn btn-secondary" style="width:auto; display:inline-flex;">
                    🔍 Cek Status Order
                </button>
            </form>
        </div>
    </div>

</div>

<script>
    // ── State
    let cart = JSON.parse(localStorage.getItem('putp_cart') || '[]');
    let allPackages = [];
    let currentToken = '';
    let activeCategory = 'all';

    function normalizeCart() {
        if (!Array.isArray(cart)) cart = [];
        cart = cart
            .map(c => {
                if (!c || typeof c !== 'object') return null;
                const pkgId = c.package_id ?? c.packageId ?? c.id ?? null;
                const qty = Number(c.qty ?? 1);
                const price = c.price ?? c.base_price ?? 0;
                const name = c.name ?? c.package_name ?? '';
                if (!pkgId) return null;
                return {
                    package_id: Number(pkgId),
                    name,
                    price,
                    qty: qty >= 1 ? qty : 1,
                };
            })
            .filter(Boolean);
        saveCart();
    }

    // ── Helpers
    function showLoading(v) {
        document.getElementById('loadingOverlay').classList.toggle('show', v);
    }

    const SwalToast = Swal.mixin({
        toast: true,
        position: 'bottom',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    function showToast(msg, type = '') {
        const iconMap = { success: 'success', error: 'error' };
        SwalToast.fire({
            icon: iconMap[type] || 'info',
            title: msg,
        });
    }

    function fmtPrice(n) {
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    }

    function saveCart() {
        localStorage.setItem('putp_cart', JSON.stringify(cart));
    }

    function isInCart(pkgId) {
        return cart.some(c => c.package_id === pkgId);
    }

    // ── STEP UI
    function setStep(n) {
        [1,2,3].forEach(i => {
            const s = document.getElementById('s' + i);
            const l = document.getElementById('sl' + i);
            s.className = 'step-num' + (i < n ? ' done' : i === n ? ' active' : '');
            if (l) l.className = 'step-label' + (i === n ? ' active' : '');
            if (i < n) s.innerHTML = '✓';
            else s.textContent = i;
        });
        [1,2].forEach(i => {
            const line = document.getElementById('line' + i);
            if (line) line.className = 'step-line' + (i < n ? ' done' : '');
        });
    }

    // ── VALIDATE TOKEN
    async function validateToken() {
        const token = document.getElementById('tokenInput').value.trim();
        const errEl  = document.getElementById('tokenError');
        const errMsg = document.getElementById('tokenErrorMsg');
        const inp    = document.getElementById('tokenInput');

        errEl.classList.remove('show');
        inp.classList.remove('error');

        if (!token) {
            errMsg.textContent = 'Kode tidak boleh kosong.';
            errEl.classList.add('show');
            inp.classList.add('error');
            return;
        }

        showLoading(true);
        document.getElementById('validateBtn').disabled = true;

        try {
            const res = await fetch('{{ route("orders.guest.validate-token") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ token }),
            });

            const data = await res.json();

            if (!data.valid) {
                errMsg.textContent = data.message || 'Kode tidak valid.';
                errEl.classList.add('show');
                inp.classList.add('error');
                return;
            }

            currentToken = token;
            document.getElementById('statusTokenInput').value = currentToken;
            allPackages  = data.packages || [];

            // Tampilkan info order di sidebar
            document.getElementById('siName').textContent = data.customer_name || '—';
            document.getElementById('siCode').textContent = data.order_code || '—';
            renderStatusPill(data.status);

            // Pre-fill keranjang dari existing items jika ada
            if (data.existing_items && data.existing_items.length > 0 && cart.length === 0) {
                cart = data.existing_items.map(i => ({
                    package_id: i.package_id,
                    name: i.name,
                    price: i.price,
                    qty: i.qty,
                }));
                saveCart();
                showToast('Pilihan sebelumnya dimuat ke keranjang.', 'success');
            }

            normalizeCart();

            // Switch ke step 2
            document.getElementById('tokenPanel').style.display = 'none';
            document.getElementById('browsePanel').style.display = 'block';
            document.getElementById('sidebarPanel').style.display = 'block';
            document.getElementById('stepsHeader').scrollIntoView({ behavior: 'smooth', block: 'start' });

            buildCategoryTabs();
            renderPackages();
            renderCart();
            setStep(2);

        } catch (e) {
            errMsg.textContent = 'Terjadi kesalahan. Coba lagi.';
            errEl.classList.add('show');
            inp.classList.add('error');
        } finally {
            showLoading(false);
            document.getElementById('validateBtn').disabled = false;
        }
    }

    function renderStatusPill(status) {
        const labels = {
            draft: 'Draft',
            offered: 'Penawaran Dikirim',
            form_required: 'Menunggu Pengisian',
            approved: 'Disetujui',
            processing: 'Diproses',
            done: 'Selesai',
        };
        const el = document.getElementById('siStatus');
        el.innerHTML = `<span class="status-pill ${status}">${labels[status] || status}</span>`;
    }

    // ── CATEGORIES
    function buildCategoryTabs() {
        const cats = [...new Set(allPackages.map(p => p.category_id).filter(Boolean))];
        const container = document.getElementById('categoryTabs');
        const catNames = {};
        allPackages.forEach(p => {
            if (p.category_id && p.category_name && !catNames[p.category_id]) {
                catNames[p.category_id] = p.category_name;
            }
        });

        let html = `<button class="tab-btn active" onclick="filterByCategory('all', this)">Semua</button>`;
        cats.forEach(c => {
            const name = catNames[c] || c;
            html += `<button class="tab-btn" onclick="filterByCategory('${c}', this)">${name}</button>`;
        });
        container.innerHTML = html;
    }

    function filterByCategory(catId, btn) {
        activeCategory = catId;
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        renderPackages();
    }

    function filterPackages() { renderPackages(); }

    function renderPackages() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const list   = document.getElementById('packagesList');

        let filtered = allPackages.filter(p => {
            const matchCat = activeCategory === 'all' || p.category_id === activeCategory;
            const matchSearch = !search || p.name.toLowerCase().includes(search);
            return matchCat && matchSearch;
        });

        if (filtered.length === 0) {
            list.innerHTML = `<div class="empty-state">...</div>`;
            return;
        }

        list.innerHTML = filtered.map(p => {
            const cartItem = cart.find(c => c.package_id === p.id);
            const inCart = !!cartItem;
            const qty = cartItem ? cartItem.qty : 1;

            return `<div class="pkg-row ${inCart ? 'in-cart' : ''}" id="pkgrow-${p.id}">
                <div class="pkg-row-left">
                    <div class="pkg-row-name">${p.name}</div>
                    <div class="pkg-row-cat">${p.description ? p.description.substring(0,60) + (p.description.length > 60 ? '…' : '') : '—'}</div>
                </div>
                <div class="pkg-row-right" id="pkgctrl-${p.id}">
                    ${inCart ? `
                        <div class="qty-ctrl">
                            <button class="qty-btn" onclick="changeQty(${p.id}, -1)">−</button>
                            <span class="qty-num" id="pkgqty-${p.id}">${qty}</span>
                            <button class="qty-btn" onclick="changeQty(${p.id}, 1)">+</button>
                        </div>
                        <button class="add-btn remove" onclick="toggleCart(${p.id})" title="Hapus dari keranjang">✓</button>
                    ` : `
                        <button class="add-btn" onclick="toggleCart(${p.id})" title="Tambah ke keranjang">+</button>
                    `}
                </div>
            </div>`;
        }).join('');
    }

    function changeQty(pkgId, delta) {
        const item = cart.find(c => c.package_id === pkgId);
        if (!item) return;

        const newQty = item.qty + delta;
        if (newQty < 1) return; // minimal 1, bisa diganti removeFromCart jika mau

        item.qty = newQty;
        saveCart();

        // Update tampilan di package list tanpa re-render semua
        const qtyEl = document.getElementById('pkgqty-' + pkgId);
        if (qtyEl) qtyEl.textContent = newQty;

        renderCart(); // update cart sidebar
    }

    // ── CART ACTIONS
    function toggleCart(pkgId) {
        if (isInCart(pkgId)) {
            removeFromCart(pkgId);
        } else {
            addToCart(pkgId);
        }
    }

    function addToCart(pkgId) {
        const pkg = allPackages.find(p => p.id === pkgId);
        if (!pkg) return;
        if (isInCart(pkgId)) { showToast('Layanan sudah ada di keranjang.'); return; }

        cart.push({ package_id: pkg.id, name: pkg.name, price: pkg.base_price, qty: 1 });
        saveCart();

        // Animate bubble
        const bubble = document.getElementById('navCartCount');
        bubble.style.transform = 'scale(1.4)';
        setTimeout(() => bubble.style.transform = '', 200);

        renderCart();
        renderPackages();
        showToast('Ditambahkan: ' + pkg.name, 'success');
    }

    function removeFromCart(pkgId) {
        const pkg = cart.find(c => c.package_id === pkgId);
        cart = cart.filter(c => c.package_id !== pkgId);
        saveCart();
        renderCart();
        renderPackages();
        if (pkg) showToast('Dihapus: ' + pkg.name);
    }

    function clearCart() {
        if (cart.length === 0) return;
        Swal.fire({
            title: 'Kosongkan keranjang?',
            text: 'Semua layanan yang dipilih akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EA580C',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Ya, kosongkan',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                cart = [];
                saveCart();
                renderCart();
                renderPackages();
                showToast('Keranjang dikosongkan.', 'success');
            }
        });
    }

    function renderCart() {
        const emptyMsg  = document.getElementById('cartEmptyMsg');
        const itemsWrap = document.getElementById('cartItemsWrap');
        const itemsEl   = document.getElementById('cartItems');
        const totalEl   = document.getElementById('cartTotal');
        const submitBtn = document.getElementById('submitBtn');
        const navCount  = document.getElementById('navCartCount');

        navCount.textContent = cart.length;

        if (cart.length === 0) {
            emptyMsg.style.display = 'block';
            itemsWrap.style.display = 'none';
            submitBtn.disabled = true;
            return;
        }

        emptyMsg.style.display = 'none';
        itemsWrap.style.display = 'block';
        submitBtn.disabled = false;

        itemsEl.innerHTML = cart.map((c, i) => `
            <div class="cart-item">
                <div class="ci-num">${String(i + 1).padStart(2, '0')}</div>
                <div class="ci-info">
                    <div class="ci-name">${c.name}</div>
                </div>
                <div class="qty-ctrl">
                    <button class="qty-btn" onclick="changeQty(${c.package_id}, -1)">−</button>
                    <span class="qty-num">${c.qty}</span>
                    <button class="qty-btn" onclick="changeQty(${c.package_id}, 1)">+</button>
                </div>
                <button class="ci-remove" onclick="removeFromCart(${c.package_id})" title="Hapus">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
        `).join('');

        const total = cart.reduce((s, c) => s + (c.price * c.qty), 0);
        totalEl.textContent = fmtPrice(total);
    }

    // ── SUBMIT
    async function submitCart() {
        if (cart.length === 0) { showToast('Keranjang masih kosong.', 'error'); return; }
        if (!currentToken) { showToast('Token tidak valid.', 'error'); return; }

        normalizeCart();
        if (cart.length === 0) { showToast('Keranjang masih kosong.', 'error'); return; }

        // Tampilkan Modal Form Tambahan menggunakan SweetAlert2
        const { value: formValues } = await Swal.fire({
            title: 'Informasi Tambahan',
            html: `
                <div style="text-align:left; padding: 4px 0;">
                    <div style="margin-bottom:18px;">
                        <label style="display:block; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:#64748B; margin-bottom:8px;">Tujuan Pengujian</label>
                        <textarea id="swal-tujuan" class="swal2-textarea" style="margin:0; width:100%; border:1.5px solid #E2E8F0; border-radius:10px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1A0F00; resize:none;" placeholder="Contoh: Untuk sertifikasi produk..."></textarea>
                    </div>
                    <div style="margin-bottom:18px;">
                        <label style="display:block; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:#64748B; margin-bottom:8px;">Waktu Diharapkan</label>
                        <input id="swal-waktu" type="date" class="swal2-input" 
                            style="margin:0; width:100%; border:1.5px solid #E2E8F0; border-radius:10px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1A0F00;"
                            min="{{ now()->toDateString() }}">
                    </div>
                    <div style="margin-bottom:4px;">
                        <label style="display:block; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; color:#64748B; margin-bottom:8px;">Keterangan Tambahan</label>
                        <textarea id="swal-keterangan" class="swal2-textarea" style="margin:0; width:100%; border:1.5px solid #E2E8F0; border-radius:10px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1A0F00; resize:none;" placeholder="Catatan lainnya untuk admin..."></textarea>
                    </div>
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi & Kirim',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#EA580C',
            cancelButtonColor: '#64748B',
            // Styling tambahan via customClass
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal-custom-title',
                htmlContainer: 'swal-custom-html',
            },
            didOpen: () => {
                // Focus ring saat input aktif
                document.querySelectorAll('.swal2-textarea, .swal2-input').forEach(el => {
                    el.addEventListener('focus', e => {
                        e.target.style.borderColor = '#EA580C';
                        e.target.style.boxShadow = '0 0 0 3px rgba(234,88,12,.1)';
                        e.target.style.outline = 'none';
                    });
                    el.addEventListener('blur', e => {
                        e.target.style.borderColor = '#E2E8F0';
                        e.target.style.boxShadow = 'none';
                    });
                });
            },
            preConfirm: () => ({
                tujuan_pengujian: document.getElementById('swal-tujuan').value,
                waktu_diharapkan: document.getElementById('swal-waktu').value, // format: YYYY-MM-DD
                keterangan_tambahan: document.getElementById('swal-keterangan').value,
            })
        });

        // Jika user klik batal atau menutup modal
        if (!formValues) return;

        // Lanjut ke proses pengiriman data
        showLoading(true);
        document.getElementById('submitBtn').disabled = true;
        setStep(3);

        try {
            const res = await fetch('{{ route("orders.guest.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    token: currentToken,
                    items: cart.map(c => ({ package_id: c.package_id, qty: c.qty })),
                    // Tambahkan data dari form modal ke dalam body request
                    tujuan_pengujian: formValues.tujuan_pengujian,
                    waktu_diharapkan: formValues.waktu_diharapkan,
                    keterangan_tambahan: formValues.keterangan_tambahan,
                }),
            });

            const raw = await res.text();
            let data;
            try { data = JSON.parse(raw); } catch { data = null; }

            if (!res.ok || !data || !data.success) {
                let msg = (data && data.message) ? data.message : `Gagal menyimpan. (HTTP ${res.status})`;
                Swal.fire({ title: 'Gagal!', text: msg, icon: 'error', confirmButtonColor: '#EA580C' });
                setStep(2);
                document.getElementById('submitBtn').disabled = false;
                return;
            }

            // Sukses
            cart = [];
            saveCart();

            document.getElementById('browsePanel').style.display = 'none';
            document.getElementById('sidebarPanel').style.display = 'none';
            document.getElementById('stepsHeader').style.display = 'none';
            document.getElementById('successPanel').style.display = 'block';
            document.getElementById('successCode').textContent = data.order_code || '—';
            document.getElementById('navCartCount').textContent = '0';

            window.scrollTo({ top: 0, behavior: 'smooth' });

        } catch (e) {
            Swal.fire({ title: 'Terjadi Kesalahan', text: 'Terjadi kesalahan. Silakan coba lagi.', icon: 'error', confirmButtonColor: '#EA580C' });
            setStep(2);
            document.getElementById('submitBtn').disabled = false;
        } finally {
            showLoading(false);
        }
    }

    function scrollToCart() {
        document.getElementById('cartPanel')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // ── Enter key on token input
    document.getElementById('tokenInput').addEventListener('keydown', e => {
        if (e.key === 'Enter') validateToken();
    });

    // ── Init
    normalizeCart();
    renderCart();
</script>

</body>
</html>