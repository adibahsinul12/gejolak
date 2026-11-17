<?php

namespace Database\Seeders;

use App\Models\Market;
use Illuminate\Database\Seeder;

class MarketSeeder extends Seeder
{
    public function run(): void
    {
        // Nama pasar sementara. Ganti setelah nama pasar sebenarnya diketahui.
        $data = [
            ['nama' => 'Produsen',         'jenis' => 'produsen'],
            ['nama' => 'Pasar Konsumen 1', 'jenis' => 'konsumen'],
            ['nama' => 'Pasar Konsumen 2', 'jenis' => 'konsumen'],
        ];

        foreach ($data as $d) {
            Market::updateOrCreate(['nama' => $d['nama']], $d);
        }
    }
}