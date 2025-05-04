<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::insert([
            ['name' => 'Leptop', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aksesoris', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
    