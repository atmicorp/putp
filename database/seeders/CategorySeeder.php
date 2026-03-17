<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'category_id'   => 'CAT-001',
                'nama_category' => 'Plastic Testing',
            ],
            [
                'category_id'   => 'CAT-002',
                'nama_category' => 'Product Development',
            ],
            [
                'category_id'   => 'CAT-003',
                'nama_category' => 'Plastic Processing',
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}