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
        .card-title  { font-size: 14px; font-weight: 700; color: #1c1917; }
        .card-subtitle { font-size: 12px; color: #9ca3af; margin-top: 1px; }
        .card-body   { padding: 24px; }

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
        select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' fill='none' viewBox='0 0 24 24' stroke='%239ca3af' stroke-width='2.5' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }

        .input-error { border-color: #fca5a5 !important; }
        .err-msg { font-size: 11.5px; color: #dc2626; margin-top: 4px; display: flex; align-items: center; gap: 4px; }

        /* Items table */
        .items-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 14px;
        }
        .items-label { font-size: 13px; font-weight: 700; color: #1c1917; }

        .btn-add-item {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 12px; background: #fff7ed; color: #ea580c;
            border: 1px dashed #fed7aa; border-radius: 7px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: 'Sora', sans-serif; transition: all 0.15s;
        }
        .btn-add-item:hover { background: #ffedd5; border-style: solid; }

        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th {
            padding: 9px 12px; text-align: left; font-size: 11px;
            font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;
            color: #9ca3af; background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        .items-table td { padding: 10px 8px; vertical-align: top; border-bottom: 1px solid #f9fafb; }
        .items-table tr:last-child td { border-bottom: none; }

        .item-row select, .item-row input { margin: 0; }

        .btn-remove {
            display: flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 6px; border: none;
            background: transparent; color: #d1d5db; cursor: pointer;
            transition: all 0.15s; font-family: 'Sora', sans-serif;
        }
        .btn-remove:hover { background: #fef2f2; color: #dc2626; }

        .subtotal-row { font-size: 13px; font-weight: 600; color: #1c1917; text-align: right; padding: 12px 8px 0; }
        .subtotal-val { color: #ea580c; }

        /* Summary card */
        .summary-section { margin-bottom: 20px; }
        .summary-title { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: #9ca3af; margin-bottom: 12px; }

        .summary-item { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px; }
        .summary-key { font-size: 13px; color: #6b7280; }
        .summary-val { font-size: 13px; font-weight: 600; color: #1c1917; }

        .divider { border: none; border-top: 1px solid #f3f4f6; margin: 16px 0; }

        .total-row { display: flex; justify-content: space-between; align-items: center; }
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

        @media (max-width: 900px) {
            .form-layout { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
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
        <div class="form-layout">

            {{-- LEFT COLUMN --}}
            <div>
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
            </div>

            {{-- RIGHT COLUMN --}}
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
                            Order dibuat dengan status <strong>Draft</strong> dan token otomatis dibuat. Item layanan masih kosong dan akan dipilih oleh customer (guest) saat membuka halaman keranjang menggunakan token tersebut.
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
                        </div>

                        <hr class="divider">

                        <div class="summary-section">
                            <div class="summary-title">Item</div>
                            <div style="font-size: 12.5px; color: #6b7280; line-height: 1.8;">
                                <em>Akan diisi oleh customer melalui halaman keranjang (guest) setelah memasukkan token.</em>
                            </div>
                        </div>

                        <hr class="divider">

                        <div class="total-row" style="margin-bottom: 20px;">
                            <span class="total-label">Total</span>
                            <span class="total-val">—</span>
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
        function syncCustomer() {
            document.getElementById('sum-name').textContent  = document.querySelector('[name="customer_name"]').value  || '—';
            document.getElementById('sum-email').textContent = document.querySelector('[name="customer_email"]').value || '—';
        }

        document.querySelector('[name="customer_name"]').addEventListener('input', syncCustomer);
        document.querySelector('[name="customer_email"]').addEventListener('input', syncCustomer);
        syncCustomer();
    </script>
</x-app-sidebar>