<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tanggal' => 'date',
        'harga'   => 'float',
    ];

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function import()
    {
        return $this->belongsTo(Import::class);
    }
}