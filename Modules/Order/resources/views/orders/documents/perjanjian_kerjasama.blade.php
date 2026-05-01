<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perjanjian Kerjasama</title>
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

        .judul { text-align: center; margin-bottom: 14px; }
        .judul h1 { font-size: 11pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.6; }
        .judul p  { font-size: 9pt; margin-top: 2px; }

        .rule { border: none; border-top: 1.5px solid #000; margin: 6px 0 10px; }

        .paragraf {
            font-size: 9pt;
            text-align: justify;
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 9pt;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 4px;
        }

        .rincian-table { width: 100%; border-collapse: collapse; margin: 4px 0 10px; }
        .rincian-table td { padding: 2px 0; vertical-align: top; font-size: 9pt; }
        .rincian-table td.label { width: 120px; white-space: nowrap; }
        .rincian-table td.sep   { width: 12px; text-align: center; }
        .rincian-table td.value { width: auto; }

        .rincian-numbered { width: 100%; border-collapse: collapse; margin: 4px 0 10px; }
        .rincian-numbered td { padding: 2px 0; vertical-align: top; font-size: 9pt; }
        .rincian-numbered td.no    { width: 20px; }
        .rincian-numbered td.label { width: 160px; white-space: nowrap; }
        .rincian-numbered td.sep   { width: 12px; text-align: center; }
        .rincian-numbered td.value { width: auto; }

        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .ttd-table td {
            padding: 7px 12px 5px;
            text-align: center;
            vertical-align: top;
            font-size: 9pt;
            width: 50%;
        }
        .ttd-title  { font-weight: bold; margin-bottom: 55px; }
        .ttd-line   { border-top: 1px solid #000; padding-top: 3px; font-weight: bold; display: inline-block; min-width: 160px; }
        .ttd-role   { font-style: italic; font-size: 8.5pt; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <img src="{{ public_path('images/kop.png') }}" alt="Kop Surat">
    </div>

    {{-- JUDUL --}}
    <div class="judul">
        <h1>
            Memorandum of Agreement / Perjanjian Kerjasama<br>
            Nomor :<br>
            Tentang {{ $categoryLabel }}
        </h1>
    </div>

    {{-- PEMBUKA --}}
    <div class="paragraf">
        MoA ini dibuat dan ditandatangani pada hari ini,
        <strong>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('l') }}</strong>,
        tanggal <strong>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d') }}</strong>
        bulan <strong>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('F') }}</strong>
        tahun <strong>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('Y') }}</strong>,
        oleh dan antara:
    </div>

    {{-- PIHAK PERTAMA --}}
    <div class="section-title">Pihak Pertama</div>
    <table class="rincian-table">
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
    <div class="section-title">Pihak Kedua</div>
    <table class="rincian-table">
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
    <div class="paragraf" style="padding-left: 16px;">
        1. &nbsp; Surat Permohonan Kerjasama {{ optional($order->company)->name ?? '-' }} dengan Politeknik ATMI Surakarta.
    </div>

    {{-- ISI --}}
    <div class="paragraf">
        Dengan ini menyatakan bahwa kegiatan kerjasama yang tertuang dalam perjanjian ini,
        dengan rincian sebagai berikut:
    </div>

    <table class="rincian-numbered">
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
                {{ $order->waktu_diharapkan
                    ? \Carbon\Carbon::parse($order->waktu_diharapkan)->translatedFormat('l - d F Y')
                    : '-' }}
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
            <td class="value">Politeknik ATMI Surakarta</td>
        </tr>
    </table>

    {{-- PENUTUP --}}
    <div class="paragraf">
        MoA ini dilengkapi dengan lampiran-lampiran yang merupakan bagian tidak terpisahkan
        dari dokumen ini. MoA ini mulai berlaku efektif sejak tanggal ditandatangani oleh PARA PIHAK.
    </div>

    <div class="paragraf">
        Demikian MoA ini dibuat dengan kesadaran penuh dan tanpa paksaan dari pihak manapun,
        untuk dipergunakan sebagaimana mestinya.
    </div>

    {{-- TEMPAT TANGGAL --}}
    <div style="text-align: right; font-size: 9pt; margin-top: 10px;">
        {{ optional($order->company)->city ?? 'Surakarta' }},
        {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}
    </div>

    {{-- TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            {{-- Pihak Pertama --}}
            <td>
                <div class="ttd-title">Pihak Pertama,</div>

                {{-- Ruang TTD Kosong (admin isi manual) --}}
                <div style="height: 55px;"></div>

                <div>
                    <span class="ttd-line">Ir. Bondan Wiratmoko BS, S.T., M.Eng</span>
                </div>
                <div class="ttd-role">Manajer PUTP Politeknik ATMI Surakarta</div>
            </td>

            {{-- Pihak Kedua --}}
            <td>
                <div class="ttd-title">Pihak Kedua,</div>

                {{-- Gambar TTD --}}
                @if(optional($order->contact)->signature_path)
                    <div style="margin-bottom: 4px;">
                        <img src="{{ storage_path('app/private/' . $order->contact->signature_path) }}"
                             style="height: 55px; object-fit: contain;">
                    </div>
                @else
                    <div style="height: 55px;"></div>
                @endif

                <div>
                    <span class="ttd-line">
                        {{ optional($order->contact)->name ?? '.......................' }}
                    </span>
                </div>
                <div class="ttd-role">
                    {{ optional($order->contact)->jabatan ?? '' }}
                </div>
            </td>
        </tr>
    </table>

</body>
</html>