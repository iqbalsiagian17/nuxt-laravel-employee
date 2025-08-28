<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religion;
use Faker\Factory as Faker;

class ReligionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Menambahkan data dummy untuk Religion
        $religions = ['Islam', 'Christian', 'Hindu', 'Buddhist', 'Catholic'];

        foreach ($religions as $religion) {
            Religion::create([
                'name' => $religion,
            ]);
        }
    }
}
