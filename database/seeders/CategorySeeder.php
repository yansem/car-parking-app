<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['title' => 'A', 'price_per_hour' => 38]);
        Category::create(['title' => 'B', 'price_per_hour' => 100]);
        Category::create(['title' => 'C', 'price_per_hour' => 190]);
    }
}
