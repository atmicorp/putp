<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Kerjasama (PKS)</title>
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

        .section-header {
            font-size: 9pt; font-weight: bold; text-transform: uppercase;
            border-bottom: 1.5px solid #000; padding-bottom: 2px;
            margin-top: 10px; margin-bottom: 5px;
        }

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

        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 16px;}
        .ttd-table td {
            padding: 7px 12px 5px;
            text-align: center; vertical-align: top; font-size: 9pt;
        }
        .ttd-title { font-weight: bold; margin-bottom: 55px; }
        .ttd-line { border-top: 1px solid #000; padding-top: 3px; font-weight: bold; display: inline-block; min-width: 160px; }
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
        <h1>Surat Permohonan Kerjasama (PKS)</h1>
        <p>Nomor : </p>
    </div>

    {{-- KEPADA --}}
    <div class="paragraf" style="margin-bottom: 10px;">
        Kepada Yth.<br>
        Manajer PUTP<br>
        Politeknik ATMI Surakarta
    </div>

    <div class="paragraf">Dengan hormat,</div>

    <div class="paragraf">
        Sehubungan dengan rencana kegiatan yang akan kami laksanakan, melalui surat ini kami
        bermaksud mengajukan permohonan kerjasama dengan PUTP Politeknik ATMI Surakarta
        dengan rincian sebagai berikut:
    </div>

   
    <table class="rincian-table">
        <tr>
            <td class="label">Nama</td>
            <td class="sep">:</td>
            <td class="value">{{ optional($order->contact)->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nama Instansi / Perusahaan</td>
            <td class="sep">:</td>
            <td class="value">{{ optional($order->company)->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="sep">:</td>
            <td class="value">{{ optional($order->company)->address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Telepon</td>
            <td class="sep">:</td>
            <td class="value">{{ optional($order->contact)->phone ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td class="sep">:</td>
            <td class="value">{{ optional($order->contact)->email ?? '-' }}</td>
        </tr>
    </table>

   <div class="paragraf">
        Adapun ruang lingkup kerjasama yang kami ajukan adalah:
    </div>

    <table class="rincian-table">
        <tr>
            <td class="label">Jenis Jasa</td>
            <td class="sep">:</td>
            
            <td class="value">
                {{ $categoryLabel }}
            </td>
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
            <td class="label">Waktu Pelaksanaan yang Diharapkan</td>
            <td class="sep">:</td>
            <td class="value">
                {{ $order->waktu_diharapkan  ? \Carbon\Carbon::parse($order->waktu_diharapkan)->translatedFormat('l - d F Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td class="label">Keterangan Tambahan</td>
            <td class="sep">:</td>
            <td class="value">{{ $order->keterangan_tambahan ?? '-' }}</td>
        </tr>
    </table>

    {{-- PENUTUP --}}
    <div class="paragraf">
        Kami berharap kerjasama ini dapat terlaksana dengan baik. Sebagai bentuk komitmen,
        kami bersedia mengikuti ketentuan dan prosedur yang berlaku di PUTP Politeknik ATMI Surakarta.
    </div>

    <div class="paragraf">
        Demikian permohonan ini kami sampaikan. Atas perhatian dan kerjasama yang diberikan,
        kami ucapkan terima kasih.
    </div>

    {{-- TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            <td style="text-align: center;">
                <div style="margin-bottom: 6px;">
                    {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}
                </div>
                <div class="ttd-title">Hormat kami,</div>

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
                    {{ optional($order->contact)->jabatan }}
                </div>
            </td>
        </tr>
    </table>


</body>
</html>