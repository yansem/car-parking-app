<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            'user_id' => 1,
            'category_id' => 2,
            'plate_number' => 'A777AA73'
        ]);

        Vehicle::create([
            'user_id' => 2,
            'category_id' => 2,
            'plate_number' => 'B777BB74'
        ]);
    }
}
