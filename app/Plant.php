<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $fillable = [
        'plant_code', 'plant_name', 'status'
    ];

    public function plant()
    {
        return $this->hasMany(Bill::class, 'plant_id');
    }
}
