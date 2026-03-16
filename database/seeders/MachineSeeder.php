<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    public function run(): void
    {
        $machines = [
            [
                'name'        => 'Universal Testing Machine (UTM)',
                'code'        => 'MCH-001',
                'description' => 'Alat uji tarik, tekan, dan lentur universal kapasitas 100 kN. Digunakan untuk menguji tensile strength, elongation at break, dan modulus elastisitas berbagai material.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Rockwell Hardness Tester',
                'code'        => 'MCH-002',
                'description' => 'Alat uji kekerasan metode Rockwell (HRA, HRB, HRC) untuk logam, polimer keras, dan komposit. Rentang pengukuran HR 20–100.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Charpy / Izod Impact Tester',
                'code'        => 'MCH-003',
                'description' => 'Alat uji impak metode Charpy dan Izod untuk mengukur ketangguhan material terhadap beban kejut. Kapasitas pendulum 300 J.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Shore Durometer',
                'code'        => 'MCH-004',
                'description' => 'Alat uji kekerasan Shore A dan Shore D untuk material karet, elastomer, dan plastik lunak sesuai standar ASTM D2240.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Brinell Hardness Tester',
                'code'        => 'MCH-005',
                'description' => 'Alat uji kekerasan metode Brinell (HBW) untuk logam dan alloy dengan permukaan kasar atau material heterogen. Beban uji 187.5–3000 kgf.',
                'is_active'   => true,
            ],
            [
                'name'        => 'Vickers Microhardness Tester',
                'code'        => 'MCH-006',
                'description' => 'Alat uji kekerasan mikro metode Vickers (HV) untuk lapisan tipis, coating, weld zone, dan material komposit. Beban 10–1000 gf.',
                'is_active'   => false,
            ],
        ];

        foreach ($machines as $machine) {
            Machine::create($machine);
        }
    }
}