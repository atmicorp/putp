<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penawaran {{ $order->order_code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
            font-size: 15px;
            line-height: 1.6;
            padding: 28px 16px;
        }
        .wrapper {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
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
        .hd-appname {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
        }
        .hd-sub {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
        }

        /* ── BODY ── */
        .bd { padding: 24px 28px; }

        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 8px;
        }
        .intro {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 24px;
            line-height: 1.7;
        }

        /* ── META GRID ── */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }
        .meta-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px 14px;
        }
        .meta-label {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 4px;
        }
        .meta-value {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            font-size: 11px;
            font-weight: 600;
            color: #ea580c;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 10px;
        }

        /* ── INFO BOX (notes/terms) ── */
        .info-box {
            background: #fff7ed;
            border-left: 3px solid #ea580c;
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 13px;
            color: #92400e;
            margin-bottom: 22px;
            white-space: pre-line;
            line-height: 1.7;
        }

        /* ── ITEMS TABLE ── */
        .items-wrap {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .items-head {
            display: grid;
            grid-template-columns: 32px 1fr 64px 130px 130px;
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
        .items-head span.r { text-align: right; }

        .item-row {
            display: grid;
            grid-template-columns: 32px 1fr 64px 130px 130px;
            padding: 12px 14px;
            border-bottom: 1px solid #f3f4f6;
            align-items: center;
        }
        .item-row:last-child { border-bottom: none; }
        .item-no {
            font-size: 12px;
            color: #9ca3af;
        }
        .item-name {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }
        .item-qty {
            text-align: center;
        }
        .qty-badge {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 700;
            border-radius: 999px;
            padding: 2px 10px;
        }
        .item-price,
        .item-subtotal {
            text-align: right;
            font-size: 13px;
            color: #374151;
            white-space: nowrap;
        }
        .item-subtotal { font-weight: 600; }

        /* ── TOTAL ── */
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
            color: #ea580c;
        }

        /* ── CTA ── */
        .cta-wrap {
            text-align: center;
            margin: 28px 0 8px;
        }
        .cta-wrap p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 16px;
        }
        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ea580c;
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 28px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
        }
        .url-note {
            margin-top: 14px;
            font-size: 12px;
            color: #9ca3af;
            word-break: break-all;
        }
        .url-note a { color: #ea580c; }

        /* ── FOOTER ── */
        .ft {
            padding: 14px 28px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
        }
        .ft p + p { margin-top: 4px; }

        @media (max-width: 480px) {
            .meta-grid { grid-template-columns: 1fr 1fr; }
            .items-head,
            .item-row { grid-template-columns: 24px 1fr 50px 100px; }
            .items-head span:nth-child(4),
            .item-price { display: none; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- ── HEADER ── --}}
    <div class="hd">
        <div class="hd-label">Surat penawaran resmi</div>
        <div class="hd-appname">{{ config('app.name') }}</div>
        <div class="hd-sub">{{ now()->translatedFormat('d F Y') }}</div>
    </div>

    {{-- ── BODY ── --}}
    <div class="bd">

        <p class="greeting">Yth. {{ $order->contact->name }},</p>
        <p class="intro">
            Terima kasih atas kepercayaan Anda. Kami telah menyiapkan penawaran berikut untuk peninjauan Anda.
            Silakan tinjau detail di bawah, kemudian konfirmasi melalui tombol di bagian bawah email ini.
        </p>

        {{-- Meta --}}
        <div class="meta-grid">
            <div class="meta-card">
                <div class="meta-label">No. order</div>
                <div class="meta-value" style="font-family: 'Courier New', monospace;">{{ $order->order_code }}</div>
            </div>
            <div class="meta-card">
                <div class="meta-label">Perusahaan</div>
                <div class="meta-value">{{ $order->company->name ?? '—' }}</div>
            </div>
            <div class="meta-card">
                <div class="meta-label">Status</div>
                <div class="meta-value" style="color:#ea580c;">Menunggu konfirmasi</div>
            </div>
        </div>

        {{-- Catatan --}}
        @if(!empty($offer->notes))
            <p class="section-title">Catatan</p>
            <div class="info-box">{{ $offer->notes }}</div>
        @endif

        {{-- Detail item --}}
        @if($details->count())
            <p class="section-title">Rincian penawaran</p>
            <div class="items-wrap">
                <div class="items-head">
                    <span>#</span>
                    <span>Paket / Layanan</span>
                    <span style="text-align:center;">Qty</span>
                    <span class="r">Harga satuan</span>
                    <span class="r">Subtotal</span>
                </div>

                @php $grandTotal = 0; @endphp
                @foreach($details as $i => $detail)
                    @php
                        $subtotal    = (float) $detail->price * (int) $detail->qty;
                        $grandTotal += $subtotal;
                    @endphp
                    <div class="item-row">
                        <div class="item-no">{{ $i + 1 }}</div>
                        <div class="item-name">{{ $detail->package->name ?? '—' }}</div>
                        <div class="item-qty">
                            <span class="qty-badge">×{{ $detail->qty }}</span>
                        </div>
                        <div class="item-price">Rp {{ number_format((float) $detail->price, 0, ',', '.') }}</div>
                        <div class="item-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                    </div>
                @endforeach

                <div class="total-row">
                    <span class="total-label">Total keseluruhan</span>
                    <span class="total-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
            </div>
        @endif

        {{-- Syarat & Ketentuan --}}
        @if(!empty($offer->terms))
            <p class="section-title">Syarat &amp; Ketentuan</p>
            <div class="info-box">{{ $offer->terms }}</div>
        @endif

        {{-- CTA --}}
        <div class="cta-wrap">
            <p>Klik tombol berikut untuk melihat penawaran lengkap dan melakukan konfirmasi:</p>
            <a href="{{ $link }}" class="btn-cta">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 12l2 2 4-4"/><path d="M21 12c0 4.97-4.03 9-9 9S3 16.97 3 12 7.03 3 12 3s9 4.03 9 9z"/>
                </svg>
                Lihat &amp; Konfirmasi Penawaran
            </a>
            <p class="url-note">
                Atau buka link ini di browser Anda:<br>
                <a href="{{ $link }}">{{ $link }}</a>
            </p>
        </div>

    </div>

    {{-- ── FOOTER ── --}}
    <div class="ft">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.</p>
        <p>Email ini dikirim otomatis, mohon tidak membalas langsung.</p>
    </div>

</div>
</body>
</html>