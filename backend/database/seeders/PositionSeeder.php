<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'Kepala Sekretariat Utama',
            'Penyusun laporan keuangan',
            'Surveyor Pemetaan Pertama',
            'Analis Data Survei dan Pemetaan',
            'Perancang Per-UUan Utama',
            'Kepala Biro Perencanaan, Kepegawaian dan',
            'Widyaiswara Utama',
            'Analis Kepegawaian Madya',
            'Kepala Sub Bidang Kerjasama dan Pelayanan Riset, DKP',
            'Analis Hukum',
            'Peneliti Pertama',
            'Surveyor Pemetaan Muda',
            'Analis Jabatan',
            'Kepala Subbag Kepegawaian',
        ];

        foreach ($positions as $position) {
            Position::firstOrCreate([
                'position_name' => $position
            ]);
        }
    }
}
