<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use Faker\Factory as Faker;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Menambahkan data dummy untuk Position
        for ($i = 0; $i < 10; $i++) {
            Position::create([
                'position_name' => $faker->word,
            ]);
        }
    }
}
