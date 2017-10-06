<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricevalue extends Model
{
    public function currencies()
    {
        return $this->belongsTo('App\Currency');
    }

    public function coin()
    {
        return $this->belongsTo('App\Coin');
    }

    public function getTime()
    {
        return $this->created_at->format('H:i');
    }
}
