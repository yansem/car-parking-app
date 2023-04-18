<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Zone::create(['name' => 'Green Zone', 'rate' => 1]);
        Zone::create(['name' => 'Yellow Zone', 'rate' => 2]);
        Zone::create(['name' => 'Red Zone', 'rate' => 3]);
    }
}
