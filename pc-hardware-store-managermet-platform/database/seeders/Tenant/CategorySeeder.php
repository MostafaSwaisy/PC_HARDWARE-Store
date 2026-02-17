<?php

namespace Database\Seeders\Tenant;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = [
            ['name' => 'CPU', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'GPU', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Motherboard', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'RAM', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Storage', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Power Supply', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Case', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cooling', 'created_at' => $now, 'updated_at' => $now],
        ];

        Category::query()->upsert($categories, ['name'], ['updated_at']);
    }
}
