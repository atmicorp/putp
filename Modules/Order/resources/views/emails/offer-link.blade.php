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
            background-color: #f4f6f9;
            color: #333;
            font-size: 15px;
            line-height: 1.6;
        }
        .wrapper {
            max-width: 620px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }

        /* Header */
        .header {
            background-color: #1a56db;
            padding: 32px 40px;
            text-align: center;
        }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 600; }
        .header p  { color: #c3d5f8; font-size: 13px; margin-top: 4px; }

        /* Body */
        .body { padding: 36px 40px; }
        .greeting { font-size: 16px; font-weight: 600; margin-bottom: 10px; }
        .intro { color: #555; margin-bottom: 28px; }

        /* Meta box */
        .meta-box {
            background: #f8faff;
            border: 1px solid #dce8ff;
            border-radius: 6px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }
        .meta-box table { width: 100%; border-collapse: collapse; }
        .meta-box td { padding: 5px 0; font-size: 14px; color: #444; }
        .meta-box td:first-child { width: 42%; color: #888; }
        .meta-box td:last-child { font-weight: 600; }

        /* Section title */
        .section-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #1a56db;
            margin-bottom: 10px;
        }

        /* Notes / Terms */
        .info-box {
            background: #f0f4ff;
            border-left: 4px solid #1a56db;
            padding: 12px 16px;
            border-radius: 0 6px 6px 0;
            font-size: 13px;
            color: #334;
            margin-bottom: 24px;
            white-space: pre-line;
        }

        /* Items table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
            font-size: 14px;
        }
        .items-table thead tr { background-color: #1a56db; color: #fff; }
        .items-table thead th {
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
        }
        .items-table thead th.r { text-align: right; }
        .items-table tbody tr:nth-child(even) { background-color: #f8faff; }
        .items-table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .items-table tbody td.r { text-align: right; white-space: nowrap; }
        .items-table tfoot td {
            padding: 10px 12px;
            font-weight: 700;
            font-size: 15px;
            border-top: 2px solid #1a56db;
        }
        .items-table tfoot td.r { text-align: right; color: #1a56db; }

        /* CTA */
        .cta-wrap { text-align: center; margin: 32px 0 8px; }
        .cta-wrap p { color: #555; font-size: 14px; margin-bottom: 16px; }
        .btn-cta {
            display: inline-block;
            background-color: #1a56db;
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 34px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
        }
        .url-note {
            margin-top: 14px;
            font-size: 12px;
            color: #999;
            word-break: break-all;
        }

        /* Footer */
        .footer {
            background-color: #f4f6f9;
            padding: 20px 40px;
            text-align: center;
            font-size: 12px;
            color: #bbb;
            border-top: 1px solid #e8ecf0;
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <p>Surat Penawaran Resmi</p>
    </div>

    {{-- Body --}}
    <div class="body">

        <p class="greeting">Yth. {{ $order->customer_email }},</p>
        <p class="intro">
            Terima kasih atas kepercayaan Anda. Kami telah menyiapkan penawaran berikut untuk Anda.
            Silakan tinjau detail di bawah, kemudian konfirmasi melalui tombol di bagian bawah email ini.
        </p>

        {{-- Meta --}}
        <div class="meta-box">
            <table>
                <tr>
                    <td>No. Order</td>
                    <td>{{ $order->order_code }}</td>
                </tr>
                <tr>
                    <td>Tanggal Penawaran</td>
                    <td>{{ now()->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>Menunggu Konfirmasi</td>
                </tr>
            </table>
        </div>

        {{-- Catatan dari offer --}}
        @if(!empty($offer->notes))
            <p class="section-title">Catatan</p>
            <div class="info-box">{{ $offer->notes }}</div>
        @endif

        {{-- Detail item --}}
        {{-- <p class="section-title">Rincian Penawaran</p>
        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Paket / Layanan</th>
                    <th>Qty</th>
                    <th class="r">Harga Satuan</th>
                    <th class="r">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($details as $i => $detail)
                    @php
                        $subtotal    = (float) $detail->price * (int) $detail->qty;
                        $grandTotal += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $detail->package->name ?? '-' }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td class="r">Rp {{ number_format((float) $detail->price, 0, ',', '.') }}</td>
                        <td class="r">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total</td>
                    <td class="r">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table> --}}

        {{-- Syarat & Ketentuan --}}
        @if(!empty($offer->terms))
            <p class="section-title">Syarat &amp; Ketentuan</p>
            <div class="info-box">{{ $offer->terms }}</div>
        @endif

        {{-- CTA --}}
        <div class="cta-wrap">
            <p>Klik tombol berikut untuk melihat penawaran lengkap dan melakukan konfirmasi:</p>
            <a href="{{ $link }}" class="btn-cta">Lihat &amp; Konfirmasi Penawaran</a>
            <p class="url-note">
                Atau buka link ini di browser Anda:<br>
                <a href="{{ $link }}" style="color:#1a56db;">{{ $link }}</a>
            </p>
        </div>

    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.</p>
        <p style="margin-top:4px;">Email ini dikirim otomatis, mohon tidak membalas langsung.</p>
    </div>

</div>
</body>
</html>