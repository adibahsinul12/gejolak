<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'untuk_produsen' => 'boolean',
        'untuk_konsumen' => 'boolean',
        'dipantau'       => 'boolean',
        'aktif'          => 'boolean',
    ];

    public function aliases()
    {
        return $this->hasMany(CommodityAlias::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Komoditas yang boleh tampil di mode produsen/konsumen
    public function scopeUntukJenis($query, string $jenis)
    {
        return $query->where($jenis === 'produsen' ? 'untuk_produsen' : 'untuk_konsumen', true);
    }
}