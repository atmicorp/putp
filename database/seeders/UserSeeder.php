<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Utama',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
            'role'     => User::ROLE_ADMIN,
        ]);

        // Staff
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@example.com',
            'password' => Hash::make('password'),
            'role'     => User::ROLE_STAFF,
        ]);

        // Operator users
        $operators = [
            ['name' => 'Andi Prasetyo',  'email' => 'andi@example.com'],
            ['name' => 'Siti Rahayu',    'email' => 'siti@example.com'],
            ['name' => 'Doni Kurniawan', 'email' => 'doni@example.com'],
        ];

        foreach ($operators as $op) {
            User::create([
                'name'     => $op['name'],
                'email'    => $op['email'],
                'password' => Hash::make('password'),
                'role'     => User::ROLE_OPERATOR,
            ]);
        }
    }
}