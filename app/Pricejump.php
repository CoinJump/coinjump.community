<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pricejump extends Model
{
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function explanation()
    {
        return $this->hasMany('App\Explanation');
    }

    public function coin()
    {
        return $this->belongsTo('App\Coin');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function getPercentage()
    {
        return priceJumpPercentage($this->price_from, $this->price_to);
    }

    public function getPriceToReadable()
    {
        return sprintf('%s%s', $this->currency->symbol, number_format($this->price_to, 6));
    }

    public function getPriceFromReadable()
    {
        return sprintf('%s%s', $this->currency->symbol, number_format($this->price_from, 6));
    }

    public function getPriceDirection()
    {
        if ($this->price_from > $this->price_to) {
            return '⬇️';
        } else {
            return '⬆️';
        }
    }

    public function getPermalink()
    {
        return getenv('APP_URL') .'/event/'. $this->id;
    }

    public function getPermaidentifier()
    {
        /* Used by disqus */
        return 'coinjump-'. $this->id;
    }

}
