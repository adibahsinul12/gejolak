<?php

namespace Database\Seeders;

use App\Models\Market;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $produsen  = Market::where('nama', 'Produsen')->value('id');
        $konsumen1 = Market::where('nama', 'Pasar Konsumen 1')->value('id');
        $konsumen2 = Market::where('nama', 'Pasar Konsumen 2')->value('id');

        // Password otomatis di-hash oleh cast 'hashed' di model User.
        $akun = [
            ['name' => 'Admin',                 'email' => 'admin@harpa.test',     'role' => 'admin'],
            ['name' => 'Pimpinan',              'email' => 'pimpinan@harpa.test',  'role' => 'pimpinan'],
            ['name' => 'Enumerator Produsen',   'email' => 'produsen@harpa.test',  'role' => 'enumerator', 'jenis_default' => 'produsen', 'market_id' => $produsen],
            ['name' => 'Enumerator Konsumen 1', 'email' => 'konsumen1@harpa.test', 'role' => 'enumerator', 'jenis_default' => 'konsumen', 'market_id' => $konsumen1],
            ['name' => 'Enumerator Konsumen 2', 'email' => 'konsumen2@harpa.test', 'role' => 'enumerator', 'jenis_default' => 'konsumen', 'market_id' => $konsumen2],
        ];

        foreach ($akun as $a) {
            User::updateOrCreate(['email' => $a['email']], $a + ['password' => 'password', 'aktif' => true]);
        }
    }
}