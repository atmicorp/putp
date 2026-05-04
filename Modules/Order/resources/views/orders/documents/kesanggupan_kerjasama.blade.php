<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Kesanggupan Kerjasama</title>
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

        .rule { border: none; border-top: 1.5px solid #000; margin: 6px 0 10px; }

        .rincian-table { width: 100%; border-collapse: collapse; margin: 4px 0 10px; }
        .rincian-table td { padding: 2px 0; vertical-align: top; font-size: 9pt; }
        .rincian-table td.label { width: 185px; white-space: nowrap; }
        .rincian-table td.sep { width: 12px; text-align: center; }
        .rincian-table td.value { width: auto; }

        .paragraf {
            font-size: 9pt;
            text-align: justify;
            line-height: 1.7;
            margin-bottom: 8px;
        }

        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .ttd-table td {
            padding: 7px 12px 5px;
            text-align: center; vertical-align: top; font-size: 9pt;
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
        <h1>Surat Kesanggupan Kerjasama</h1>
        <p>Nomor : </p>
    </div>

    <br>

    {{-- KEPADA --}}
    <div class="paragraf" style="margin-bottom: 10px;">
        Kepada Yth.<br>
        {{ optional($order->company)->name ?? '[Nama Instansi/Perusahaan Pemohon]' }}<br>
        {{ optional($order->company)->address ?? '[Alamat Instansi Pemohon]' }}
    </div>

    <div class="paragraf">Dengan hormat,</div>

    <div class="paragraf">
        Menindaklanjuti surat permohonan kerjasama pengujian dari
        {{ optional($order->company)->name ?? '[Nama Instansi/Perusahaan]' }}
        nomor [...] tanggal [...], dengan ini kami menyatakan
        kesanggupan untuk melaksanakan kegiatan pengujian dengan rincian sebagai berikut:
    </div>

    <table class="rincian-table">
        <tr>
            <td class="label">Jenis Jasa</td>
            <td class="sep">:</td>
            <td class="value">{{ $categoryLabel }}</td>
        </tr>
        <tr>
            <td class="label">Jumlah</td>
            <td class="sep">:</td>
            <td class="value">{{ $totalQty }}</td>
        </tr>
        <tr>
            <td class="label">Tujuan Pengujian</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->tujuan_pengujian ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Waktu Pelaksanaan</td>
            <td class="sep">:</td>
            <td class="value">
                {{ $order->waktu_diharapkan ? \Carbon\Carbon::parse($order->waktu_diharapkan)->translatedFormat('l - d F Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Keterangan Tambahan</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->keterangan_tambahan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi Pelaksanaan</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->lokasi_pelaksanaan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Pelaksana</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->pic->name ?? '-' }}</td>
        </tr>
    </table>

    {{-- ISI --}}
    <div class="paragraf">
        Pelaksanaan kegiatan pengujian akan dilakukan sesuai dengan prosedur dan
        ketentuan yang berlaku di PUTP Politeknik ATMI Surakarta. Adapun hal-hal teknis
        lainnya akan dikoordinasikan lebih lanjut antara kedua belah pihak.
    </div>

    <div class="paragraf">
        Segala biaya yang timbul dalam pelaksanaan kegiatan ini akan disesuaikan dengan
        ketentuan yang berlaku.
    </div>

    {{-- PENUTUP --}}
    <div class="paragraf">
        Demikian surat kesanggupan ini kami sampaikan. Atas kepercayaan dan kerjasama
        yang diberikan, kami ucapkan terima kasih.
    </div>

    {{-- TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            <td style="text-align: right; padding-right: 40px;">
                <div style="display: inline-block; text-align: center;">
                    <div style="margin-bottom: 6px;">
                        Surakarta, {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}
                    </div>
                    <div class="ttd-title">Hormat kami,</div>

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
                        <span class="ttd-line">
                            Ir. Bondan Wiratmoko BS, S.T., M.Eng
                        </span>
                    </div>
                    <div class="ttd-role">
                        Manajer PUTP Politeknik ATMI Surakarta
                    </div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>