<?php

namespace Database\Seeders;

use Database\Seeders\OperatorSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MachineSeeder::class,
            OperatorSeeder::class,
            CategorySeeder::class,
            PackageSeeder::class,
            OrderSeeder::class,
            
        ]);
    }
}