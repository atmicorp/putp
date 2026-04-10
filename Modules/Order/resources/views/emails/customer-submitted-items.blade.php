<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Masuk – {{ $order->order_code }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
            padding: 28px 16px;
        }
        .wrap {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        /* ── HEADER ── */
        .hd {
            background: #111827;
            padding: 22px 28px;
        }
        .hd-label {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }
        .hd-code {
            font-family: 'Courier New', monospace;
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
        }
        .hd-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            background: rgba(234,88,12,0.18);
            border-radius: 999px;
            padding: 5px 14px;
        }
        .hd-badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #fb923c;
        }
        .hd-badge-text {
            font-size: 12px;
            color: #fdba74;
            font-weight: 600;
        }

        /* ── BODY ── */
        .bd { padding: 24px 28px; }

        /* ── INFO GRID ── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }
        .info-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 14px;
        }
        .info-label {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 12px;
        }

        /* ── ITEMS TABLE ── */
        .items-wrap {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .items-head {
            display: grid;
            grid-template-columns: 1fr 80px 120px;
            background: #f9fafb;
            padding: 10px 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        .items-head span {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }
        .items-head span:nth-child(2) { text-align: center; }
        .items-head span:nth-child(3) { text-align: right; }

        .item-row {
            display: grid;
            grid-template-columns: 1fr 80px 120px;
            padding: 13px 14px;
            border-bottom: 1px solid #f3f4f6;
            align-items: center;
        }
        .item-row:last-child { border-bottom: none; }
        .item-name {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }
        .item-price {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 2px;
        }
        .item-qty {
            text-align: center;
        }
        .qty-badge {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 13px;
            font-weight: 700;
            border-radius: 999px;
            padding: 3px 12px;
        }
        .item-subtotal {
            text-align: right;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        /* ── TOTAL ROW ── */
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9fafb;
            padding: 13px 14px;
            border-top: 1px solid #e5e7eb;
        }
        .total-label {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
        }
        .total-value {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
        }

        /* ── NOTICE ── */
        .notice {
            background: #fff7ed;
            border-left: 3px solid #ea580c;
            border-radius: 6px;
            padding: 12px 14px;
            margin-bottom: 22px;
            font-size: 13px;
            color: #92400e;
            line-height: 1.6;
        }

        /* ── CTA BUTTON ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 22px;
            background: #ea580c;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }

        /* ── FOOTER ── */
        .ft {
            padding: 14px 28px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
            font-size: 12px;
            color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .info-grid { grid-template-columns: 1fr; }
            .items-head,
            .item-row { grid-template-columns: 1fr 60px 100px; }
        }
    </style>
</head>
<body>
<div class="wrap">

    {{-- ── HEADER ── --}}
    <div class="hd">
        <div class="hd-label">Notifikasi order baru</div>
        <div class="hd-code">{{ $order->order_code }}</div>
        <div class="hd-badge">
            <div class="hd-badge-dot"></div>
            <span class="hd-badge-text">{{ ucfirst($order->status) }}</span>
        </div>
    </div>

    {{-- ── BODY ── --}}
    <div class="bd">

        {{-- Info customer --}}
        <div class="info-grid">
            <div class="info-card">
                <div class="info-label">Perusahaan</div>
                <div class="info-value">{{ $order->company->name ?? '—' }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Nama kontak</div>
                <div class="info-value">{{ $order->contact->name ?: '—' }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Tanggal masuk</div>
                <div class="info-value">{{ $order->created_at->translatedFormat('d M Y, H.i') }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Dibuat oleh</div>
                <div class="info-value">{{ $order->creator->name ?? '—' }}</div>
            </div>
        </div>

        {{-- Paket yang dipesan --}}
        @if($order->offer && $order->offer->details->count())
            <div class="section-title">Paket yang dipesan</div>

            <div class="items-wrap">
                <div class="items-head">
                    <span>Nama paket</span>
                    <span>Qty</span>
                    <span>Subtotal</span>
                </div>

                @foreach($order->offer->details as $d)
                    <div class="item-row">
                        <div>
                            <div class="item-name">
                                {{ $d->package?->name ?? ('Package #' . $d->package_id) }}
                            </div>
                            <div class="item-price">
                                Rp {{ number_format($d->price, 0, ',', '.') }} / unit
                            </div>
                        </div>
                        <div class="item-qty">
                            <span class="qty-badge">×{{ $d->qty }}</span>
                        </div>
                        <div class="item-subtotal">
                            Rp {{ number_format($d->qty * $d->price, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach

                <div class="total-row">
                    <span class="total-label">Total keseluruhan</span>
                    <span class="total-value">
                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Notice --}}
        <div class="notice">
            Customer telah memilih paket layanan melalui halaman keranjang.
            Tinjau dan proses order ini sesegera mungkin.
        </div>

        {{-- CTA --}}
        <a href="{{ $adminLink }}" class="btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2"/>
                <path d="M9 9h6M9 12h6M9 15h4"/>
            </svg>
            Buka order di admin
        </a>

    </div>

    {{-- ── FOOTER ── --}}
    <div class="ft">
        Email ini dikirim otomatis oleh sistem PUTP. Jangan balas email ini.
    </div>

</div>
</body>
</html>