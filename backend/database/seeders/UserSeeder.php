<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Membuat user dengan data dummy
        User::create(attributes: [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Pastikan menggunakan hash untuk password
        ]);
    }
}
