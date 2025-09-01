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

        // Tambah beberapa unit random lain tanpa parent
        for ($k = 1; $k <= 4; $k++) {
            WorkUnit::create([
                'unit_name' => $faker->company,
            ]);
        }
    }
}
