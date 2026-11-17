<?php

namespace Database\Seeders;

use App\Models\Commodity;
use App\Models\CommodityAlias;
use Illuminate\Database\Seeder;

class CommoditySeeder extends Seeder
{
    public function run(): void
    {
        // [nama, kelompok]. Cocokkan penulisan nama dengan header kolom file Excel Anda.
        $konsumen = [
            ['Beras Premium', 'Beras'], ['Beras Medium', 'Beras'],
            ['Beras Medium Non SPHP', 'Beras'], ['Beras Khusus (Lokal)', 'Beras'],
            ['Beras SPHP', 'Beras'],
            ['Jagung Tk Peternak', 'Serealia'],
            ['Kedelai Biji Kering (Impor)', 'Kacang-kacangan'],
            ['Bawang Merah', 'Bawang dan Cabai'], ['Bawang Putih Bonggol', 'Bawang dan Cabai'],
            ['Cabai Merah Keriting', 'Bawang dan Cabai'], ['Cabai Merah Besar', 'Bawang dan Cabai'],
            ['Cabai Rawit Merah', 'Bawang dan Cabai'],
            ['Daging Sapi Murni', 'Daging dan Telur'], ['Daging Ayam Ras', 'Daging dan Telur'],
            ['Daging Kerbau Beku (Impor)', 'Daging dan Telur'], ['Daging Kerbau Segar (Lokal)', 'Daging dan Telur'],
            ['Gula Konsumsi', 'Gula dan Minyak'], ['Minyak Goreng Kemasan', 'Gula dan Minyak'],
            ['Minyak Goreng Curah', 'Gula dan Minyak'], ['Minyakita', 'Gula dan Minyak'],
            ['Tepung Terigu (Curah)', 'Tepung'], ['Tepung Terigu Kemasan', 'Tepung'],
            ['Ikan Kembung', 'Ikan'], ['Ikan Tongkol', 'Ikan'], ['Ikan Bandeng', 'Ikan'],
            ['Garam Konsumsi', 'Lainnya'],
        ];

        // Komoditas yang ikut deteksi gejolak (yang paling bergerak)
        $dipantau = [
            'Cabai Merah Keriting', 'Cabai Merah Besar', 'Cabai Rawit Merah',
            'Bawang Merah', 'Daging Ayam Ras', 'Telur Ayam Ras', 'Ayam Ras Pedaging (Hidup)',
        ];

        foreach ($konsumen as [$nama, $kelompok]) {
            Commodity::updateOrCreate(['nama' => $nama], [
                'kelompok'       => $kelompok,
                'satuan'         => str_contains($nama, 'Minyak') ? 'liter' : 'kg',
                'untuk_konsumen' => true,
                'untuk_produsen' => false,
                'dipantau'       => in_array($nama, $dipantau),
            ]);
        }

        // Telur: ada di kedua mode
        Commodity::updateOrCreate(['nama' => 'Telur Ayam Ras'], [
            'kelompok' => 'Daging dan Telur', 'satuan' => 'kg',
            'untuk_konsumen' => true, 'untuk_produsen' => true, 'dipantau' => true,
        ]);

        // Ayam hidup: hanya produsen. Beda dengan Daging Ayam Ras (konsumen).
        Commodity::updateOrCreate(['nama' => 'Ayam Ras Pedaging (Hidup)'], [
            'kelompok' => 'Daging dan Telur', 'satuan' => 'kg',
            'untuk_konsumen' => false, 'untuk_produsen' => true, 'dipantau' => true,
        ]);

        // Alias: nama kolom Excel yang berbeda antar bulan
        $garam = Commodity::where('nama', 'Garam Konsumsi')->value('id');
        CommodityAlias::updateOrCreate(['alias' => 'Garam Halus Beryodium'], ['commodity_id' => $garam]);
    }
}