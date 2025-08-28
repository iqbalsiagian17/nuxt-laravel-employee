<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkUnit;
use Faker\Factory as Faker;

class WorkUnitSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Menambahkan data dummy untuk WorkUnit
        for ($i = 0; $i < 10; $i++) {
            WorkUnit::create([
                'unit_name' => $faker->word,
            ]);
        }
    }
}
