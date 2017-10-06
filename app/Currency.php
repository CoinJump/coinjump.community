<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function currency()
    {
        return $this->belongsTo('App\Pricevalue');
    }
}
