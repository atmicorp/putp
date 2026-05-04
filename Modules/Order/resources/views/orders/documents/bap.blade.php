<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Penyelesaian Kerjasama</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Roboto Serif', serif;
            font-size: 9pt;
            color: #000;
            background: #fff;
            width: 680px;
            margin: 0 auto;
            padding: 30px 40px;
        }

        .kop { padding: 6px; margin-bottom: 10px; }
        .kop img { width: 100%; display: block; }

        .judul { text-align: center; margin-bottom: 4px; }
        .judul h1 { font-size: 12pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .judul p { font-size: 9pt; }

        .paragraf {
            font-size: 9pt;
            text-align: justify;
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .pihak-header {
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 4px;
            margin-top: 10px;
        }

        .pihak-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .pihak-table td { padding: 1px 0; vertical-align: top; font-size: 9pt; }
        .pihak-table td.label { width: 70px; white-space: nowrap; }
        .pihak-table td.sep { width: 12px; text-align: left; }
        .pihak-table td.value { width: auto; }

        .berdasarkan-list { margin: 4px 0 10px 20px; }
        .berdasarkan-list li { font-size: 9pt; line-height: 1.7; text-align: justify; }

        .rincian-table { width: 100%; border-collapse: collapse; margin: 4px 0 10px; }
        .rincian-table td { padding: 2px 0; vertical-align: top; font-size: 9pt; }
        .rincian-table td.no { width: 20px; }
        .rincian-table td.label { width: 165px; white-space: nowrap; }
        .rincian-table td.sep { width: 12px; text-align: center; }
        .rincian-table td.value { width: auto; }

        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .ttd-table td {
            padding: 7px 12px 5px;
            text-align: center; vertical-align: top; font-size: 9pt;
            width: 50%;
        }
        .ttd-title { font-weight: bold; margin-bottom: 55px; }
        .ttd-line { border-top: 1px solid #000; padding-top: 3px; font-weight: bold; display: inline-block; min-width: 160px; }
        .ttd-role { font-style: italic; font-size: 8.5pt; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <img src="{{ public_path('images/kop.png') }}" alt="Kop Surat">
    </div>

    {{-- JUDUL --}}
    <div class="judul">
        <h1>Berita Acara Penyelesaian Kerjasama</h1>
        <p>Nomor : </p>
    </div>

    <br>

    {{-- PEMBUKA --}}
    <div class="paragraf">
        Pada hari ini,
        {{ \Carbon\Carbon::parse($order->tanggal_selesai ?? $order->updated_at)->translatedFormat('l') }}
        tanggal
        {{ \Carbon\Carbon::parse($order->tanggal_selesai ?? $order->updated_at)->translatedFormat('d') }}
        bulan
        {{ \Carbon\Carbon::parse($order->tanggal_selesai ?? $order->updated_at)->translatedFormat('F') }}
        tahun
        {{ \Carbon\Carbon::parse($order->tanggal_selesai ?? $order->updated_at)->translatedFormat('Y') }},
        bertempat di PUTP Politeknik ATMI Surakarta, telah dilaksanakan penyelesaian
        kegiatan kerjasama antara:
    </div>

    {{-- PIHAK PERTAMA --}}
    <div class="pihak-header">Pihak Pertama</div>
    <table class="pihak-table">
        <tr>
            <td class="label">Nama</td>
            <td class="sep">:</td>
            <td class="value">Ir. Bondan Wiratmoko BS, S.T., M.Eng</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="sep">:</td>
            <td class="value">Manajer PUTP Politeknik ATMI Surakarta</td>
        </tr>
        <tr>
            <td class="label">Instansi</td>
            <td class="sep">:</td>
            <td class="value">Politeknik ATMI Surakarta</td>
        </tr>
    </table>

    {{-- PIHAK KEDUA --}}
    <div class="pihak-header">Pihak Kedua</div>
    <table class="pihak-table">
        <tr>
            <td class="label">Nama</td>
            <td class="sep">:</td>
            <td class="value">{{ optional($order->contact)->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="sep">:</td>
            <td class="value">{{ optional($order->contact)->jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Instansi</td>
            <td class="sep">:</td>
            <td class="value">{{ optional($order->company)->name ?? '-' }}</td>
        </tr>
    </table>

    {{-- BERDASARKAN --}}
    <div class="paragraf">Berdasarkan:</div>
    <ol class="berdasarkan-list">
        <li>
            Surat Permohonan Kerjasama {{ optional($order->company)->name ?? '[Nama Instansi/Perusahaan]' }}
            dengan Politeknik ATMI
        </li>
        <li>Perjanjian Kerjasama Nomor [...] tanggal [...]</li>
        <li>Surat Kesanggupan Kerjasama Nomor [...] tanggal [...]</li>
    </ol>

    {{-- PERNYATAAN --}}
    <div class="paragraf">
        Dengan ini menyatakan bahwa kegiatan kerjasama dengan rincian sebagai berikut
        telah selesai dilaksanakan:
    </div>

    {{-- RINCIAN --}}
    <table class="rincian-table">
        <tr>
            <td class="no">1.</td>
            <td class="label">Jenis Jasa</td>
            <td class="sep">:</td>
            <td class="value">{{ $categoryLabel }}</td>
        </tr>
        <tr>
            <td class="no">2.</td>
            <td class="label">Jumlah</td>
            <td class="sep">:</td>
            <td class="value">{{ $totalQty }}</td>
        </tr>
        <tr>
            <td class="no">3.</td>
            <td class="label">Tujuan Pengujian</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->tujuan_pengujian ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">4.</td>
            <td class="label">Waktu Pelaksanaan</td>
            <td class="sep">:</td>
            <td class="value">
                {{ $order->waktu_diharapkan ? \Carbon\Carbon::parse($order->waktu_diharapkan)->translatedFormat('l - d F Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td class="no">5.</td>
            <td class="label">Keterangan Tambahan</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->keterangan_tambahan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">6.</td>
            <td class="label">Lokasi Pelaksanaan</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->lokasi_pelaksanaan ?? '-' }}</td>
        </tr>
    </table>

    {{-- PENUTUP --}}
    <div class="paragraf">
        Hasil kerjasama telah diserahkan kepada Pihak Kedua dan dapat digunakan
        sebagaimana mestinya. Dengan ditandatanganinya berita acara ini, maka kegiatan
        kerjasama dinyatakan <strong>telah selesai</strong>.
    </div>

    {{-- TANDA TANGAN --}}
    <div style="text-align: right; margin-top: 16px; font-size: 9pt;">
        Surakarta, {{ \Carbon\Carbon::parse($order->tanggal_selesai ?? $order->updated_at)->translatedFormat('d F Y') }}
    </div>

    <table class="ttd-table">
        <tr>
            {{-- PIHAK PERTAMA --}}
            <td>
                <div class="ttd-title">Pihak Pertama,</div>
                @if(optional($manager)->signature_path)
                        <div style="margin-bottom: 4px;">
                            <img
                                src="{{ Storage::disk('private')->path($manager->signature_path) }}"
                                style="height: 55px; object-fit: contain;"
                            >
                        </div>
                    @else
                        <div style="height: 55px;"></div>
                    @endif
                <div>
                    <span class="ttd-line">Ir. Bondan Wiratmoko BS, S.T., M.Eng</span>
                </div>
                <div class="ttd-role">Manajer PUTP Politeknik ATMI Surakarta</div>
            </td>

            {{-- PIHAK KEDUA --}}
            <td>
                <div class="ttd-title">Pihak Kedua,</div>

                @if(optional($order->contact)->signature_path)
                    <div style="margin-bottom: 4px;">
                        <img src="{{ storage_path('app/private/' . $order->contact->signature_path) }}"
                            style="height: 55px; object-fit: contain;">
                    </div>
                @else
                    <div style="height: 55px; line-height: 55px; font-size: 9pt;">
                        (......)
                    </div>
                @endif

                <div>
                    <span class="ttd-line">
                        {{ optional($order->contact)->name ?? '[Nama Lengkap]' }}
                    </span>
                </div>
                <div class="ttd-role">
                    {{ optional($order->contact)->jabatan ?? '[Jabatan]' }}
                </div>
            </td>
        </tr>
    </table>

</body>
</html>