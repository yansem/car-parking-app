<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Smith',
            'email' => 'john@smith.com',
            'password' => Hash::make('some_password')
        ]);

        User::create([
            'name' => 'John Smith2',
            'email' => 'john@smith2.com',
            'password' => Hash::make('some_password')
        ]);
    }
}
