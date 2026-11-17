<?php

return [
    'required'  => ':attribute wajib diisi.',
    'unique'    => ':attribute sudah dipakai.',
    'in'        => ':attribute tidak valid.',
    'email'     => ':attribute harus berupa email yang valid.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'max'       => ['string' => ':attribute maksimal :max karakter.'],
    'min'       => ['string' => ':attribute minimal :min karakter.'],

    'attributes' => [
        'nama'          => 'Nama',
        'jenis'         => 'Jenis',
        'lokasi'        => 'Lokasi',
        'satuan'        => 'Satuan',
        'kelompok'      => 'Kelompok',
        'aliases'       => 'Alias',
        'teks'          => 'Teks',
        'name'          => 'Nama',
        'email'         => 'Email',
        'password'      => 'Password',
        'role'          => 'Peran',
        'jenis_default' => 'Jenis bawaan',
        'market_id'     => 'Pasar',
    ],
];