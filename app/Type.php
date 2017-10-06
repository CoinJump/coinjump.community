<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function coin()
    {
        return $this->hasMany('App\Coin');
    }
}
