<x-app-sidebar>
    <x-slot name="title">Order</x-slot>

    <x-slot name="breadcrumb">
        <span>Order</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.orders.index') }}" style="color:#ea580c;text-decoration:none;">Order List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Buat Order</span>
    </x-slot>

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        /* ── Back Link ── */
        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; color: #6b7280; text-decoration: none;
            margin-bottom: 20px; font-weight: 500; transition: color 0.15s;
            padding: 6px 0;
        }
        .back-link:hover { color: #ea580c; }

        /* ── Alert ── */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* ── Layout ── */
        .form-layout {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .form-main    { width: 100%; }
        .form-sidebar { width: 100%; }

        @media (min-width: 960px) {
            .form-layout {
                display: grid;
                grid-template-columns: 1fr 360px;
                gap: 20px;
                align-items: start;
            }
            .form-sidebar {
                position: sticky;
                top: 20px;
            }
        }

        /* ── Cards ── */
        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: visible;
            margin-bottom: 14px;
        }
        .card:last-child { margin-bottom: 0; }
        .card-header {
            padding: 14px 18px;
            border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; gap: 12px;
            border-radius: 14px 14px 0 0;
        }
        .card-icon {
            width: 34px; height: 34px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            background: #fff7ed; flex-shrink: 0;
        }
        .card-title    { font-size: 13.5px; font-weight: 700; color: #1c1917; }
        .card-subtitle { font-size: 11.5px; color: #9ca3af; margin-top: 1px; }
        .card-body     { padding: 18px; }

        /* ── Form Elements ── */
        .form-group { margin-bottom: 16px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-row {
            display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
        }
        @media (max-width: 540px) { .form-row { grid-template-columns: 1fr; } }

        label {
            display: block; font-size: 11.5px; font-weight: 700;
            color: #374151; margin-bottom: 6px; letter-spacing: 0.2px;
        }
        label span.req { color: #ea580c; }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        select, textarea {
            width: 100%; padding: 10px 14px;
            border: 1.5px solid #e5e7eb; border-radius: 9px;
            font-size: 13px; color: #1c1917; background: #fff; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
            min-height: 44px;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,0.08);
        }
        input:disabled { background: #f9fafb; color: #9ca3af; cursor: not-allowed; }
        textarea { resize: vertical; min-height: 90px; min-height: auto; }

        .input-error { border-color: #fca5a5 !important; }
        .err-msg {
            font-size: 11.5px; color: #dc2626; margin-top: 5px;
            display: flex; align-items: center; gap: 4px;
        }

        /* ── Toggle Card ── */
        .toggle-card {
            background: #fafafa; border: 1.5px solid #e5e7eb;
            border-radius: 12px; padding: 14px 16px; margin-bottom: 14px;
            transition: border-color 0.2s, background 0.2s;
        }
        .toggle-card.active { background: #fff7ed; border-color: #fed7aa; }
        .toggle-row  { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; }
        .toggle-info { flex: 1; }
        .toggle-title { font-size: 13px; font-weight: 700; color: #1c1917; margin-bottom: 3px; }
        .toggle-desc  { font-size: 12px; color: #6b7280; line-height: 1.5; }

        .switch { position: relative; display: inline-flex; align-items: center; cursor: pointer; flex-shrink: 0; margin-top: 2px; }
        .switch input { opacity: 0; width: 0; height: 0; position: absolute; }
        .switch-track {
            width: 44px; height: 24px; background: #d1d5db; border-radius: 24px;
            transition: background 0.2s; position: relative;
        }
        .switch-thumb {
            position: absolute; top: 3px; left: 3px;
            width: 18px; height: 18px; background: #fff; border-radius: 50%;
            transition: transform 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .switch input:checked ~ .switch-track { background: #ea580c; }
        .switch input:checked ~ .switch-track .switch-thumb { transform: translateX(20px); }

        /* ── Combobox ── */
        .cb-wrap { position: relative; }
        .cb-dropdown {
            display: none; position: absolute;
            top: calc(100% + 4px); left: 0; right: 0; width: 100%;
            z-index: 9998;
            background: #fff; border: 1.5px solid #e5e7eb; border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            max-height: 240px; overflow-y: auto;
        }
        .cb-dropdown.open { display: block; }
        .cb-opt {
            padding: 10px 14px; font-size: 13px; cursor: pointer;
            color: #374151; transition: background 0.1s;
            display: flex; align-items: flex-start; gap: 10px;
        }
        .cb-opt:hover, .cb-opt.focused { background: #fff7ed; }
        .cb-opt-sub  { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }
        .cb-opt-icon { flex-shrink: 0; margin-top: 1px; color: #9ca3af; }
        .cb-opt.create-new {
            color: #ea580c; font-weight: 600;
            border-top: 1px solid #f3f4f6; background: #fffbf7;
        }
        .cb-opt.create-new:hover { background: #fff7ed; }
        .cb-opt-empty { padding: 12px 14px; font-size: 12.5px; color: #9ca3af; text-align: center; cursor: default; }
        .cb-clear {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: #9ca3af; display: none;
            padding: 4px; transition: color 0.15s; z-index: 2;
        }
        .cb-clear:hover { color: #dc2626; }
        .cb-clear.visible { display: flex; }
        .cb-badge-new {
            font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 20px;
            background: #dcfce7; color: #16a34a; margin-left: 4px; flex-shrink: 0;
        }

        /* ── Contact Preview ── */
        .contact-preview {
            margin-top: 12px; padding: 12px 14px;
            background: #fafafa; border: 1.5px solid #e5e7eb; border-radius: 10px;
            display: none;
        }
        .contact-preview.visible { display: flex; align-items: center; gap: 12px; }
        .contact-avatar {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, #ea580c, #f97316);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .contact-preview-info { flex: 1; min-width: 0; }
        .contact-preview-name { font-size: 13px; font-weight: 600; color: #1c1917; }
        .contact-preview-pos  { font-size: 11.5px; color: #ea580c; font-weight: 600; margin-top: 2px; }
        .contact-preview-meta {
            display: flex; gap: 12px; margin-top: 5px;
            flex-wrap: wrap;
        }
        .contact-preview-meta span {
            font-size: 12px; color: #6b7280;
            display: flex; align-items: center; gap: 4px;
            word-break: break-all;
        }

        /* ── Package Picker ── */
        #admin-items-section {
            overflow: hidden; max-height: 0; opacity: 0;
            transition: max-height 0.35s ease, opacity 0.25s ease;
        }
        #admin-items-section.visible { max-height: 4000px; opacity: 1; }

        .cat-block { margin-bottom: 10px; border: 1.5px solid #e5e7eb; border-radius: 10px; overflow: hidden; }
        .cat-block.has-selected { border-color: #fed7aa; }
        .cat-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 11px 14px; background: #fafafa; cursor: pointer;
            user-select: none; transition: background 0.15s;
        }
        .cat-block.has-selected .cat-header { background: #fff7ed; }
        .cat-header:hover { background: #f3f4f6; }
        .cat-block.has-selected .cat-header:hover { background: #ffedd5; }
        .cat-header-left { display: flex; align-items: center; gap: 10px; }
        .cat-name  { font-size: 13px; font-weight: 700; color: #1c1917; }
        .cat-badge {
            font-size: 11px; font-weight: 600; padding: 2px 8px;
            border-radius: 20px; background: #f3f4f6; color: #6b7280; transition: all 0.15s;
        }
        .cat-block.has-selected .cat-badge { background: #ea580c; color: #fff; }
        .cat-chevron { width: 16px; height: 16px; color: #9ca3af; transition: transform 0.2s; flex-shrink: 0; }
        .cat-block.open .cat-chevron { transform: rotate(180deg); }
        .cat-body { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .cat-block.open .cat-body { max-height: 2000px; border-top: 1px solid #f3f4f6; }

        /* ── Package Items ── */
        .pkg-list { padding: 8px 10px; display: flex; flex-direction: column; gap: 6px; }
        .pkg-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px;
            border: 1.5px solid transparent; background: #fafafa;
            transition: all 0.15s; cursor: pointer;
            flex-wrap: wrap;
        }
        .pkg-item:hover    { background: #fff7ed; border-color: #fed7aa; }
        .pkg-item.selected { background: #fff7ed; border-color: #ea580c; }
        .pkg-check {
            width: 18px; height: 18px; flex-shrink: 0;
            border: 1.5px solid #d1d5db; border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s; background: #fff;
        }
        .pkg-item.selected .pkg-check { background: #ea580c; border-color: #ea580c; }
        .pkg-info  { flex: 1; min-width: 0; }
        .pkg-name  { font-size: 13px; font-weight: 600; color: #1c1917; }
        .pkg-desc  {
            font-size: 11.5px; color: #9ca3af; margin-top: 1px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            max-width: 280px;
        }
        .pkg-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

        .pkg-price-wrap   { display: flex; flex-direction: column; align-items: flex-end; gap: 2px; }
        .pkg-price-label  { font-size: 10px; color: #9ca3af; font-weight: 500; letter-spacing: 0.3px; display: none; }
        .pkg-item.selected .pkg-price-label { display: block; }
        .pkg-price-input {
            width: 110px; padding: 5px 8px; border: 1.5px solid transparent;
            border-radius: 6px; font-size: 13px; font-weight: 700; color: #ea580c;
            background: transparent; outline: none; text-align: right;
            cursor: default; transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
            min-height: auto;
        }
        .pkg-item.selected .pkg-price-input { border-color: #fed7aa; background: #fff; cursor: text; }
        .pkg-item.selected .pkg-price-input:focus { border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,0.08); }
        .pkg-price-input::-webkit-outer-spin-button,
        .pkg-price-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .pkg-price-input[type=number] { -moz-appearance: textfield; }
        .pkg-price-changed { font-size: 10px; color: #9ca3af; text-decoration: line-through; display: none; text-align: right; }
        .pkg-item.selected .pkg-price-changed.visible { display: block; }

        .pkg-qty-wrap { display: none; align-items: center; gap: 6px; }
        .pkg-item.selected .pkg-qty-wrap { display: flex; }
        .qty-btn {
            width: 28px; height: 28px; border-radius: 6px; border: 1.5px solid #e5e7eb;
            background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: #374151; transition: all 0.15s;
            padding: 0; line-height: 1;
        }
        .qty-btn:hover { border-color: #ea580c; color: #ea580c; background: #fff7ed; }
        .qty-val {
            width: 36px; text-align: center; font-size: 13px; font-weight: 700;
            color: #1c1917; border: none; background: transparent; outline: none; padding: 0;
            min-height: auto;
        }
        .qty-val::-webkit-outer-spin-button,
        .qty-val::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .qty-val[type=number] { -moz-appearance: textfield; }

        /* ── Subtotal Bar ── */
        .subtotal-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 16px; background: #fafafa; border-top: 1px solid #f3f4f6;
            margin-top: 4px;
        }
        .subtotal-info   { font-size: 12px; color: #6b7280; }
        .subtotal-info strong { color: #1c1917; }
        .subtotal-amount { font-size: 15px; font-weight: 700; color: #ea580c; }
        .pkg-empty { padding: 20px 16px; font-size: 12.5px; color: #9ca3af; text-align: center; }

        /* ── Info Box ── */
        .info-box {
            background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px;
            padding: 12px 14px; font-size: 12px; color: #92400e; margin-bottom: 14px;
            display: flex; gap: 8px; align-items: flex-start; line-height: 1.6;
        }

        /* ── Summary ── */
        .summary-section { margin-bottom: 16px; }
        .summary-title {
            font-size: 10.5px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.6px; color: #9ca3af; margin-bottom: 10px;
        }
        .summary-item  { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 7px; gap: 8px; }
        .summary-key   { font-size: 12.5px; color: #6b7280; flex-shrink: 0; }
        .summary-val   { font-size: 12.5px; font-weight: 600; color: #1c1917; text-align: right; }
        .divider       { border: none; border-top: 1px solid #f3f4f6; margin: 14px 0; }
        .total-row     { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .total-label   { font-size: 14px; font-weight: 700; color: #1c1917; }
        .total-val     { font-size: 20px; font-weight: 700; color: #ea580c; }

        /* ── Mode Badge ── */
        .mode-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .mode-badge.guest { background: #f0fdf4; color: #16a34a; }
        .mode-badge.admin { background: #fff7ed; color: #ea580c; }

        /* ── Sum Contact Box ── */
        .sum-contact-box {
            display: flex; align-items: center; gap: 10px; padding: 10px 12px;
            background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; margin-top: 4px;
        }
        .sum-contact-avatar {
            width: 32px; height: 32px; border-radius: 8px;
            background: linear-gradient(135deg, #ea580c, #f97316);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .sum-contact-name { font-size: 13px; font-weight: 600; color: #1c1917; }
        .sum-contact-sub  { font-size: 11.5px; color: #9ca3af; margin-top: 1px; }

        #sum-items-list { list-style: none; padding: 0; margin: 0; }
        #sum-items-list li {
            display: flex; justify-content: space-between; align-items: baseline;
            font-size: 12px; padding: 4px 0; border-bottom: 1px dashed #f3f4f6;
            gap: 8px;
        }
        #sum-items-list li:last-child { border-bottom: none; }
        .si-name  { color: #6b7280; }
        .si-price { font-weight: 600; color: #1c1917; flex-shrink: 0; }

        /* ── Submit Button ── */
        .btn-submit {
            width: 100%; padding: 13px; background: #ea580c; color: #fff;
            border: none; border-radius: 10px; font-size: 14px; font-weight: 700;
            cursor: pointer; transition: all 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            min-height: 48px;
        }
        .btn-submit:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(234,88,12,0.3); }
        .btn-submit:active { transform: translateY(0); }

        .cancel-link {
            display: block; text-align: center; margin-top: 12px;
            font-size: 13px; color: #9ca3af; text-decoration: none;
        }
        .cancel-link:hover { color: #6b7280; }

        /* ── Modal Quick-Create ── */
        .qc-modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.45);
            z-index: 9999; display: flex; align-items: center; justify-content: center;
            padding: 16px;
        }
        .qc-modal {
            background: #fff; border-radius: 16px; padding: 24px;
            width: 100%; max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            animation: modalIn 0.18s ease;
        }
        @keyframes modalIn {
            from { opacity:0; transform: scale(0.96) translateY(8px); }
            to   { opacity:1; transform: none; }
        }
        .qc-modal-title {
            font-size: 14.5px; font-weight: 700; margin-bottom: 18px;
            color: #1c1917; display: flex; align-items: center; gap: 8px;
        }
        .qc-modal-footer { display: flex; gap: 10px; margin-top: 18px; }
        .btn-qc-save {
            flex: 1; padding: 10px; background: #ea580c; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 700;
            cursor: pointer; transition: background 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
            min-height: 44px;
        }
        .btn-qc-save:hover { background: #c2410c; }
        .btn-qc-cancel {
            padding: 10px 16px; background: #f3f4f6; color: #6b7280;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; transition: background 0.15s; min-height: 44px;
        }
        .btn-qc-cancel:hover { background: #e5e7eb; }
        .btn-loading { opacity: 0.65; pointer-events: none; }

        /* ── Sidebar summary on mobile: show above main on small screens ── */
        .sidebar-first { order: -1; }
        @media (min-width: 960px) {
            .sidebar-first { order: unset; }
        }
    </style>

    <a href="{{ route('admin.orders.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Order List
    </a>

    @if($errors->any())
        <div class="alert alert-danger">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            Mohon periksa kembali inputan di bawah.
        </div>
    @endif

    <form action="{{ route('admin.orders.store') }}" method="POST" id="orderForm">
        @csrf
        <input type="hidden" name="filled_by"   id="filled_by"         value="customer">
        <input type="hidden" name="company_id"  id="hidden_company_id" value="{{ old('company_id') }}">
        <input type="hidden" name="contact_id"  id="hidden_contact_id" value="{{ old('contact_id') }}">

        <div class="form-layout">

            {{-- ══════════ LEFT / MAIN ══════════ --}}
            <div class="form-main">

                {{-- Toggle --}}
                <div class="toggle-card" id="toggleCard">
                    <div class="toggle-row">
                        <div class="toggle-info">
                            <div class="toggle-title">Item Layanan Diisi oleh Admin</div>
                            <div class="toggle-desc" id="toggleDesc">
                                Nonaktif — Customer akan mengisi item sendiri melalui halaman keranjang menggunakan token.
                            </div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" id="adminFillToggle" {{ old('filled_by') === 'admin' ? 'checked' : '' }}>
                            <span class="switch-track"><span class="switch-thumb"></span></span>
                        </label>
                    </div>
                </div>

                {{-- Customer Info --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-title">Informasi Customer</div>
                            <div class="card-subtitle">Cari atau buat perusahaan / kontak baru</div>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Company --}}
                        <div class="form-group">
                            <label>Perusahaan <span class="req">*</span></label>
                            <div class="cb-wrap" id="companyComboWrap">
                                <input type="text" id="companyInput" autocomplete="off"
                                    placeholder="Cari atau ketik nama perusahaan…"
                                    class="{{ $errors->has('company_id') ? 'input-error' : '' }}"
                                    oninput="cbFilter('company')"
                                    onfocus="cbOpen('company')"
                                    onkeydown="cbKeydown(event,'company')">
                                <span class="cb-clear" id="companyClearBtn" onclick="clearCompany()" title="Reset pilihan">
                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </span>
                                <div class="cb-dropdown" id="companyDropdown"></div>
                            </div>
                            @error('company_id')
                                <div class="err-msg">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Contact --}}
                        <div class="form-group">
                            <label>PIC / Kontak <span class="req">*</span></label>
                            <div class="cb-wrap" id="contactComboWrap">
                                <input type="text" id="contactInput" autocomplete="off"
                                    placeholder="— Pilih dulu perusahaan —"
                                    disabled
                                    class="{{ $errors->has('contact_id') ? 'input-error' : '' }}"
                                    oninput="cbFilter('contact')"
                                    onfocus="cbOpen('contact')"
                                    onkeydown="cbKeydown(event,'contact')">
                                <div class="cb-dropdown" id="contactDropdown"></div>
                            </div>
                            @error('contact_id')
                                <div class="err-msg">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="contact-preview" id="contactPreview">
                                <div class="contact-avatar" id="previewAvatar">--</div>
                                <div class="contact-preview-info">
                                    <div class="contact-preview-name" id="previewName"></div>
                                    <div class="contact-preview-pos"  id="previewPos"></div>
                                    <div class="contact-preview-meta">
                                        <span id="previewEmail" style="display:none;">
                                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            <span id="previewEmailText"></span>
                                        </span>
                                        <span id="previewPhone" style="display:none;">
                                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            <span id="previewPhoneText"></span>
                                        </span>
                                        <span id="previewJabatan" style="display:none;">
                                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            <span id="previewJabatanText"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Detail Pengujian (muncul hanya jika mode admin) --}}
                <div class="card admin-only-card" id="pengujianCard" style="display:none;">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-title">Detail Pengujian</div>
                            <div class="card-subtitle">Informasi tambahan terkait keperluan order ini</div>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Tujuan Pengujian --}}
                        <div class="form-group">
                            <label>Tujuan Pengujian <span class="req">*</span></label>
                            <textarea name="tujuan_pengujian" id="tujuan_pengujian" rows="3"
                                placeholder="Contoh: Pengujian mutu produk untuk sertifikasi SNI…"
                                class="{{ $errors->has('tujuan_pengujian') ? 'input-error' : '' }}"
                                style="width:100%;resize:vertical;">{{ old('tujuan_pengujian') }}</textarea>
                            @error('tujuan_pengujian')
                                <div class="err-msg">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Waktu Diharapkan --}}
                        <div class="form-group">
                            <label>Waktu Penyelesaian Diharapkan <span class="req">*</span></label>
                            <input type="date" name="waktu_diharapkan" id="waktu_diharapkan"
                                value="{{ old('waktu_diharapkan') }}"
                                min="{{ date('Y-m-d') }}"
                                class="{{ $errors->has('waktu_diharapkan') ? 'input-error' : '' }}"
                                style="width:100%;">
                            @error('waktu_diharapkan')
                                <div class="err-msg">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Keterangan Tambahan --}}
                        <div class="form-group" style="margin-bottom:0;">
                            <label>Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" id="keterangan_tambahan" rows="3"
                                placeholder="Catatan khusus, kondisi sampel, atau permintaan lainnya…"
                                class="{{ $errors->has('keterangan_tambahan') ? 'input-error' : '' }}"
                                style="width:100%;resize:vertical;">{{ old('keterangan_tambahan') }}</textarea>
                            @error('keterangan_tambahan')
                                <div class="err-msg">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- PIC Internal --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-title">PIC Internal</div>
                            <div class="card-subtitle">Staff yang bertanggung jawab atas order ini</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>PIC <span class="req">*</span></label>
                            <div class="cb-wrap" id="picComboWrap">
                                <input type="text" id="picInput" autocomplete="off"
                                    placeholder="Cari nama PIC…"
                                    class="{{ $errors->has('pic_id') ? 'input-error' : '' }}"
                                    oninput="cbFilter('pic')"
                                    onfocus="cbOpen('pic')"
                                    onkeydown="cbKeydown(event,'pic')">
                                <span class="cb-clear" id="picClearBtn" onclick="clearPic()" title="Reset pilihan" style="display:none;">
                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </span>
                                <div class="cb-dropdown" id="picDropdown"></div>
                            </div>
                            <input type="hidden" name="pic_id" id="hidden_pic_id">
                            @error('pic_id')
                                <div class="err-msg">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="contact-preview" id="picPreview" style="display:none; margin-top:10px;">
                                <div class="contact-avatar" id="picPreviewAvatar">--</div>
                                <div class="contact-preview-info">
                                    <div class="contact-preview-name" id="picPreviewName"></div>
                                    <div class="contact-preview-meta">
                                        <span id="picPreviewEmail" style="display:none;">
                                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <span id="picPreviewEmailText"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Package Picker (admin mode) --}}
                <div id="admin-items-section">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-icon">
                                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <div class="card-title">Pilih Paket Layanan</div>
                                <div class="card-subtitle">Klik paket untuk memilih — harga otomatis dari base_price</div>
                            </div>
                        </div>

                        <div style="padding: 14px 16px 8px;" id="categoriesContainer">
                            <div class="pkg-empty">Memuat daftar paket…</div>
                        </div>

                        <div class="subtotal-bar">
                            <div class="subtotal-info"><strong id="selectedCount">0</strong> paket dipilih</div>
                            <div class="subtotal-amount" id="subtotalDisplay">Rp 0</div>
                        </div>
                    </div>
                </div>

            </div>{{-- end .form-main --}}

            {{-- ══════════ RIGHT / SIDEBAR ══════════ --}}
            <div class="form-sidebar">
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <div class="card-title">Ringkasan Order</div>
                            <div class="card-subtitle">Preview sebelum submit</div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="info-box">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            <span id="infoBoxText">Order dibuat dengan status <strong>Draft</strong> dan token otomatis dibuat. Item layanan masih kosong dan akan dipilih oleh customer (guest) saat membuka halaman keranjang menggunakan token tersebut.</span>
                        </div>

                        {{-- Customer summary --}}
                        <div class="summary-section">
                            <div class="summary-title">Customer</div>
                            <div class="summary-item">
                                <span class="summary-key">Perusahaan</span>
                                <span class="summary-val" id="sum-company">—</span>
                            </div>
                            <div id="sum-contact-wrap">
                                <div style="font-size:12px;color:#9ca3af;font-style:italic;">Belum ada kontak dipilih.</div>
                            </div>
                            <div class="summary-item" style="margin-top:8px;">
                                <span class="summary-key">Mode</span>
                                <span id="sum-mode"><span class="mode-badge guest">Guest mengisi sendiri</span></span>
                            </div>
                        </div>

                        <hr class="divider">

                        <div class="summary-section">
                            <div class="summary-title">Paket Dipilih</div>
                            <div id="sum-items-content">
                                <div style="font-size:12px;color:#6b7280;line-height:1.8;font-style:italic;">
                                    Akan diisi oleh customer melalui halaman keranjang.
                                </div>
                            </div>
                        </div>

                        <hr class="divider">

                        <div class="total-row">
                            <span class="total-label">Total</span>
                            <span class="total-val" id="sum-total">—</span>
                        </div>

                        <button type="submit" class="btn-submit">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Buat Order
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="cancel-link">Batal</a>

                    </div>
                </div>
            </div>{{-- end .form-sidebar --}}

        </div>{{-- end .form-layout --}}
    </form>

    <script>
        // ─── Data dari Laravel ─────────────────────────────────────────────────────
        const CATEGORIES     = @json($categories ?? []);
        const COMPANIES_DATA = @json($companiesData);
        const PICS_DATA      = @json($pics);

        const OLD_COMPANY_ID = {{ old('company_id', 'null') }};
        const OLD_CONTACT_ID = {{ old('contact_id', 'null') }};
        const OLD_PIC_ID     = {{ old('pic_id',     'null') }};

        const ROUTE_COMPANY_QC = "{{ route('admin.companies.quick-create') }}";
        const ROUTE_CONTACT_QC = "{{ route('admin.contacts.quick-create') }}";
        const CSRF_TOKEN       = "{{ csrf_token() }}";

        // ─── Helpers ───────────────────────────────────────────────────────────────
        const fmt = v => 'Rp ' + (isNaN(v) || !v ? 0 : Number(v)).toLocaleString('id-ID');

        function escHtml(s) {
            return String(s ?? '')
                .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
                .replace(/"/g,'&quot;').replace(/'/g,'&#39;');
        }

        function initials(name) {
            return String(name ?? '').split(' ').slice(0,2).map(w => w[0] ?? '').join('').toUpperCase() || '?';
        }

        // ─── Package State ─────────────────────────────────────────────────────────
        const selected = {};
        let currentContact      = null;
        let currentCompanyName  = '';

        // ─── Combobox State ────────────────────────────────────────────────────────
        const CB = {
            company: { input: null, dropdown: null, selected: null, focusIdx: -1 },
            contact: { input: null, dropdown: null, selected: null, focusIdx: -1 },
            pic:     { input: null, dropdown: null, selected: null, focusIdx: -1 },
        };

        // ─── Init ──────────────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            CB.company.input    = document.getElementById('companyInput');
            CB.company.dropdown = document.getElementById('companyDropdown');
            CB.contact.input    = document.getElementById('contactInput');
            CB.contact.dropdown = document.getElementById('contactDropdown');
            CB.pic.input        = document.getElementById('picInput');
            CB.pic.dropdown     = document.getElementById('picDropdown');

            // PERBAIKAN: Semua dropdown TIDAK dipindah ke body.
            // Dropdown tetap di dalam .cb-wrap masing-masing dengan position: absolute.
            // Tidak perlu appendChild ke body sama sekali.

            document.addEventListener('click', e => {
                if (!e.target.closest('#companyComboWrap')) cbClose('company');
                if (!e.target.closest('#contactComboWrap')) cbClose('contact');
                if (!e.target.closest('#picComboWrap'))     cbClose('pic');
            });

            buildCategories();
            applyToggleState(document.getElementById('adminFillToggle').checked);

            if (OLD_COMPANY_ID) restoreOldValues();
            if (OLD_PIC_ID)     restoreOldPic();
        });

        // ─── Combobox: open / close / filter ──────────────────────────────────────
        // PERBAIKAN: cbPositionDropdown dihapus sepenuhnya.
        // Dropdown sudah otomatis muncul tepat di bawah input berkat position: absolute + top: calc(100% + 4px).

        function cbOpen(type) {
            if (type === 'contact' && CB.contact.input.disabled) return;
            CB[type].dropdown.classList.add('open');
            if      (type === 'company') renderCompanyDropdown();
            else if (type === 'contact') renderContactDropdown();
            else if (type === 'pic')     renderPicDropdown();
        }

        function cbClose(type) {
            CB[type].dropdown.classList.remove('open');
            CB[type].focusIdx = -1;
            // Jika user hapus teks tapi sudah ada pilihan, kembalikan teks
            if (CB[type].selected && CB[type].input) {
                CB[type].input.value = CB[type].selected.name;
            }
        }

        function cbFilter(type) {
            if (type === 'contact' && CB.contact.input.disabled) return;
            CB[type].dropdown.classList.add('open');
            if      (type === 'company') renderCompanyDropdown();
            else if (type === 'contact') renderContactDropdown();
            else if (type === 'pic')     renderPicDropdown();
        }

        function cbKeydown(e, type) {
            const opts = [...CB[type].dropdown.querySelectorAll('.cb-opt')];
            if (!opts.length) return;
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                CB[type].focusIdx = Math.min(CB[type].focusIdx + 1, opts.length - 1);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                CB[type].focusIdx = Math.max(CB[type].focusIdx - 1, 0);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (CB[type].focusIdx >= 0) opts[CB[type].focusIdx].click();
                return;
            } else if (e.key === 'Escape') {
                cbClose(type);
                return;
            }
            opts.forEach((o, i) => o.classList.toggle('focused', i === CB[type].focusIdx));
            opts[CB[type].focusIdx]?.scrollIntoView({ block: 'nearest' });
        }

        // PERBAIKAN: Tidak perlu scroll/resize listener untuk reposition dropdown
        // karena dropdown sudah absolute dan otomatis mengikuti posisi parent-nya.

        // ─── Company Dropdown ──────────────────────────────────────────────────────
        function renderCompanyDropdown() {
            const q       = (CB.company.input.value || '').toLowerCase().trim();
            const matches = q
                ? COMPANIES_DATA.filter(c => c.name.toLowerCase().includes(q))
                : COMPANIES_DATA;

            let html = '';
            matches.slice(0, 20).forEach((c, i) => {
                html += `
                    <div class="cb-opt" data-idx="${i}" onclick="selectCompany(${c.id})">
                        <svg class="cb-opt-icon" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                        </svg>
                        <div>
                            <div>${escHtml(c.name)}</div>
                            <div class="cb-opt-sub">${c.contacts.length} kontak</div>
                        </div>
                    </div>`;
            });

            const exact = COMPANIES_DATA.some(c => c.name.toLowerCase() === q);
            if (q && !exact) {
                html += `
                    <div class="cb-opt create-new" onclick="quickCreateCompany()">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat perusahaan &ldquo;<strong>${escHtml(CB.company.input.value)}</strong>&rdquo;
                    </div>`;
            }

            if (!html) {
                html = '<div class="cb-opt-empty">Tidak ada hasil. Ketik nama untuk membuat baru.</div>';
            }
            CB.company.dropdown.innerHTML = html;
        }

        function selectCompany(id) {
            const co = COMPANIES_DATA.find(c => c.id === id);
            if (!co) return;

            CB.company.selected     = co;
            CB.company.input.value  = co.name;
            document.getElementById('hidden_company_id').value = co.id;
            document.getElementById('companyClearBtn').classList.add('visible');
            cbClose('company');

            clearContact();
            CB.contact.input.disabled    = false;
            CB.contact.input.placeholder = '— Cari atau tambah kontak baru —';

            currentCompanyName = co.name;
            document.getElementById('sum-company').textContent = co.name;
            updateSummary();
        }

        async function quickCreateCompany() {
            const name = CB.company.input.value.trim();
            if (!name) return;

            const btn = CB.company.dropdown.querySelector('.create-new');
            if (btn) btn.innerHTML = '<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="animation:spin .7s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Menyimpan…';

            try {
                const res  = await fetch(ROUTE_COMPANY_QC, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                    body: JSON.stringify({ name }),
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.message || 'Gagal menyimpan');

                const newCo = { id: data.id, name: data.name, contacts: data.contacts || [] };
                COMPANIES_DATA.unshift(newCo);
                selectCompany(newCo.id);
            } catch (err) {
                alert('Gagal membuat perusahaan: ' + err.message);
                renderCompanyDropdown();
            }
        }

        function clearCompany() {
            CB.company.selected    = null;
            CB.company.input.value = '';
            document.getElementById('hidden_company_id').value = '';
            document.getElementById('companyClearBtn').classList.remove('visible');
            clearContact();
            CB.contact.input.disabled    = true;
            CB.contact.input.placeholder = '— Pilih dulu perusahaan —';
            currentCompanyName = '';
            document.getElementById('sum-company').textContent = '—';
            updateSummary();
        }

        // ─── Contact Dropdown ──────────────────────────────────────────────────────
        function renderContactDropdown() {
            if (!CB.company.selected) return;
            const contacts = CB.company.selected.contacts || [];
            const q        = (CB.contact.input.value || '').toLowerCase().trim();
            const matches  = q
                ? contacts.filter(c =>
                    c.name.toLowerCase().includes(q) ||
                    (c.email || '').toLowerCase().includes(q) ||
                    (c.phone || '').toLowerCase().includes(q))
                : contacts;

            let html = '';

            if (!matches.length && !q) {
                html += '<div class="cb-opt-empty" style="padding-bottom:0">Belum ada kontak untuk perusahaan ini.</div>';
            }

            matches.slice(0, 20).forEach((c, i) => {
                html += `
                    <div class="cb-opt" data-idx="${i}" onclick="selectContact(${c.id})">
                        <svg class="cb-opt-icon" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <div>${escHtml(c.name)}</div>
                            ${c.email ? `<div class="cb-opt-sub">${escHtml(c.email)}</div>` : ''}
                        </div>
                    </div>`;
            });

            const exact = contacts.some(c => c.name.toLowerCase() === q);
            if (!exact) {
                html += `
                    <div class="cb-opt create-new" onclick="openContactModal('${escHtml(CB.contact.input.value)}')">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        ${q ? `Tambah kontak &ldquo;<strong>${escHtml(CB.contact.input.value)}</strong>&rdquo;` : '+ Tambah kontak baru'}
                    </div>`;
            }

            CB.contact.dropdown.innerHTML = html;
        }

        function selectContact(id) {
            const co = CB.company.selected;
            if (!co) return;
            const contact = co.contacts.find(c => c.id === id);
            if (!contact) return;

            CB.contact.selected     = contact;
            CB.contact.input.value  = contact.name;
            document.getElementById('hidden_contact_id').value = contact.id;
            cbClose('contact');

            currentContact = contact;
            showContactPreview(contact);
            updateSummary();
        }

        function clearContact() {
            CB.contact.selected = null;
            currentContact      = null;
            if (CB.contact.input) CB.contact.input.value = '';
            document.getElementById('hidden_contact_id').value = '';
            hideContactPreview();
            document.getElementById('sum-contact-wrap').innerHTML =
                '<div style="font-size:12px;color:#9ca3af;font-style:italic;">Belum ada kontak dipilih.</div>';
        }

        // ─── PIC Dropdown ──────────────────────────────────────────────────────────
        function renderPicDropdown() {
            const q       = (CB.pic.input.value || '').toLowerCase().trim();
            const matches = q
                ? PICS_DATA.filter(p => p.name.toLowerCase().includes(q) || (p.email || '').toLowerCase().includes(q))
                : PICS_DATA;

            let html = '';
            matches.slice(0, 20).forEach((p, i) => {
                html += `
                    <div class="cb-opt" data-idx="${i}" onclick="selectPic(${p.id})">
                        <svg class="cb-opt-icon" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <div>${escHtml(p.name)}</div>
                            ${p.email ? `<div class="cb-opt-sub">${escHtml(p.email)}</div>` : ''}
                        </div>
                    </div>`;
            });

            if (!html) {
                html = '<div class="cb-opt-empty">Tidak ada PIC ditemukan.</div>';
            }
            CB.pic.dropdown.innerHTML = html;
        }

        function selectPic(id) {
            const pic = PICS_DATA.find(p => p.id === id);
            if (!pic) return;

            CB.pic.selected    = pic;
            CB.pic.input.value = pic.name;
            document.getElementById('hidden_pic_id').value = pic.id;
            document.getElementById('picClearBtn').style.display = 'flex';
            cbClose('pic');

            showPicPreview(pic);
        }

        function clearPic() {
            CB.pic.selected    = null;
            CB.pic.input.value = '';
            document.getElementById('hidden_pic_id').value = '';
            document.getElementById('picClearBtn').style.display = 'none';
            hidePicPreview();
        }

        // ─── Modal: Tambah kontak baru ─────────────────────────────────────────────
        function openContactModal(prefillName) {
            cbClose('contact');
            if (document.getElementById('qcContactModal')) return;

            const overlay = document.createElement('div');
            overlay.className = 'qc-modal-overlay';
            overlay.id        = 'qcContactModal';
            overlay.innerHTML = `
                <div class="qc-modal" onclick="event.stopPropagation()">
                    <div class="qc-modal-header">
                        <div class="qc-modal-title">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span>Tambah Kontak Baru</span>
                        </div>
                    </div>
                    <div class="qc-modal-body">
                        <div class="form-group">
                            <label>Nama <span class="req">*</span></label>
                            <input type="text" id="qc-name" value="${escHtml(prefillName)}" placeholder="Nama lengkap kontak">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>No. HP / WA</label>
                                <input type="text" id="qc-phone" placeholder="08xx…">
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" id="qc-jabatan" placeholder="Jabatan kontak">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="qc-email" placeholder="email@perusahaan.com">
                        </div>
                    </div>
                    <div class="qc-modal-footer">
                        <button type="button" class="btn-qc-cancel" onclick="closeContactModal()">Batal</button>
                        <button type="button" class="btn-qc-save" id="qcSaveBtn" onclick="saveNewContact()">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan
                        </button>
                    </div>
                </div>`;

            overlay.addEventListener('click', closeContactModal);
            document.body.appendChild(overlay);
            setTimeout(() => document.getElementById('qc-name')?.focus(), 50);
        }

        function closeContactModal() {
            document.getElementById('qcContactModal')?.remove();
        }

        async function saveNewContact() {
            const nameInput = document.getElementById('qc-name');
            const name      = nameInput?.value.trim() ?? '';
            if (!name) {
                if (nameInput) { nameInput.focus(); nameInput.style.borderColor = '#fca5a5'; }
                return;
            }

            const btn = document.getElementById('qcSaveBtn');
            btn.innerHTML = '<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="animation:spin .7s linear infinite"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Menyimpan…';
            btn.classList.add('btn-loading');

            const payload = {
                company_id: CB.company.selected.id,
                name,
                phone:   document.getElementById('qc-phone').value.trim()   || null,
                email:   document.getElementById('qc-email').value.trim()   || null,
                jabatan: document.getElementById('qc-jabatan').value.trim() || null,
            };

            try {
                const res  = await fetch(ROUTE_CONTACT_QC, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                    body: JSON.stringify(payload),
                });
                const data = await res.json();
                if (!res.ok) {
                    const errMsg = data.errors
                        ? Object.values(data.errors)[0]?.[0]
                        : (data.message || 'Gagal menyimpan');
                    throw new Error(errMsg);
                }

                CB.company.selected.contacts.unshift(data);
                const co = COMPANIES_DATA.find(c => c.id === CB.company.selected.id);
                if (co) co.contacts.unshift(data);

                closeContactModal();
                selectContact(data.id);
            } catch (err) {
                alert('Gagal menyimpan kontak: ' + err.message);
                btn.innerHTML = '<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Simpan';
                btn.classList.remove('btn-loading');
            }
        }

        // ─── Contact Preview ───────────────────────────────────────────────────────
        function showContactPreview(c) {
            document.getElementById('contactPreview').classList.add('visible');
            document.getElementById('previewAvatar').textContent = initials(c.name);
            document.getElementById('previewName').textContent   = c.name;
            document.getElementById('previewPos').textContent    = c.jabatan ?? '';

            const toggle = (wrapId, textId, val) => {
                const el = document.getElementById(wrapId);
                if (val) { el.style.display = ''; document.getElementById(textId).textContent = val; }
                else el.style.display = 'none';
            };
            toggle('previewJabatan', 'previewJabatanText', c.jabatan);
            toggle('previewEmail',   'previewEmailText',   c.email);
            toggle('previewPhone',   'previewPhoneText',   c.phone);

            document.getElementById('sum-contact-wrap').innerHTML = `
                <div class="sum-contact-box">
                    <div class="sum-contact-avatar">${escHtml(initials(c.name))}</div>
                    <div>
                        <div class="sum-contact-name">${escHtml(c.name)}</div>
                        <div class="sum-contact-sub">${escHtml(c.email || c.phone || 'Kontak')}</div>
                        <div class="sum-contact-pos">${escHtml(c.jabatan || '')}</div>
                    </div>
                </div>`;
        }

        function hideContactPreview() {
            document.getElementById('contactPreview').classList.remove('visible');
        }

        // ─── PIC Preview ───────────────────────────────────────────────────────────
        function showPicPreview(p) {
            const preview = document.getElementById('picPreview');
            preview.style.display = 'flex';
            document.getElementById('picPreviewAvatar').textContent = initials(p.name);
            document.getElementById('picPreviewName').textContent   = p.name;

            const emailEl = document.getElementById('picPreviewEmail');
            if (p.email) {
                document.getElementById('picPreviewEmailText').textContent = p.email;
                emailEl.style.display = 'inline-flex';
            } else {
                emailEl.style.display = 'none';
            }
        }

        function hidePicPreview() {
            document.getElementById('picPreview').style.display = 'none';
        }

        // ─── Restore old() setelah validation error ────────────────────────────────
        function restoreOldValues() {
            const co = COMPANIES_DATA.find(c => c.id == OLD_COMPANY_ID);
            if (!co) return;
            selectCompany(co.id);
            if (OLD_CONTACT_ID) {
                const ct = co.contacts.find(c => c.id == OLD_CONTACT_ID);
                if (ct) selectContact(ct.id);
            }
        }

        function restoreOldPic() {
            const pic = PICS_DATA.find(p => p.id == OLD_PIC_ID);
            if (pic) selectPic(pic.id);
        }

        // ─── Build Categories ──────────────────────────────────────────────────────
        function buildCategories() {
            const container = document.getElementById('categoriesContainer');
            const activeCats = CATEGORIES.filter(c => (c.packages || []).length > 0);
            if (!activeCats.length) {
                container.innerHTML = '<div class="pkg-empty">Tidak ada paket aktif tersedia.</div>';
                return;
            }
            container.innerHTML = '';
            activeCats.forEach((cat, ci) => {
                const block = document.createElement('div');
                block.className = 'cat-block' + (ci === 0 ? ' open' : '');
                block.id        = 'catblock-' + cat.category_id;
                block.innerHTML = `
                    <div class="cat-header" onclick="toggleCat('catblock-${cat.category_id}')">
                        <div class="cat-header-left">
                            <span class="cat-name">${escHtml(cat.nama_category)}</span>
                            <span class="cat-badge" id="catbadge-${cat.category_id}">${cat.packages.length} paket</span>
                        </div>
                        <svg class="cat-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div class="cat-body">
                        <div class="pkg-list" id="pkglist-${cat.category_id}"></div>
                    </div>`;
                container.appendChild(block);
                const list = block.querySelector('.pkg-list');
                cat.packages.forEach(pkg => list.appendChild(makePkgItem(pkg, cat.category_id)));
            });
        }

        function makePkgItem(pkg, catId) {
            const el = document.createElement('div');
            el.className       = 'pkg-item';
            el.id              = 'pkgitem-' + pkg.id;
            el.dataset.catId   = catId;
            el.dataset.basePrice = pkg.base_price;
            el.innerHTML = `
                <div class="pkg-check" id="pkgcheck-${pkg.id}">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="3"
                        id="pkgchksvg-${pkg.id}" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="pkg-info">
                    <div class="pkg-name">${escHtml(pkg.name)}</div>
                    ${pkg.description ? `<div class="pkg-desc">${escHtml(pkg.description)}</div>` : ''}
                </div>
                <div class="pkg-right">
                    <div class="pkg-qty-wrap" id="pkgqty-${pkg.id}">
                        <button type="button" class="qty-btn" onclick="chQty(${pkg.id},-1,event)">&#8722;</button>
                        <input class="qty-val" type="number" min="1" value="1"
                            id="qtyinp-${pkg.id}"
                            oninput="onQtyInput(${pkg.id})"
                            onclick="event.stopPropagation()">
                        <button type="button" class="qty-btn" onclick="chQty(${pkg.id},+1,event)">+</button>
                    </div>
                    <div class="pkg-price-wrap">
                        <span class="pkg-price-label">Harga/unit</span>
                        <input class="pkg-price-input" type="number" min="0" step="1000"
                            id="priceinp-${pkg.id}"
                            value="${parseFloat(pkg.base_price) || 0}"
                            data-base="${parseFloat(pkg.base_price) || 0}"
                            oninput="onPriceInput(${pkg.id})"
                            onclick="event.stopPropagation()"
                            title="Klik untuk ubah harga">
                        <span class="pkg-price-changed" id="pricechanged-${pkg.id}">${fmt(pkg.base_price)} (default)</span>
                    </div>
                </div>`;
            el.addEventListener('click', () => togglePkg(pkg.id, pkg.name, pkg.base_price, catId));
            return el;
        }

        function toggleCat(blockId) { document.getElementById(blockId).classList.toggle('open'); }

        function togglePkg(pkgId, name, basePrice, catId) {
            const el = document.getElementById('pkgitem-' + pkgId);
            if (selected[pkgId]) {
                delete selected[pkgId];
                el.classList.remove('selected');
                document.getElementById('pkgchksvg-' + pkgId).style.display = 'none';
                const pinp = document.getElementById('priceinp-' + pkgId);
                if (pinp) pinp.value = pinp.dataset.base;
                document.getElementById('pricechanged-' + pkgId)?.classList.remove('visible');
            } else {
                const pinp         = document.getElementById('priceinp-' + pkgId);
                const currentPrice = pinp ? (parseFloat(pinp.value) || parseFloat(basePrice) || 0) : (parseFloat(basePrice) || 0);
                selected[pkgId]    = { qty: 1, name, price: currentPrice, basePrice: parseFloat(basePrice) || 0 };
                el.classList.add('selected');
                document.getElementById('pkgchksvg-' + pkgId).style.display = 'block';
                document.getElementById('qtyinp-' + pkgId).value = 1;
            }
            refreshCatBadge(catId);
            updateSummary();
        }

        function chQty(pkgId, delta, e) {
            e.stopPropagation();
            const inp = document.getElementById('qtyinp-' + pkgId);
            let q     = (parseInt(inp.value) || 1) + delta;
            if (q < 1) q = 1;
            inp.value = q;
            if (selected[pkgId]) { selected[pkgId].qty = q; updateSummary(); }
        }

        function onQtyInput(pkgId) {
            const inp = document.getElementById('qtyinp-' + pkgId);
            let q     = parseInt(inp.value) || 1;
            if (q < 1) { q = 1; inp.value = 1; }
            if (selected[pkgId]) { selected[pkgId].qty = q; updateSummary(); }
        }

        function onPriceInput(pkgId) {
            const pinp = document.getElementById('priceinp-' + pkgId);
            const pchg = document.getElementById('pricechanged-' + pkgId);
            let p      = parseFloat(pinp.value) || 0;
            if (p < 0) { p = 0; pinp.value = 0; }
            if (pchg) {
                const base = parseFloat(pinp.dataset.base) || 0;
                pchg.classList.toggle('visible', p !== base);
            }
            if (selected[pkgId]) { selected[pkgId].price = p; updateSummary(); }
        }

        function refreshCatBadge(catId) {
            const block  = document.getElementById('catblock-' + catId);
            const badge  = document.getElementById('catbadge-' + catId);
            if (!block || !badge) return;
            const selCnt = block.querySelectorAll('.pkg-item.selected').length;
            const total  = block.querySelectorAll('.pkg-item').length;
            block.classList.toggle('has-selected', selCnt > 0);
            badge.textContent = selCnt > 0 ? selCnt + ' dipilih' : total + ' paket';
        }

        // ─── Summary ───────────────────────────────────────────────────────────────
        function updateSummary() {
            const isAdmin = document.getElementById('adminFillToggle').checked;
            if (!isAdmin) return;

            const keys = Object.keys(selected);
            document.getElementById('selectedCount').textContent = keys.length;

            if (!keys.length) {
                document.getElementById('sum-items-content').innerHTML =
                    '<div style="font-size:12px;color:#9ca3af"><em>Belum ada paket dipilih.</em></div>';
                document.getElementById('sum-total').textContent     = '—';
                document.getElementById('subtotalDisplay').textContent = 'Rp 0';
                return;
            }

            let total = 0;
            let html  = '<ul id="sum-items-list">';
            keys.forEach(id => {
                const it  = selected[id];
                const sub = it.qty * it.price;
                total += sub;
                html += `<li>
                    <span class="si-name">${escHtml(it.name)} × ${it.qty}</span>
                    <span class="si-price">${fmt(sub)}</span>
                </li>`;
            });
            html += '</ul>';
            document.getElementById('sum-items-content').innerHTML    = html;
            document.getElementById('sum-total').textContent          = fmt(total);
            document.getElementById('subtotalDisplay').textContent    = fmt(total);
        }

        // ─── Toggle Logic ──────────────────────────────────────────────────────────
        const toggle       = document.getElementById('adminFillToggle');
        const toggleCard   = document.getElementById('toggleCard');
        const toggleDesc   = document.getElementById('toggleDesc');
        const adminSection = document.getElementById('admin-items-section');

        function applyToggleState(isAdmin) {
            document.getElementById('filled_by').value = isAdmin ? 'admin' : 'customer';
            toggleCard.classList.toggle('active', isAdmin);
            adminSection.classList.toggle('visible', isAdmin);

            // Tampilkan/sembunyikan card detail pengujian
            const pengujianCard = document.getElementById('pengujianCard');
            if (pengujianCard) {
                pengujianCard.style.display = isAdmin ? '' : 'none';
            }

            // Toggle required pada field pengujian
            const tujuan  = document.getElementById('tujuan_pengujian');
            const waktu   = document.getElementById('waktu_diharapkan');
            if (tujuan) tujuan.required = isAdmin;
            if (waktu)  waktu.required  = isAdmin;

            if (isAdmin) {
                toggleDesc.textContent = 'Aktif — Admin memilih paket layanan langsung pada form ini.';
                document.getElementById('infoBoxText').innerHTML =
                    'Order dibuat dengan status <strong>Draft</strong>. Paket layanan dipilih langsung oleh admin pada form ini.';
                document.getElementById('sum-mode').innerHTML =
                    '<span class="mode-badge admin">Admin mengisi</span>';
                updateSummary();
            } else {
                toggleDesc.textContent =
                    'Nonaktif — Customer akan mengisi item sendiri melalui halaman keranjang menggunakan token.';
                document.getElementById('infoBoxText').innerHTML =
                    'Order dibuat dengan status <strong>Draft</strong> dan token otomatis dibuat. Item layanan masih kosong dan akan dipilih oleh customer (guest) saat membuka halaman keranjang menggunakan token tersebut.';
                document.getElementById('sum-mode').innerHTML =
                    '<span class="mode-badge guest">Guest mengisi sendiri</span>';
                document.getElementById('sum-items-content').innerHTML =
                    '<div style="font-size:12.5px;color:#6b7280;line-height:1.8;"><em>Akan diisi oleh customer melalui halaman keranjang (guest).</em></div>';
                document.getElementById('sum-total').textContent = '—';
            }
        }
        toggle.addEventListener('change', function () { applyToggleState(this.checked); });

        // ─── Submit ────────────────────────────────────────────────────────────────
        document.getElementById('orderForm').addEventListener('submit', function (e) {
            if (!document.getElementById('hidden_company_id').value) {
                e.preventDefault();
                alert('Pilih perusahaan terlebih dahulu.');
                CB.company.input.focus();
                return;
            }
            if (!document.getElementById('hidden_contact_id').value) {
                e.preventDefault();
                alert('Pilih kontak / PIC terlebih dahulu.');
                CB.contact.input.focus();
                return;
            }
            if (!document.getElementById('hidden_pic_id').value) {
                e.preventDefault();
                alert('Pilih PIC Internal terlebih dahulu.');
                CB.pic.input.focus();
                return;
            }
            if (!toggle.checked) return;

            const keys = Object.keys(selected);
            if (!keys.length) {
                e.preventDefault();
                alert('Pilih minimal 1 paket layanan, atau nonaktifkan toggle agar customer mengisi sendiri.');
                return;
            }

            this.querySelectorAll('input[data-pkg-hidden]').forEach(el => el.remove());
            keys.forEach((pkgId, i) => {
                const it = selected[pkgId];
                [['package_id', pkgId], ['qty', it.qty], ['custom_price', it.price]].forEach(([k, v]) => {
                    const inp = document.createElement('input');
                    inp.type  = 'hidden';
                    inp.name  = `items[${i}][${k}]`;
                    inp.value = v;
                    inp.dataset.pkgHidden = '1';
                    this.appendChild(inp);
                });
            });
        });

        // ─── CSS spin keyframe ─────────────────────────────────────────────────────
        const spinStyle = document.createElement('style');
        spinStyle.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
        document.head.appendChild(spinStyle);
    </script>
</x-app-sidebar>