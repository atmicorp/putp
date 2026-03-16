<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderOffer;
use App\Models\OrderOfferDetail;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $admin    = User::where('role', 'admin')->first();
        $staff    = User::where('role', 'staff')->first();
        $packages = Package::where('is_active', true)->get()->keyBy('name');

        $notes_terms = [
            'default_terms' =>
                "1. Spesimen diserahkan ke laboratorium dalam kondisi siap uji.\n" .
                "2. Pembayaran dilakukan sebelum pengambilan laporan hasil uji.\n" .
                "3. Laporan hasil uji diterbitkan paling lambat 5 hari kerja setelah pengujian selesai.\n" .
                "4. Harga belum termasuk PPN 11%.",
            'fast_terms' =>
                "1. Layanan reguler — hasil uji 5 hari kerja.\n" .
                "2. Pembayaran DP 50% saat penyerahan spesimen.\n" .
                "3. Spesimen yang telah diuji dapat diambil kembali dalam 14 hari.",
        ];

        $orders = [

            // ── DRAFT ───────────────────────────────────────────────

            [
                'customer_name'  => 'PT. Petrokimia Plastindo',
                'customer_email' => 'qa@plastindo.co.id',
                'status'         => Order::STATUS_DRAFT,
                'created_by'     => $staff->id,
                'sent_at'        => null,
                'notes'          => 'Customer mengirimkan sampel PP dan HDPE dari lini produksi baru. Memerlukan data untuk validasi proses injection molding.',
                'terms'          => null,
                'items'          => [
                    ['package' => 'Uji Tarik Plastik / Polimer',    'qty' => 10, 'price' => 275000],
                    ['package' => 'Uji Lentur / Bending (3-Point)', 'qty' => 10, 'price' => 300000],
                    ['package' => 'Uji Kekerasan Shore D – Plastik Lunak', 'qty' => 5, 'price' => 125000],
                ],
            ],
            [
                'customer_name'  => 'CV. Karet Alam Nusantara',
                'customer_email' => 'produksi@karetalam.id',
                'status'         => Order::STATUS_DRAFT,
                'created_by'     => $staff->id,
                'sent_at'        => null,
                'notes'          => 'Perlu pengujian batch karet vulkanisat terbaru sebelum pengiriman ke buyer Jepang.',
                'terms'          => null,
                'items'          => [
                    ['package' => 'Uji Tarik Karet & Elastomer',        'qty' => 15, 'price' => 250000],
                    ['package' => 'Uji Kekerasan Shore A – Karet',      'qty' => 15, 'price' => 125000],
                ],
            ],

            // ── OFFERED ─────────────────────────────────────────────

            [
                'customer_name'  => 'PT. Baja Konstruksi Utama',
                'customer_email' => 'engineering@bajakonstruksi.co.id',
                'status'         => Order::STATUS_OFFERED,
                'created_by'     => $admin->id,
                'sent_at'        => now()->subDays(2),
                'notes'          => "Pengujian untuk sertifikasi baja tulangan proyek gedung bertingkat.\nStandar yang diminta: SNI 2052:2017 dan ISO 6892-1.",
                'terms'          => $notes_terms['default_terms'],
                'items'          => [
                    ['package' => 'Uji Tarik Logam & Alloy',              'qty' => 20, 'price' => 350000],
                    ['package' => 'Uji Kekerasan Rockwell – Logam',       'qty' => 20, 'price' => 175000],
                    ['package' => 'Uji Impak Charpy – Logam',             'qty' => 10, 'price' => 300000],
                ],
            ],
            [
                'customer_name'  => 'Balai Besar Industri Agro – BUMN',
                'customer_email' => 'laboratorium@bbia.go.id',
                'status'         => Order::STATUS_OFFERED,
                'created_by'     => $staff->id,
                'sent_at'        => now()->subDays(1),
                'notes'          => 'Pengujian komponen plastik food-grade untuk program substitusi impor. Dibutuhkan data tensile dan impak untuk pengajuan SNI.',
                'terms'          => $notes_terms['fast_terms'],
                'items'          => [
                    ['package' => 'Paket Uji Mekanik Lengkap – Plastik', 'qty' => 3, 'price' => 850000],
                    ['package' => 'Uji Tarik Plastik / Polimer',         'qty' => 5, 'price' => 275000],
                ],
            ],
            [
                'customer_name'  => 'PT. Serat Komposit Indonesia',
                'customer_email' => 'rd@seratkomposit.co.id',
                'status'         => Order::STATUS_OFFERED,
                'created_by'     => $admin->id,
                'sent_at'        => now()->subDays(3),
                'notes'          => 'R&D material GFRP untuk aplikasi panel kapal. Memerlukan data mekanik lengkap dan sertifikat pengujian.',
                'terms'          => $notes_terms['default_terms'],
                'items'          => [
                    ['package' => 'Uji Tarik Komposit / Serat',           'qty' => 8, 'price' => 450000],
                    ['package' => 'Uji Impak Charpy – Komposit',          'qty' => 8, 'price' => 350000],
                    ['package' => 'Uji Lentur / Bending (3-Point)',        'qty' => 8, 'price' => 300000],
                ],
            ],

            // ── APPROVED ────────────────────────────────────────────

            [
                'customer_name'  => 'Dinas Pekerjaan Umum Kab. Karawang',
                'customer_email' => 'pu.karawang@jabarprov.go.id',
                'status'         => Order::STATUS_APPROVED,
                'created_by'     => $admin->id,
                'sent_at'        => now()->subDays(6),
                'notes'          => "Pengujian material untuk proyek jembatan. Spesimen baja diambil dari tiga supplier berbeda untuk evaluasi kelayakan.",
                'terms'          => $notes_terms['default_terms'],
                'items'          => [
                    ['package' => 'Uji Tarik Logam & Alloy',              'qty' => 9,  'price' => 350000],
                    ['package' => 'Uji Impak Charpy – Logam',             'qty' => 9,  'price' => 300000],
                    ['package' => 'Uji Kekerasan Brinell – Logam Kasar',  'qty' => 9,  'price' => 200000],
                ],
            ],

            // ── PROCESSING ──────────────────────────────────────────

            [
                'customer_name'  => 'PT. Indorama Synthetics Tbk',
                'customer_email' => 'qc.lab@indorama.co.id',
                'status'         => Order::STATUS_PROCESSING,
                'created_by'     => $staff->id,
                'sent_at'        => now()->subDays(9),
                'notes'          => 'Pengujian rutin bulanan spesimen PET dan Polyester fiber dari lini produksi. Customer tetap.',
                'terms'          => $notes_terms['fast_terms'],
                'items'          => [
                    ['package' => 'Paket Uji Mekanik Lengkap – Plastik', 'qty' => 5, 'price' => 850000],
                ],
            ],
            [
                'customer_name'  => 'PT. Wahana Konstruksi Mandiri',
                'customer_email' => 'lab@wahanakon.co.id',
                'status'         => Order::STATUS_PROCESSING,
                'created_by'     => $admin->id,
                'sent_at'        => now()->subDays(7),
                'notes'          => 'Kontraktor sipil memerlukan data uji baja tulangan dan profil WF untuk dokumen as-built proyek.',
                'terms'          => $notes_terms['default_terms'],
                'items'          => [
                    ['package' => 'Paket Uji Mekanik Lengkap – Logam',   'qty' => 6,  'price' => 750000],
                    ['package' => 'Uji Kekerasan Rockwell – Logam',       'qty' => 6,  'price' => 175000],
                ],
            ],

            // ── DONE ────────────────────────────────────────────────

            [
                'customer_name'  => 'PT. Bridgestone Tire Indonesia',
                'customer_email' => 'quality@bridgestone.co.id',
                'status'         => Order::STATUS_DONE,
                'created_by'     => $admin->id,
                'sent_at'        => now()->subDays(14),
                'notes'          => 'Pengujian berkala komponen karet untuk audit kualitas internal. Laporan sudah diterima dan disetujui tim QA customer.',
                'terms'          => $notes_terms['fast_terms'],
                'items'          => [
                    ['package' => 'Paket Uji Mekanik Lengkap – Karet', 'qty' => 8, 'price' => 600000],
                    ['package' => 'Uji Impak Izod – Plastik',          'qty' => 4, 'price' => 250000],
                ],
            ],
            [
                'customer_name'  => 'Pusat Penelitian Metalurgi – BRIN',
                'customer_email' => 'metalurgi@brin.go.id',
                'status'         => Order::STATUS_DONE,
                'created_by'     => $staff->id,
                'sent_at'        => now()->subDays(18),
                'notes'          => 'Pengujian spesimen alloy aluminium untuk publikasi jurnal nasional terakreditasi.',
                'terms'          => $notes_terms['default_terms'],
                'items'          => [
                    ['package' => 'Uji Tarik Logam & Alloy',             'qty' => 6, 'price' => 350000],
                    ['package' => 'Uji Kekerasan Brinell – Logam Kasar', 'qty' => 6, 'price' => 200000],
                    ['package' => 'Uji Impak Charpy – Logam',            'qty' => 6, 'price' => 300000],
                ],
            ],

            // ── REJECTED ────────────────────────────────────────────

            [
                'customer_name'  => 'UD. Plastik Jaya Abadi',
                'customer_email' => 'admin@plastikjaya.id',
                'status'         => Order::STATUS_REJECTED,
                'created_by'     => $staff->id,
                'sent_at'        => now()->subDays(4),
                'notes'          => 'Customer membatalkan karena memilih lab lain yang lebih dekat dengan lokasi pabrik.',
                'terms'          => null,
                'items'          => [
                    ['package' => 'Uji Tarik Plastik / Polimer',    'qty' => 3, 'price' => 275000],
                    ['package' => 'Uji Tekan (Compressive Strength)', 'qty' => 3, 'price' => 300000],
                ],
            ],
        ];

        foreach ($orders as $data) {
            $items = collect($data['items'])->map(function ($item) use ($packages) {
                $pkg = $packages->get($item['package']);
                return $pkg ? array_merge($item, ['package_id' => $pkg->id]) : null;
            })->filter();

            if ($items->isEmpty()) continue;

            $order = Order::create([
                'customer_name'  => $data['customer_name'],
                'customer_slug'  => Str::slug($data['customer_name']),
                'customer_email' => $data['customer_email'],
                'status'         => $data['status'],
                'created_by'     => $data['created_by'],
                'sent_at'        => $data['sent_at'],
            ]);

            $offer = OrderOffer::create([
                'order_id' => $order->id,
                'notes'    => $data['notes'],
                'terms'    => $data['terms'],
            ]);

            foreach ($items as $item) {
                OrderOfferDetail::create([
                    'order_offer_id' => $offer->id,
                    'package_id'     => $item['package_id'],
                    'qty'            => $item['qty'],
                    'price'          => $item['price'],
                ]);
            }
        }
    }
}