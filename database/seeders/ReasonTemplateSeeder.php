<?php

namespace Database\Seeders;

use App\Models\ReasonTemplate;
use Illuminate\Database\Seeder;

class ReasonTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $teks = [
            'Menjelang hari raya',
            'Cuaca buruk atau gagal panen',
            'Pasokan terganggu',
            'Distribusi terhambat',
            'Kenaikan biaya produksi atau pakan',
            'Permintaan meningkat',
            'Harga kembali normal',
            'Lainnya',
        ];

        foreach ($teks as $t) {
            ReasonTemplate::updateOrCreate(['teks' => $t]);
        }
    }
}