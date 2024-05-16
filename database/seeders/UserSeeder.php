<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Accountant',
            'type' => "ACCOUNTANT",
            'email' => 'programmerhasan.s@gmail.com',
            'phone' => '01975568604',
            'password' => Hash::make('password'),
        ]);
    }
}
