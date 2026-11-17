<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $guarded = [];

    protected $casts = ['aktif' => 'boolean'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}