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
        * { box-sizing: border-box; }

        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; color: #6b7280; text-decoration: none;
            margin-bottom: 24px; font-weight: 500; transition: color 0.15s;
        }
        .back-link:hover { color: #ea580c; }

        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .detail-layout { display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start; }

        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden; margin-bottom: 20px; }
        .card:last-child { margin-bottom: 0; }
        .card-header {
            padding: 18px 24px; border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header-left { display: flex; align-items: center; gap: 12px; }
        .card-icon {
            width: 36px; height: 36px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center; background: #fff7ed;
        }
        .card-title    { font-size: 14px; font-weight: 700; color: #1c1917; }
        .card-subtitle { font-size: 12px; color: #9ca3af; margin-top: 1px; }
        .card-body     { padding: 24px; }

        /* Order header */
        .order-hero {
            display: flex; align-items: flex-start; justify-content: space-between;
            flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
        }
        .order-code-big { font-size: 26px; font-weight: 800; color: #1c1917; letter-spacing: -0.5px; font-family: monospace; }
        .order-meta     { font-size: 13px; color: #9ca3af; margin-top: 4px; }

        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 700;
        }
        .badge-draft      { background: #f3f4f6; color: #6b7280; }
        .badge-offered    { background: #eff6ff; color: #2563eb; }
        .badge-approved   { background: #f0fdf4; color: #16a34a; }
        .badge-rejected   { background: #fef2f2; color: #dc2626; }
        .badge-processing { background: #fff7ed; color: #ea580c; }
        .badge-done       { background: #f0fdf4; color: #15803d; }
        .badge-form_required { background: #fefce8; color: #ca8a04; }
        .dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
        .dot-draft      { background: #9ca3af; }
        .dot-offered    { background: #3b82f6; }
        .dot-approved   { background: #16a34a; }
        .dot-rejected   { background: #dc2626; }
        .dot-processing { background: #ea580c; }
        .dot-done       { background: #15803d; }
        .dot-form_required { background: #ca8a04; }

        /* Info grid */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .info-block {}
        .info-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; margin-bottom: 5px; }
        .info-val   { font-size: 14px; font-weight: 600; color: #1c1917; }
        .info-sub   { font-size: 12px; color: #9ca3af; margin-top: 2px; }

        /* Items table */
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th {
            padding: 10px 16px; text-align: left; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af;
            background: #fafafa; border-bottom: 1px solid #f3f4f6;
        }
        .items-table td { padding: 14px 16px; border-bottom: 1px solid #f9fafb; font-size: 13.5px; }
        .items-table tr:last-child td { border-bottom: none; }
        .items-table tbody tr:hover { background: #fffbf7; }

        .pkg-name  { font-weight: 600; color: #1c1917; }
        .pkg-info  { font-size: 12px; color: #9ca3af; margin-top: 2px; }
        .text-right { text-align: right; }
        .price-cell { font-weight: 600; color: #1c1917; }

        .total-section { padding: 16px 16px; border-top: 2px solid #f3f4f6; }
        .total-line { display: flex; justify-content: space-between; align-items: center; padding: 4px 0; font-size: 13px; color: #6b7280; }
        .total-line.grand { font-size: 16px; font-weight: 700; color: #1c1917; padding-top: 12px; border-top: 1px solid #f3f4f6; margin-top: 8px; }
        .total-line.grand .val { color: #ea580c; }

        /* Notes block */
        .notes-block { background: #fafafa; border: 1px solid #f3f4f6; border-radius: 8px; padding: 14px 16px; font-size: 13.5px; color: #374151; line-height: 1.6; white-space: pre-wrap; }

        /* Right sidebar */
        .sidebar-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden; margin-bottom: 16px; }
        .sidebar-card:last-child { margin-bottom: 0; }
        .sidebar-card-header { padding: 14px 18px; border-bottom: 1px solid #f3f4f6; font-size: 13px; font-weight: 700; color: #1c1917; display: flex; align-items: center; gap: 8px; }
        .sidebar-card-body   { padding: 18px; }

        /* Link box */
        .link-box {
            background: #fafafa; border: 1px solid #e5e7eb; border-radius: 8px;
            padding: 12px 14px; font-size: 12px; color: #6b7280;
            word-break: break-all; line-height: 1.5; margin-bottom: 12px;
            font-family: monospace;
        }

        .btn-copy {
            width: 100%; padding: 10px; background: #fff; color: #1c1917;
            border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            margin-bottom: 8px;
        }
        .btn-copy:hover { border-color: #ea580c; color: #ea580c; }
        .btn-copy.copied { background: #f0fdf4; border-color: #bbf7d0; color: #16a34a; }

        .btn-send {
            width: 100%; padding: 12px; background: #ea580c; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 700;
            cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-send:hover { background: #c2410c; box-shadow: 0 4px 14px rgba(234,88,12,0.3); }
        .btn-send:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-open {
            width: 100%; padding: 9px; background: #fff; color: #374151;
            border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 12.5px; font-weight: 600;
            cursor: pointer; font-family: 'Sora', sans-serif; transition: all 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            text-decoration: none; margin-top: 8px;
        }
        .btn-open:hover { border-color: #6b7280; }

        .sent-info { font-size: 12px; color: #6b7280; text-align: center; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 5px; }

        /* Token box */
        .token-box {
            background: #1c1917; border-radius: 8px; padding: 12px 14px;
            font-family: monospace; font-size: 11px; color: #fbbf24;
            word-break: break-all; letter-spacing: 0.5px; margin-bottom: 12px;
        }

        .divider { border: none; border-top: 1px solid #f3f4f6; margin: 16px 0; }

        /* Timeline */
        .timeline { }
        .tl-item { display: flex; gap: 12px; margin-bottom: 14px; }
        .tl-item:last-child { margin-bottom: 0; }
        .tl-dot { width: 8px; height: 8px; border-radius: 50%; background: #e5e7eb; flex-shrink: 0; margin-top: 5px; }
        .tl-dot.active { background: #ea580c; }
        .tl-key { font-size: 12px; font-weight: 600; color: #374151; }
        .tl-val { font-size: 11.5px; color: #9ca3af; margin-top: 1px; }

        @media (max-width: 900px) {
            .detail-layout { grid-template-columns: 1fr; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>

    <a href="{{ route('admin.orders.index') }}" class="back-link">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
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

        {{-- LEFT --}}
        <div>
            {{-- Order Summary --}}
            <div class="card">
                <div class="card-body">
                    <div class="order-hero">
                        <div>
                            <div class="order-code-big">{{ $order->order_code }}</div>
                            <div class="order-meta">Dibuat {{ $order->created_at->format('d M Y, H:i') }} oleh {{ $order->creator?->name ?? '-' }}</div>
                        </div>
                        <span class="badge badge-{{ $order->status }}">
                            <span class="dot dot-{{ $order->status }}"></span>
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>

                    <div class="info-grid">
                        <div class="info-block">
                            <div class="info-label">Nama Customer</div>
                            <div class="info-val">{{ $order->customer_name }}</div>
                        </div>
                        <div class="info-block">
                            <div class="info-label">Email Customer</div>
                            <div class="info-val" style="font-size:13px;">{{ $order->customer_email }}</div>
                        </div>
                        @if($order->sent_at)
                        <div class="info-block">
                            <div class="info-label">Terkirim pada</div>
                            <div class="info-val">{{ $order->sent_at->format('d M Y, H:i') }}</div>
                            <div class="info-sub">Email penawaran dikirim</div>
                        </div>
                        @endif
                        <div class="info-block">
                            <div class="info-label">Access Token</div>
                            <div class="info-val" style="font-size:11px;font-family:monospace;color:#6b7280;word-break:break-all;">
                                {{ Str::limit($order->access_token, 24) }}...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Offer Items --}}
            @if($order->offer && $order->offer->details->count())
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <div>
                                <div class="card-title">Item Penawaran</div>
                                <div class="card-subtitle">{{ $order->offer->details->count() }} paket dipilih</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn-open" style="margin:0;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                            Edit Harga / Upload File
                        </a>
                    </div>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Paket</th>
                                <th>Qty</th>
                                <th class="text-right">Harga Satuan</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($order->offer->details as $detail)
                                @php
                                    $sub = $detail->qty * $detail->price;
                                    $grandTotal += $sub;
                                @endphp
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="total-section">
                        <div class="total-line grand">
                            <span>Total</span>
                            <span class="val">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body" style="text-align:center;padding:40px 20px;color:#9ca3af;font-size:13px;">
                        <div style="font-size:32px;margin-bottom:10px;">📭</div>
                        <div style="font-weight:600;color:#374151;">Belum ada item penawaran</div>
                        <div style="margin-top:4px;">Order ini belum memiliki penawaran.</div>
                    </div>
                </div>
            @endif

            {{-- Notes & Terms --}}
            @if($order->offer && ($order->offer->notes || $order->offer->terms))
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#ea580c" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <div class="card-title">Catatan & Syarat</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($order->offer->notes)
                            <div style="margin-bottom:16px;">
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
        </div>

        {{-- RIGHT SIDEBAR --}}
        <div style="position:sticky;top:20px;">

            {{-- Internal Notification --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notifikasi Internal
                </div>
                <div class="sidebar-card-body">
                    <p style="font-size:12.5px;color:#6b7280;line-height:1.6;margin:0 0 14px;">
                        Kirim notifikasi ke user internal (id=2) untuk memproses order ini (buat penawaran & invoice manual).
                    </p>
                    <form action="{{ route('admin.orders.notifyInternal', $order) }}" method="POST"
                          onsubmit="return confirm('Kirim notifikasi internal untuk order {{ $order->order_code }}?')">
                        @csrf
                        <button type="submit" class="btn-send" style="background:#111827;" onmouseover="this.style.background='#000'" onmouseout="this.style.background='#111827'">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13"/><path stroke-linecap="round" stroke-linejoin="round" d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                            Kirim Notifikasi
                        </button>
                    </form>
                </div>
            </div>

            {{-- Send Offer --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Kirim Penawaran
                </div>
                <div class="sidebar-card-body">
                    @if($order->status === 'submit')
                        <p style="font-size:12.5px;color:#6b7280;line-height:1.6;margin:0 0 14px;">
                            Kirim email ke <strong style="color:#1c1917;">{{ $order->customer_email }}</strong> berisi link penawaran.
                        </p>
                        <form action="{{ route('admin.orders.sendOffer', $order) }}" method="POST"
                              onsubmit="return confirm('Kirim email penawaran ke {{ $order->customer_email }}?')">
                            @csrf
                            <button type="submit" class="btn-send">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                Kirim Email Penawaran
                            </button>
                        </form>
                    @elseif($order->status === 'offered')
                        <div style="display:flex;align-items:center;gap:6px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:10px 12px;font-size:12.5px;color:#1d4ed8;margin-bottom:14px;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Email berhasil dikirim
                        </div>
                        <form action="{{ route('admin.orders.sendOffer', $order) }}" method="POST"
                              onsubmit="return confirm('Kirim ulang email penawaran?')">
                            @csrf
                            <button type="submit" class="btn-send" style="background:#3b82f6;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#3b82f6'">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                Kirim Ulang
                            </button>
                        </form>
                        @if($order->sent_at)
                            <div class="sent-info">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Terkirim {{ $order->sent_at->diffForHumans() }}
                            </div>
                        @endif
                    @else
                        <div style="font-size:12.5px;color:#6b7280;text-align:center;padding:8px 0;">
                            Status <strong>{{ ucfirst(str_replace('_',' ',$order->status)) }}</strong> — tidak bisa kirim ulang.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Guest Link --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    Link Customer
                </div>
                <div class="sidebar-card-body">
                    <div style="font-size:11.5px;color:#9ca3af;margin-bottom:8px;font-weight:600;letter-spacing:0.3px;">URL PENAWARAN</div>
                    <div class="link-box" id="guestLinkBox">{{ $guestLink }}</div>
                    <button type="button" class="btn-copy" id="copyLinkBtn" onclick="copyLink()">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        <span id="copyLinkText">Salin Link</span>
                    </button>
                    <a href="{{ $guestLink }}" target="_blank" class="btn-open">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Buka di Tab Baru
                    </a>
                </div>
            </div>

            {{-- Access Token --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    Access Token
                </div>
                <div class="sidebar-card-body">
                    <div class="token-box">{{ $order->access_token }}</div>
                    <button type="button" class="btn-copy" id="copyTokenBtn" onclick="copyToken()">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        <span id="copyTokenText">Salin Token</span>
                    </button>
                    <p style="font-size:11.5px;color:#9ca3af;margin:10px 0 0;line-height:1.5;">
                        Token ini digunakan untuk autentikasi akses customer tanpa login.
                    </p>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
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
                        @if($order->sent_at)
                            <div class="tl-item">
                                <div class="tl-dot active"></div>
                                <div>
                                    <div class="tl-key">Penawaran dikirim</div>
                                    <div class="tl-val">{{ $order->sent_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        @else
                         <div class="tl-item">
                                <div class="tl-dot"></div>
                                <div>
                                    <div class="tl-key">Penawaran dikirim</div>
                                    <div class="tl-val">Menunggu...</div>
                                </div>
                            </div>
                        @endif
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

        </div>
    </div>

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
    </script>
</x-app-sidebar>