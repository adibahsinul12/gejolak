<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonTemplate extends Model
{
    protected $guarded = [];

    protected $casts = ['aktif' => 'boolean'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}