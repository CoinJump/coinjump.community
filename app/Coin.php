<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    public function value()
    {
        return $this->hasMany('App\Pricevalue');
    }
}
