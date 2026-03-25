<x-app-sidebar>
    <x-slot name="title">Order</x-slot>

    <x-slot name="breadcrumb">
        <span>Order</span>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.orders.index') }}" style="color:#ea580c;text-decoration:none;">Order List</a>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="current">Buat Order</span>
    </x-slot>

    {{--
        Controller harus pass:
            $categories = Category::with(['packages' => fn($q) => $q->where('is_active', true)])->get()
    --}}

    <style>
        * { box-sizing: border-box; }

        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; color: #6b7280; text-decoration: none;
            margin-bottom: 24px; font-weight: 500; transition: color 0.15s;
        }
        .back-link:hover { color: #ea580c; }

        .form-layout { display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start; }

        .card {
            background: #fff; border: 1px solid #e5e7eb;
            border-radius: 14px; overflow: hidden;
        }
        .card-header {
            padding: 18px 24px; border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; gap: 12px;
        }
        .card-icon {
            width: 36px; height: 36px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            background: #fff7ed;
        }
        .card-title   { font-size: 14px; font-weight: 700; color: #1c1917; }
        .card-subtitle { font-size: 12px; color: #9ca3af; margin-top: 1px; }
        .card-body    { padding: 24px; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 18px; }
        .form-group:last-child { margin-bottom: 0; }

        label {
            display: block; font-size: 12px; font-weight: 600;
            color: #374151; margin-bottom: 6px; letter-spacing: 0.3px;
        }
        label span.req { color: #ea580c; }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        select,
        textarea {
            width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb;
            border-radius: 8px; font-size: 13.5px; font-family: 'Sora', sans-serif;
            color: #1c1917; background: #fff; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.08);
        }
        textarea { resize: vertical; min-height: 90px; }
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' viewBox='0 0 24 24' stroke='%239ca3af' stroke-width='2.5' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px;
        }

        .input-error { border-color: #fca5a5 !important; }
        .err-msg { font-size: 11.5px; color: #dc2626; margin-top: 4px; display: flex; align-items: center; gap: 4px; }

        /* ── Toggle Switch ── */
        .toggle-card {
            background: #fafafa; border: 1.5px solid #e5e7eb;
            border-radius: 12px; padding: 16px 20px; margin-bottom: 20px;
            transition: border-color 0.2s, background 0.2s;
        }
        .toggle-card.active { background: #fff7ed; border-color: #fed7aa; }
        .toggle-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .toggle-info { flex: 1; }
        .toggle-title { font-size: 13px; font-weight: 700; color: #1c1917; margin-bottom: 3px; }
        .toggle-desc  { font-size: 12px; color: #6b7280; line-height: 1.5; }

        .switch { position: relative; display: inline-flex; align-items: center; cursor: pointer; flex-shrink: 0; }
        .switch input { opacity: 0; width: 0; height: 0; position: absolute; }
        .switch-track {
            width: 44px; height: 24px; background: #d1d5db; border-radius: 24px;
            transition: background 0.2s; position: relative;
        }
        .switch-thumb {
            position: absolute; top: 3px; left: 3px;
            width: 18px; height: 18px; background: #fff;
            border-radius: 50%; transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .switch input:checked ~ .switch-track { background: #ea580c; }
        .switch input:checked ~ .switch-track .switch-thumb { transform: translateX(20px); }

        /* ── Admin items section ── */
        #admin-items-section {
            overflow: hidden; max-height: 0; opacity: 0;
            transition: max-height 0.35s ease, opacity 0.25s ease;
        }
        #admin-items-section.visible { max-height: 4000px; opacity: 1; }

        /* ── Category accordion ── */
        .cat-block {
            margin-bottom: 10px; border: 1.5px solid #e5e7eb;
            border-radius: 10px; overflow: hidden;
        }
        .cat-block.has-selected { border-color: #fed7aa; }

        .cat-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 11px 16px; background: #fafafa; cursor: pointer;
            user-select: none; transition: background 0.15s;
        }
        .cat-block.has-selected .cat-header { background: #fff7ed; }
        .cat-header:hover { background: #f3f4f6; }
        .cat-block.has-selected .cat-header:hover { background: #ffedd5; }

        .cat-header-left { display: flex; align-items: center; gap: 10px; }
        .cat-name { font-size: 13px; font-weight: 700; color: #1c1917; }
        .cat-badge {
            font-size: 11px; font-weight: 600; padding: 2px 8px;
            border-radius: 20px; background: #f3f4f6; color: #6b7280;
            transition: all 0.15s;
        }
        .cat-block.has-selected .cat-badge { background: #ea580c; color: #fff; }

        .cat-chevron { width: 16px; height: 16px; color: #9ca3af; transition: transform 0.2s; flex-shrink: 0; }
        .cat-block.open .cat-chevron { transform: rotate(180deg); }

        .cat-body {
            max-height: 0; overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .cat-block.open .cat-body { max-height: 2000px; border-top: 1px solid #f3f4f6; }

        /* ── Package items ── */
        .pkg-list { padding: 8px 12px; display: flex; flex-direction: column; gap: 6px; }

        .pkg-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 8px;
            border: 1.5px solid transparent; background: #fafafa;
            transition: all 0.15s; cursor: pointer;
        }
        .pkg-item:hover  { background: #fff7ed; border-color: #fed7aa; }
        .pkg-item.selected { background: #fff7ed; border-color: #ea580c; }

        .pkg-check {
            width: 18px; height: 18px; flex-shrink: 0;
            border: 1.5px solid #d1d5db; border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s; background: #fff;
        }
        .pkg-item.selected .pkg-check { background: #ea580c; border-color: #ea580c; }

        .pkg-info { flex: 1; min-width: 0; }
        .pkg-name { font-size: 13px; font-weight: 600; color: #1c1917; }
        .pkg-desc { font-size: 11.5px; color: #9ca3af; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px; }

        .pkg-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }

        /* ── Editable price ── */
        .pkg-price-wrap {
            display: flex; flex-direction: column; align-items: flex-end; gap: 1px;
        }
        .pkg-price-label {
            font-size: 10px; color: #9ca3af; font-weight: 500; letter-spacing: 0.3px;
            display: none;
        }
        .pkg-item.selected .pkg-price-label { display: block; }

        .pkg-price-input {
            width: 110px; padding: 5px 8px;
            border: 1.5px solid transparent; border-radius: 6px;
            font-size: 13px; font-weight: 700; color: #ea580c;
            background: transparent; outline: none; text-align: right;
            font-family: 'Sora', sans-serif; cursor: default;
            transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
            pointer-events: none;
        }
        .pkg-item.selected .pkg-price-input {
            border-color: #fed7aa; background: #fff; cursor: text; pointer-events: auto;
        }
        .pkg-item.selected .pkg-price-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.08);
        }
        .pkg-price-input::-webkit-outer-spin-button,
        .pkg-price-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .pkg-price-input[type=number] { -moz-appearance: textfield; }

        .pkg-price-changed {
            font-size: 10px; color: #9ca3af; text-decoration: line-through;
            text-align: right; display: none;
        }
        .pkg-item.selected .pkg-price-changed.visible { display: block; }

        /* Price input — shown always, editable inline */
        .pkg-price-wrap {
            display: flex; flex-direction: column; align-items: flex-end; gap: 2px;
        }
        .pkg-price-label {
            font-size: 10px; color: #9ca3af; font-weight: 500; letter-spacing: 0.3px;
            display: none;
        }
        .pkg-item.selected .pkg-price-label { display: block; }

        .pkg-price-input {
            width: 110px; padding: 5px 8px; border: 1.5px solid transparent;
            border-radius: 6px; font-size: 13px; font-weight: 700; color: #ea580c;
            background: transparent; outline: none; text-align: right;
            font-family: 'Sora', sans-serif; cursor: default;
            transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
        }
        .pkg-item.selected .pkg-price-input {
            border-color: #fed7aa; background: #fff; cursor: text;
        }
        .pkg-item.selected .pkg-price-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234,88,12,0.08);
        }
        .pkg-price-input::-webkit-outer-spin-button,
        .pkg-price-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .pkg-price-input[type=number] { -moz-appearance: textfield; }

        /* price changed indicator */
        .pkg-price-changed {
            font-size: 10px; color: #9ca3af; text-decoration: line-through;
            display: none; text-align: right;
        }
        .pkg-item.selected .pkg-price-changed.visible { display: block; }

        /* Qty controls — hidden until selected */
        .pkg-qty-wrap { display: none; align-items: center; gap: 6px; }
        .pkg-item.selected .pkg-qty-wrap { display: flex; }

        .qty-btn {
            width: 26px; height: 26px; border-radius: 6px; border: 1.5px solid #e5e7eb;
            background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: #374151; transition: all 0.15s;
            font-family: 'Sora', sans-serif; padding: 0; line-height: 1;
        }
        .qty-btn:hover { border-color: #ea580c; color: #ea580c; background: #fff7ed; }

        .qty-val {
            width: 36px; text-align: center; font-size: 13px; font-weight: 700;
            color: #1c1917; border: none; background: transparent; outline: none;
            font-family: 'Sora', sans-serif; padding: 0;
        }
        /* hide number spinners */
        .qty-val::-webkit-outer-spin-button,
        .qty-val::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .qty-val[type=number] { -moz-appearance: textfield; }

        /* ── Subtotal bar ── */
        .subtotal-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 16px; background: #fafafa; border-top: 1px solid #f3f4f6;
            margin-top: 8px;
        }
        .subtotal-info { font-size: 12px; color: #6b7280; }
        .subtotal-info strong { color: #1c1917; }
        .subtotal-amount { font-size: 15px; font-weight: 700; color: #ea580c; }

        .pkg-empty { padding: 20px 16px; font-size: 12.5px; color: #9ca3af; text-align: center; }

        /* ── Summary card ── */
        .summary-section { margin-bottom: 20px; }
        .summary-title { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; margin-bottom: 12px; }
        .summary-item  { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px; }
        .summary-key   { font-size: 13px; color: #6b7280; }
        .summary-val   { font-size: 13px; font-weight: 600; color: #1c1917; }

        .divider { border: none; border-top: 1px solid #f3f4f6; margin: 16px 0; }

        .total-row   { display: flex; justify-content: space-between; align-items: center; }
        .total-label { font-size: 14px; font-weight: 700; color: #1c1917; }
        .total-val   { font-size: 20px; font-weight: 700; color: #ea580c; }

        .btn-submit {
            width: 100%; padding: 13px; background: #ea580c; color: #fff;
            border: none; border-radius: 10px; font-size: 14px; font-weight: 700;
            cursor: pointer; font-family: 'Sora', sans-serif;
            transition: all 0.15s; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { background: #c2410c; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(234,88,12,0.3); }
        .btn-submit:active { transform: translateY(0); }

        .info-box {
            background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px;
            padding: 12px 14px; font-size: 12px; color: #92400e; margin-bottom: 16px;
            display: flex; gap: 8px; align-items: flex-start; line-height: 1.5;
        }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .mode-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .mode-badge.guest { background: #f0fdf4; color: #16a34a; }
        .mode-badge.admin { background: #fff7ed; color: #ea580c; }

        #sum-items-list { list-style: none; padding: 0; margin: 0; }
        #sum-items-list li {
            display: flex; justify-content: space-between; align-items: baseline;
            font-size: 12px; padding: 4px 0; border-bottom: 1px dashed #f3f4f6;
        }
        #sum-items-list li:last-child { border-bottom: none; }
        .si-name  { color: #6b7280; padding-right: 8px; }
        .si-price { font-weight: 600; color: #1c1917; flex-shrink: 0; }

        @media (max-width: 900px) {
            .form-layout { grid-template-columns: 1fr; }
            .form-row    { grid-template-columns: 1fr; }
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
        <input type="hidden" name="filled_by" id="filled_by" value="customer">
        {{-- Hidden package inputs will be injected by JS on submit --}}

        <div class="form-layout">

            {{-- ══════════ LEFT COLUMN ══════════ --}}
            <div>
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
                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <div class="card-title">Informasi Customer</div>
                            <div class="card-subtitle">Data penerima penawaran</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Customer <span class="req">*</span></label>
                                <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                                    placeholder="contoh: PT. Maju Jaya"
                                    class="{{ $errors->has('customer_name') ? 'input-error' : '' }}">
                                @error('customer_name')
                                    <div class="err-msg">
                                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email Customer</label>
                                <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                                    placeholder="(opsional) customer@email.com"
                                    class="{{ $errors->has('customer_email') ? 'input-error' : '' }}">
                                @error('customer_email')
                                    <div class="err-msg">
                                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Package Picker (admin mode only) --}}
                <div id="admin-items-section">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-icon">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <div>
                                <div class="card-title">Pilih Paket Layanan</div>
                                <div class="card-subtitle">Klik paket untuk memilih — harga otomatis dari base_price</div>
                            </div>
                        </div>

                        <div style="padding: 16px 20px 8px;" id="categoriesContainer">
                            <div class="pkg-empty">Memuat daftar paket…</div>
                        </div>

                        <div class="subtotal-bar">
                            <div class="subtotal-info">
                                <strong id="selectedCount">0</strong> paket dipilih
                            </div>
                            <div class="subtotal-amount" id="subtotalDisplay">Rp 0</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════ RIGHT COLUMN ══════════ --}}
            <div>
                <div class="card" style="position: sticky; top: 20px;">
                    <div class="card-header">
                        <div class="card-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
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

                        <div class="summary-section">
                            <div class="summary-title">Customer</div>
                            <div class="summary-item">
                                <span class="summary-key">Nama</span>
                                <span class="summary-val" id="sum-name" style="text-align:right;max-width:180px;">—</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-key">Email</span>
                                <span class="summary-val" id="sum-email" style="font-size:12px;text-align:right;max-width:180px;word-break:break-all;">—</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-key">Mode</span>
                                <span id="sum-mode"><span class="mode-badge guest">Guest mengisi sendiri</span></span>
                            </div>
                        </div>

                        <hr class="divider">

                        <div class="summary-section">
                            <div class="summary-title">Paket Dipilih</div>
                            <div id="sum-items-content">
                                <div style="font-size:12.5px;color:#6b7280;line-height:1.8;">
                                    <em>Akan diisi oleh customer melalui halaman keranjang (guest).</em>
                                </div>
                            </div>
                        </div>

                        <hr class="divider">

                        <div class="total-row" style="margin-bottom: 20px;">
                            <span class="total-label">Total</span>
                            <span class="total-val" id="sum-total">—</span>
                        </div>

                        <button type="submit" class="btn-submit">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Buat Order
                        </button>

                        <a href="{{ route('admin.orders.index') }}" style="display:block;text-align:center;margin-top:12px;font-size:13px;color:#9ca3af;text-decoration:none;">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <script>
    // ─── Data dari Laravel ───────────────────────────────────────────────────────
    // Controller: Category::with(['packages' => fn($q) => $q->where('is_active', true)])->get()
    const CATEGORIES = @json($categories ?? []);

    // ─── Helpers ─────────────────────────────────────────────────────────────────
    const fmt = v => 'Rp ' + (isNaN(v) || !v ? 0 : Number(v)).toLocaleString('id-ID');

    // ─── State ───────────────────────────────────────────────────────────────────
    // { [packageId]: { qty, name, price } }
    const selected = {};

    // ─── Build Category Accordion ────────────────────────────────────────────────
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
            block.id = 'catblock-' + cat.category_id;

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
                </div>
            `;
            container.appendChild(block);

            const list = block.querySelector('.pkg-list');
            cat.packages.forEach(pkg => list.appendChild(makePkgItem(pkg, cat.category_id)));
        });
    }

    function makePkgItem(pkg, catId) {
        const el = document.createElement('div');
        el.className = 'pkg-item';
        el.id = 'pkgitem-' + pkg.id;
        el.dataset.catId = catId;
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
            </div>
        `;

        el.addEventListener('click', () => togglePkg(pkg.id, pkg.name, pkg.base_price, catId));
        return el;
    }

    function toggleCat(blockId) {
        document.getElementById(blockId).classList.toggle('open');
    }

    function escHtml(s) {
        return String(s ?? '')
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;');
    }

    // ─── Select / Deselect Package ───────────────────────────────────────────────
    function togglePkg(pkgId, name, basePrice, catId) {
        const el = document.getElementById('pkgitem-' + pkgId);
        if (selected[pkgId]) {
            delete selected[pkgId];
            el.classList.remove('selected');
            document.getElementById('pkgchksvg-' + pkgId).style.display = 'none';
            // Reset price to base when deselected
            const pinp = document.getElementById('priceinp-' + pkgId);
            if (pinp) { pinp.value = pinp.dataset.base; }
            const pchg = document.getElementById('pricechanged-' + pkgId);
            if (pchg) pchg.classList.remove('visible');
        } else {
            // Read current price input value (may have been changed before selecting)
            const pinp = document.getElementById('priceinp-' + pkgId);
            const currentPrice = pinp ? (parseFloat(pinp.value) || parseFloat(basePrice) || 0) : (parseFloat(basePrice) || 0);
            selected[pkgId] = { qty: 1, name, price: currentPrice, basePrice: parseFloat(basePrice) || 0 };
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
        let q = (parseInt(inp.value) || 1) + delta;
        if (q < 1) q = 1;
        inp.value = q;
        if (selected[pkgId]) { selected[pkgId].qty = q; updateSummary(); }
    }

    function onQtyInput(pkgId) {
        const inp = document.getElementById('qtyinp-' + pkgId);
        let q = parseInt(inp.value) || 1;
        if (q < 1) { q = 1; inp.value = 1; }
        if (selected[pkgId]) { selected[pkgId].qty = q; updateSummary(); }
    }

    function onPriceInput(pkgId) {
        const pinp = document.getElementById('priceinp-' + pkgId);
        const pchg = document.getElementById('pricechanged-' + pkgId);
        let p = parseFloat(pinp.value) || 0;
        if (p < 0) { p = 0; pinp.value = 0; }

        const base = parseFloat(pinp.dataset.base) || 0;
        if (pchg) {
            if (p !== base) {
                pchg.classList.add('visible');
            } else {
                pchg.classList.remove('visible');
            }
        }

        if (selected[pkgId]) { selected[pkgId].price = p; updateSummary(); }
    }

    // ─── Category badge ──────────────────────────────────────────────────────────
    function refreshCatBadge(catId) {
        const block = document.getElementById('catblock-' + catId);
        const badge = document.getElementById('catbadge-' + catId);
        if (!block || !badge) return;

        const selCount = block.querySelectorAll('.pkg-item.selected').length;
        const total    = block.querySelectorAll('.pkg-item').length;

        if (selCount > 0) {
            block.classList.add('has-selected');
            badge.textContent = selCount + ' dipilih';
        } else {
            block.classList.remove('has-selected');
            badge.textContent = total + ' paket';
        }
    }

    // ─── Summary ─────────────────────────────────────────────────────────────────
    const sumItemsContent = document.getElementById('sum-items-content');
    const sumTotal        = document.getElementById('sum-total');

    function updateSummary() {
        document.getElementById('sum-name').textContent  = document.querySelector('[name="customer_name"]').value  || '—';
        document.getElementById('sum-email').textContent = document.querySelector('[name="customer_email"]').value || '—';

        if (!document.getElementById('adminFillToggle').checked) return;

        const keys = Object.keys(selected);
        document.getElementById('selectedCount').textContent = keys.length;

        if (!keys.length) {
            sumItemsContent.innerHTML = '<div style="font-size:12px;color:#9ca3af"><em>Belum ada paket dipilih.</em></div>';
            sumTotal.textContent = '—';
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
        sumItemsContent.innerHTML = html;
        sumTotal.textContent = fmt(total);
        document.getElementById('subtotalDisplay').textContent = fmt(total);
    }

    // ─── Toggle Logic ────────────────────────────────────────────────────────────
    const toggle        = document.getElementById('adminFillToggle');
    const toggleCard    = document.getElementById('toggleCard');
    const toggleDesc    = document.getElementById('toggleDesc');
    const adminSection  = document.getElementById('admin-items-section');
    const filledByInput = document.getElementById('filled_by');
    const infoBoxText   = document.getElementById('infoBoxText');
    const sumMode       = document.getElementById('sum-mode');

    function applyToggleState(isAdmin) {
        filledByInput.value = isAdmin ? 'admin' : 'customer';

        if (isAdmin) {
            toggleCard.classList.add('active');
            toggleDesc.textContent = 'Aktif — Admin memilih paket layanan langsung pada form ini.';
            adminSection.classList.add('visible');
            infoBoxText.innerHTML  = 'Order dibuat dengan status <strong>Draft</strong>. Paket layanan dipilih langsung oleh admin pada form ini.';
            sumMode.innerHTML      = '<span class="mode-badge admin">Admin mengisi</span>';
        } else {
            toggleCard.classList.remove('active');
            toggleDesc.textContent = 'Nonaktif — Customer akan mengisi item sendiri melalui halaman keranjang menggunakan token.';
            adminSection.classList.remove('visible');
            infoBoxText.innerHTML  = 'Order dibuat dengan status <strong>Draft</strong> dan token otomatis dibuat. Item layanan masih kosong dan akan dipilih oleh customer (guest) saat membuka halaman keranjang menggunakan token tersebut.';
            sumMode.innerHTML      = '<span class="mode-badge guest">Guest mengisi sendiri</span>';
            sumItemsContent.innerHTML = '<div style="font-size:12.5px;color:#6b7280;line-height:1.8;"><em>Akan diisi oleh customer melalui halaman keranjang (guest).</em></div>';
            sumTotal.textContent   = '—';
        }
        updateSummary();
    }

    toggle.addEventListener('change', function () { applyToggleState(this.checked); });

    // ─── Inject hidden inputs on submit ─────────────────────────────────────────
    document.getElementById('orderForm').addEventListener('submit', function (e) {
        if (!toggle.checked) return;

        const keys = Object.keys(selected);
        if (!keys.length) {
            e.preventDefault();
            alert('Pilih minimal 1 paket layanan, atau nonaktifkan toggle agar customer mengisi sendiri.');
            return;
        }

        // Remove previously injected
        this.querySelectorAll('input[data-pkg-hidden]').forEach(el => el.remove());

        keys.forEach((pkgId, i) => {
            const it = selected[pkgId];
            [
                ['package_id',    pkgId],
                ['qty',           it.qty],
                ['custom_price',  it.price],
            ].forEach(([k, v]) => {
                const inp = document.createElement('input');
                inp.type  = 'hidden';
                inp.name  = `items[${i}][${k}]`;
                inp.value = v;
                inp.dataset.pkgHidden = '1';
                this.appendChild(inp);
            });
        });
    });

    // ─── Init ────────────────────────────────────────────────────────────────────
    document.querySelector('[name="customer_name"]').addEventListener('input', updateSummary);
    document.querySelector('[name="customer_email"]').addEventListener('input', updateSummary);

    buildCategories();
    applyToggleState(toggle.checked);
    </script>
</x-app-sidebar>