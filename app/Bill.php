<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }
}
