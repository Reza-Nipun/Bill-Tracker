<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
