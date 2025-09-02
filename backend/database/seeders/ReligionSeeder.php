<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religion;

class ReligionSeeder extends Seeder
{
    public function run(): void
    {
        $religions = [
            'Islam',
            'Kristen',
            'Katolik',
            'Hindu',
            'Buddha',
        ];

        foreach ($religions as $religion) {
            Religion::firstOrCreate([
                'name' => $religion
            ]);
        }
    }
}
