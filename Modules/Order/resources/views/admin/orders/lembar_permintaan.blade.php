<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Permintaan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            color: #000;
            background: #fff;
            width: 680px;
            margin: 0 auto;
            padding: 30px 40px;
        }

        .kop { border: 1px solid #999; padding: 6px; margin-bottom: 10px; }
        .kop img { width: 100%; display: block; }

        .judul { text-align: center; margin-bottom: 4px; }
        .judul h1 { font-size: 12pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .judul p { font-size: 9pt; font-style: italic; }

        .rule { border: none; border-top: 1.5px solid #000; margin: 6px 0 10px; }

        .section-header {
            font-size: 9pt; font-weight: bold; text-transform: uppercase;
            border-bottom: 1.5px solid #000; padding-bottom: 2px;
            margin-top: 10px; margin-bottom: 5px;
        }

        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 1px 0; vertical-align: top; border: none; font-size: 9pt; width: 50%; }
        .info-table tr.gap td { padding-top: 5px; }

        .service-table {
            width: 100%; border-collapse: collapse; font-size: 9pt;
            margin-top: 4px; margin-bottom: 8px; table-layout: fixed;
        }
        .service-table th {
            border: 1px solid #000; padding: 4px 5px;
            text-align: center; font-weight: bold; background-color: #d9d9d9;
        }
        .service-table td { border: 1px solid #000; padding: 3px 5px; vertical-align: top; word-wrap: break-word; }
        .service-table td.center { text-align: center; }
        .service-table td.right { text-align: right; }

        .notes-box {
            width: 100%; border: 1px solid #000; min-height: 50px;
            padding: 5px 7px; font-size: 9pt; margin-top: 4px; margin-bottom: 4px;
        }

        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .ttd-table td {
            width: 50%; border: 1px solid #000; padding: 7px 12px 5px;
            text-align: center; vertical-align: top; font-size: 9pt;
        }
        .ttd-title { font-weight: bold; margin-bottom: 50px; }
        .ttd-line { border-top: 1px solid #000; padding-top: 3px; font-weight: bold; }
        .ttd-role { font-style: italic; font-size: 8.5pt; }

        .footer { margin-top: 12px; font-size: 8pt; text-align: center; color: #444; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <img src="{{ public_path('images/kop.png') }}" alt="Kop Surat">
    </div>

    {{-- JUDUL --}}
    <div class="judul">
        <h1>Lembar Permintaan</h1>
        <p>(Service Request Form)</p>
    </div>
    <hr class="rule">

    {{-- INFORMASI ORDER --}}
    <div class="section-header">Informasi Order</div>

    <table class="info-table">
        <tr>
            <td>Kode Order<br>: {{ $order->order_code }}</td>
            <td>Tanggal Order<br>: {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr class="gap">
            <td>Status<br>: {{ ucfirst($order->status ?? '-') }}</td>
            <td>Dibuat Oleh<br>: {{ optional($order->creator)->name ?? '-' }}</td>
        </tr>
        <tr class="gap">
            <td>Kontak / Pemohon<br>: {{ optional($order->contact)->name ?? '-' }}</td>
            <td>Email Kontak<br>: {{ optional($order->contact)->email ?? '-' }}</td>
        </tr>
        <tr class="gap">
            <td>Telepon Kontak<br>: {{ optional($order->contact)->phone ?? '-' }}</td>
            <td>Perusahaan<br>: {{ optional($order->company)->name ?? '-' }}</td>
        </tr>
    </table>

    {{-- DETAIL LAYANAN --}}
    <div class="section-header">Detail Layanan yang Diminta</div>

    <table class="service-table">
        <colgroup>
            <col style="width:5%">
            <col style="width:22%">
            <col style="width:36%">
            <col style="width:7%">
            <col style="width:15%">
            <col style="width:15%">
        </colgroup>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Paket / Layanan</th>
                <th>Deskripsi</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse (optional($order->offer)->details ?? [] as $detail)
            <tr>
                <td class="center">{{ $no++ }}</td>
                <td>{{ optional($detail->package)->name ?? '-' }}</td>
                <td>{{ $detail->description ?? '-' }}</td>
                <td class="center">{{ $detail->qty ?? 1 }}</td>
                <td class="right">Rp {{ number_format($detail->unit_price ?? 0, 0, ',', '.') }},-</td>
                <td class="right">Rp {{ number_format(($detail->qty ?? 1) * ($detail->unit_price ?? 0), 0, ',', '.') }},-</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="center" style="font-style:italic; padding:8px; color:#555;">Belum ada detail layanan.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right; padding-right:6px; font-weight:bold; border:1px solid #000;">TOTAL</td>
                <td class="right" style="font-weight:bold; border:1px solid #000;">
                    Rp {{ number_format(collect(optional($order->offer)->details ?? [])->sum(fn($d) => ($d->qty ?? 1) * ($d->unit_price ?? 0)), 0, ',', '.') }},-
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- CATATAN --}}
    <div class="section-header">Catatan / Keterangan</div>
    <div class="notes-box">{{ $order->notes ?? $order->description ?? '' }}</div>

    {{-- TANDA TANGAN --}}
    {{-- <div class="section-header">Tanda Tangan</div>
    <table class="ttd-table">
        <tr>
            <td>
                <div class="ttd-title">Pemohon</div>
                <div class="ttd-line">{{ optional($order->contact)->name ?? 'Pemohon' }}</div>
                <div class="ttd-role">{{ optional($order->company)->name ?? 'Kontak / Pelanggan' }}</div>
            </td>
            <td>
                <div class="ttd-title">Diproses Oleh</div>
                <div class="ttd-line">{{ optional($order->creator)->name ?? 'Admin / Staf' }}</div>
                <div class="ttd-role">Admin / Staf</div>
            </td>
        </tr>
    </table> --}}

    {{-- FOOTER --}}
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        &nbsp;&middot;&nbsp; {{ $order->order_code }}
        &nbsp;&middot;&nbsp; Lembar Permintaan
    </div>

</body>
</html>