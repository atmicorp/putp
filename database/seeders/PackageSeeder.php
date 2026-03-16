<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\Operator;
use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $machines  = Machine::all()->keyBy('code');
        $operators = Operator::all();

        $op1 = $operators->get(0); // Hendra  → UTM, Charpy
        $op2 = $operators->get(1); // Dewi    → Rockwell, Brinell, Vickers
        $op3 = $operators->get(2); // Fajar   → Shore, UTM

        $packages = [

            // ══════════════════════════════════════════════
            // UTM — Universal Testing Machine (MCH-001)
            // ══════════════════════════════════════════════

            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Uji Tarik Plastik / Polimer',
                'description'     => 'Pengujian tensile strength, yield strength, dan elongation at break pada spesimen plastik sesuai standar ISO 527 / ASTM D638. Termasuk pembuatan laporan dan kurva tegangan-regangan.',
                'base_price'      => 275000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Uji Tarik Logam & Alloy',
                'description'     => 'Pengujian tensile strength, yield strength, UTS, dan elongation pada spesimen logam (baja, aluminium, tembaga) sesuai standar ISO 6892-1 / ASTM E8.',
                'base_price'      => 350000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op3?->id,
                'name'            => 'Uji Tarik Karet & Elastomer',
                'description'     => 'Pengujian tensile strength dan elongation at break pada spesimen karet vulkanisat dan elastomer sesuai standar ISO 37 / ASTM D412.',
                'base_price'      => 250000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Uji Tarik Komposit / Serat',
                'description'     => 'Pengujian tensile strength pada material komposit FRP, GFRP, CFRP sesuai standar ISO 527-4 / ASTM D3039. Termasuk analisis modulus dan kurva beban-displacement.',
                'base_price'      => 450000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Uji Tekan (Compressive Strength)',
                'description'     => 'Pengujian kuat tekan pada berbagai material termasuk plastik, komposit, dan beton polimer sesuai ISO 604 / ASTM D695.',
                'base_price'      => 300000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Uji Lentur / Bending (3-Point)',
                'description'     => 'Pengujian flexural strength dan flexural modulus metode 3-point bending sesuai ISO 178 / ASTM D790. Cocok untuk plastik, komposit, dan profil tipis.',
                'base_price'      => 300000,
                'is_active'       => true,
            ],

            // ══════════════════════════════════════════════
            // Rockwell Hardness Tester (MCH-002)
            // ══════════════════════════════════════════════

            [
                'machine_id'      => $machines['MCH-002']->id,
                'pic_operator_id' => $op2?->id,
                'name'            => 'Uji Kekerasan Rockwell – Logam',
                'description'     => 'Pengujian kekerasan Rockwell skala HRC/HRB pada spesimen logam, baja karbon, baja paduan, dan aluminium. Minimal 5 titik uji per spesimen sesuai ASTM E18.',
                'base_price'      => 175000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-002']->id,
                'pic_operator_id' => $op2?->id,
                'name'            => 'Uji Kekerasan Rockwell – Plastik Keras',
                'description'     => 'Pengujian kekerasan Rockwell skala HRR/HRM pada polimer keras (PP, ABS, Nylon, PC) sesuai ASTM D785.',
                'base_price'      => 150000,
                'is_active'       => true,
            ],

            // ══════════════════════════════════════════════
            // Charpy / Izod Impact Tester (MCH-003)
            // ══════════════════════════════════════════════

            [
                'machine_id'      => $machines['MCH-003']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Uji Impak Charpy – Logam',
                'description'     => 'Pengujian ketangguhan impak metode Charpy (notched) pada spesimen logam untuk menentukan energi serap dan transisi ulet-getas sesuai ISO 148-1 / ASTM E23.',
                'base_price'      => 300000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-003']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Uji Impak Izod – Plastik',
                'description'     => 'Pengujian ketangguhan impak metode Izod pada spesimen plastik dan polimer sesuai ISO 180 / ASTM D256. Hasil berupa nilai kJ/m².',
                'base_price'      => 250000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-003']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Uji Impak Charpy – Komposit',
                'description'     => 'Pengujian impak Charpy pada material komposit serat (GFRP/CFRP) untuk mengevaluasi ketahanan terhadap beban tiba-tiba sesuai ISO 179.',
                'base_price'      => 350000,
                'is_active'       => true,
            ],

            // ══════════════════════════════════════════════
            // Shore Durometer (MCH-004)
            // ══════════════════════════════════════════════

            [
                'machine_id'      => $machines['MCH-004']->id,
                'pic_operator_id' => $op3?->id,
                'name'            => 'Uji Kekerasan Shore A – Karet',
                'description'     => 'Pengujian kekerasan Shore A pada spesimen karet alam, karet sintetis, dan elastomer sesuai ASTM D2240 / ISO 7619-1. Minimal 5 titik pengukuran.',
                'base_price'      => 125000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-004']->id,
                'pic_operator_id' => $op3?->id,
                'name'            => 'Uji Kekerasan Shore D – Plastik Lunak',
                'description'     => 'Pengujian kekerasan Shore D pada plastik semi-rigid dan plastik lunak (PE, PP tipis, PVC lunak) sesuai ASTM D2240.',
                'base_price'      => 125000,
                'is_active'       => true,
            ],

            // ══════════════════════════════════════════════
            // Brinell Hardness Tester (MCH-005)
            // ══════════════════════════════════════════════

            [
                'machine_id'      => $machines['MCH-005']->id,
                'pic_operator_id' => $op2?->id,
                'name'            => 'Uji Kekerasan Brinell – Logam Kasar',
                'description'     => 'Pengujian kekerasan Brinell (HBW) pada logam dengan permukaan kasar, besi cor, dan material heterogen sesuai ISO 6506 / ASTM E10. Beban 750 atau 3000 kgf.',
                'base_price'      => 200000,
                'is_active'       => true,
            ],

            // ══════════════════════════════════════════════
            // Paket Bundling Multi-Uji
            // ══════════════════════════════════════════════

            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Paket Uji Mekanik Lengkap – Plastik',
                'description'     => 'Paket bundling pengujian mekanik komprehensif untuk material plastik/polimer: uji tarik (ISO 527) + uji lentur (ISO 178) + uji impak Izod (ISO 180) + Shore D. Laporan lengkap termasuk.',
                'base_price'      => 850000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op1?->id,
                'name'            => 'Paket Uji Mekanik Lengkap – Logam',
                'description'     => 'Paket bundling pengujian mekanik komprehensif untuk logam: uji tarik (ISO 6892) + uji kekerasan Rockwell + uji impak Charpy. Cocok untuk sertifikasi bahan baku.',
                'base_price'      => 750000,
                'is_active'       => true,
            ],
            [
                'machine_id'      => $machines['MCH-001']->id,
                'pic_operator_id' => $op3?->id,
                'name'            => 'Paket Uji Mekanik Lengkap – Karet',
                'description'     => 'Paket bundling untuk karet dan elastomer: uji tarik (ISO 37) + Shore A + uji tekan. Dilengkapi laporan teknis dan sertifikat hasil uji.',
                'base_price'      => 600000,
                'is_active'       => true,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }
    }
}