<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kegiatan Kerjasama</title>
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

        .judul { text-align: center; margin-bottom: 12px; }
        .judul h1 { font-size: 12pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }

        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .info-table td { padding: 2px 0; vertical-align: top; font-size: 9pt; }
        .info-table td.label { width: 210px; white-space: nowrap; }
        .info-table td.sep { width: 12px; }
        .info-table td.value { width: auto; }

        .section-title {
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 4px;
            margin-top: 12px;
        }

        .paragraf {
            font-size: 9pt;
            text-align: justify;
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .hasil-list { margin: 4px 0 6px 20px; }
        .hasil-list li { font-size: 9pt; line-height: 1.7; }

        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .ttd-table td {
            padding: 7px 12px 5px;
            text-align: center; vertical-align: top; font-size: 9pt;
            width: 50%;
        }
        .ttd-title { font-weight: normal; margin-bottom: 55px; }
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
        <h1>Laporan Kegiatan Kerjasama</h1>
    </div>

    {{-- INFO HEADER --}}
    <table class="info-table">
        <tr>
            <td class="label">Nama Pelaksana Kegiatan</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->pelaksana ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kegiatan</td>
            <td class="sep">:</td>
            <td class="value">{{ $categoryLabel }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Surat Kesanggupan</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->nomor_surat_kesanggupan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Berita Acara Penyelesaian</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->nomor_berita_acara ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pelaksanaan</td>
            <td class="sep">:</td>
            <td class="value">
                {{ $order->waktu_diharapkan ? \Carbon\Carbon::parse($order->waktu_diharapkan)->translatedFormat('d F Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Lokasi Kegiatan</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->lokasi_pelaksanaan ?? 'PUTP Politeknik ATMI Surakarta' }}</td>
        </tr>
    </table>

    {{-- TUJUAN KEGIATAN --}}
    <div class="section-title">Tujuan Kegiatan :</div>
    <div class="paragraf">
        Melaksanakan kegiatan kerjasama antara {{ optional($order->company)->name ?? '[Nama Instansi/Perusahaan]' }}
        dengan Politeknik ATMI Surakarta {{ $order->tujuan_pengujian ?? '[...]' }}
        guna memperoleh hasil sesuai kebutuhan pihak pemohon, berdasarkan
        Berita Acara Penyelesaian Nomor {{ $order->nomor_berita_acara ?? '[...]' }}
        tanggal {{ $order->tanggal_selesai ? \Carbon\Carbon::parse($order->tanggal_selesai)->translatedFormat('d F Y') : '[...]' }}.
    </div>

    {{-- HASIL KEGIATAN --}}
    <div class="section-title">Hasil Kegiatan :</div>
    <div class="paragraf">
        Kegiatan kerjasama telah dilaksanakan sesuai dengan permohonan kerjasama yang
        diajukan. Kerjasama dilakukan terhadap {{ $order->objek_kerjasama ?? '[...]' }}
        sebanyak {{ $totalQty }} buah/spesimen.
    </div>

    <div class="paragraf">
        Pelaksanaan kerjasama meliputi tahap persiapan alat serta pencatatan data hasil
        kerjasama. Selama kegiatan berlangsung, kegiatan berjalan dengan {{ $order->kondisi_kegiatan ?? '[...]' }}.
    </div>

    <div class="paragraf">
        Berdasarkan hasil kerjasama yang telah dilakukan, diperoleh data {{ $order->deskripsi_hasil ?? '[...]' }}
    </div>
    <ol class="hasil-list">
        <li>Pihak Kedua</li>
        <li>Dosen/instruktur yang terlibat</li>
        <li>Mahasiswa yang terlibat</li>
        <li>Data Deskripsi Kegiatan - Lampiran</li>
    </ol>
    <div class="paragraf">
        yang selanjutnya diserahkan kepada pihak kedua untuk digunakan sebagaimana
        mestinya.
    </div>

    {{-- USULAN DAN SARAN --}}
    <div class="section-title">Usulan dan Saran :</div>
    <div class="paragraf">
        {{ $order->usulan_saran ?? '[...]' }}
    </div>

    {{-- PENUTUP --}}
    <div class="paragraf">
        Demikian Laporan Kegiatan Kerjasama ini kami sampaikan. Atas perhatian dan
        kerjasama yang dilakukan, kami ucapkan terima kasih.
    </div>

    {{-- TANDA TANGAN --}}
    <div style="text-align: right; margin-top: 16px; font-size: 9pt;">
        Surakarta, {{ \Carbon\Carbon::parse($order->tanggal_selesai ?? $order->updated_at)->translatedFormat('d F Y') }}
    </div>

    <table class="ttd-table">
        <tr>
            {{-- DISETUJUI OLEH --}}
            <td>
                <div class="ttd-title">Disetujui oleh,</div>
                <div style="height: 55px; line-height: 55px; font-size: 9pt;">
                    (......)
                </div>
                <div>
                    <span class="ttd-line">{{ $order->disetujui_oleh ?? '[Nama Lengkap]' }}</span>
                </div>
                <div class="ttd-role">{{ $order->jabatan_penyetuju ?? '[Jabatan]' }}</div>
            </td>

            {{-- DIBUAT OLEH --}}
            <td>
                <div class="ttd-title">Dibuat oleh,</div>
                <div style="height: 55px; line-height: 55px; font-size: 9pt;">
                    (......)
                </div>
                <div>
                    <span class="ttd-line">{{ $order->pelaksana ?? '[Nama Lengkap Pelaksana]' }}</span>
                </div>
                <div class="ttd-role">{{ $order->jabatan_pelaksana ?? '[Jabatan]' }}</div>
            </td>
        </tr>
    </table>

</body>
</html>