<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $guarded = [];

    protected $casts = [
        'periode_mulai'   => 'date',
        'periode_akhir'   => 'date',
        'jumlah_baris'    => 'integer',
        'jumlah_dilewati' => 'integer',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}