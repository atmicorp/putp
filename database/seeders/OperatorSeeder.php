<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        $operatorUsers = User::where('role', 'operator')->get();
        $machines      = Machine::all();

        $data = [
            [
                // Hendra → UTM & Charpy (uji mekanik utama)
                'employee_code' => 'OPR-001',
                'phone'         => '081311110001',
                'is_active'     => true,
                'machines'      => ['MCH-001', 'MCH-003'],
            ],
            [
                // Dewi → Rockwell, Brinell, Vickers (uji kekerasan)
                'employee_code' => 'OPR-002',
                'phone'         => '081311110002',
                'is_active'     => true,
                'machines'      => ['MCH-002', 'MCH-005', 'MCH-006'],
            ],
            [
                // Fajar → Shore Durometer & UTM (karet & plastik)
                'employee_code' => 'OPR-003',
                'phone'         => '081311110003',
                'is_active'     => true,
                'machines'      => ['MCH-004', 'MCH-001'],
            ],
        ];

        foreach ($operatorUsers as $i => $user) {
            if (!isset($data[$i])) break;

            $operator = Operator::create([
                'user_id'       => $user->id,
                'employee_code' => $data[$i]['employee_code'],
                'phone'         => $data[$i]['phone'],
                'is_active'     => $data[$i]['is_active'],
            ]);

            $machineIds = $machines->whereIn('code', $data[$i]['machines'])->pluck('id');
            $operator->machines()->attach($machineIds);
        }
    }
}