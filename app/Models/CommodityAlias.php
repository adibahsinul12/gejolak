<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommodityAlias extends Model
{
    protected $guarded = [];

    public function commodity()
    {
        return $this->belongsTo(Commodity::class);
    }
}