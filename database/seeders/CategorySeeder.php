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
        Category::create(['title' => 'A', 'price' => 38]);
        Category::create(['title' => 'B', 'price' => 100]);
        Category::create(['title' => 'C', 'price' => 190]);
        Category::create(['title' => 'M', 'price' => 38]);
    }
}
