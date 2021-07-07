<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['currency', 'status'];

    public function currency()
    {
        return $this->hasMany(Bill::class, 'currency_id');
    }
}
