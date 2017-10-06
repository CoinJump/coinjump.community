<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Coin;
use App\Currency;
use App\Type;
use App\Pricevalue;
use App\Pricejump;

class HomepageController extends Controller
{
    /**
     * Show the application splash screen.
     *
     * @return Response
     */
    public function show()
    {
        $btc = Coin::where('name', 'BTC')->first();
        $usd = Currency::where('name', 'USD')->first();
        $timestamp = new Carbon('24 hours ago');

        // Get all prices from 24hr ago
        $values = Pricevalue::where('coin_id', $btc->id)
                            ->where('created_at', '>=', $timestamp)
                            ->where('currency_id', $usd->id)
                            ->get();

        $coinCount = Coin::all()->count();

        // Calculate min & max axis
        $minPrice = 0;
        $maxPrice = 0;

        foreach ($values as $value) {
            if ($minPrice == 0) {
                $minPrice = $value->price;
            }
            if ($maxPrice == 0) {
                $maxPrice = $value->price;
            }

            if ($value->price < $minPrice) {
                $minPrice = $value->price;
            }

            if ($value->price > $maxPrice) {
                $maxPrice = $value->price;
            }
        }

        // Get the latest 5 price jumps to show on the homepage
        $recentPricejumps = Pricejump::orderBy('created_at', 'DESC')->limit(5)->get();

        return view('homepage', [
            'pricevalues' => $values,
            'minPrice' => round($minPrice, 6),
            'maxPrice' => round($maxPrice, 6),
            'recentPriceJumps' => $recentPricejumps,
            'coinCount' => $coinCount,
        ]);
    }

    public function showEvent (Pricejump $pricejump) {
        // Get all prices from 3hrs before and 3hrs after the event
        $timestampBefore = $pricejump->created_at->copy()->subHours(3);
        $timestampAfter = $pricejump->created_at->copy()->addHours(3);

        $values = Pricevalue::where('coin_id', $pricejump->coin_id)
                            ->where('created_at', '>=', $timestampBefore)
                            ->where('created_at', '<=', $timestampAfter)
                            ->where('currency_id', $pricejump->currency_id)
                            ->get();

        // Calculate min & max axis
        $minPrice = 0;
        $maxPrice = 0;

        foreach ($values as $value) {
            if ($minPrice == 0) {
                $minPrice = $value->price;
            }
            if ($maxPrice == 0) {
                $maxPrice = $value->price;
            }

            if ($value->price < $minPrice) {
                $minPrice = $value->price;
            }

            if ($value->price > $maxPrice) {
                $maxPrice = $value->price;
            }
        }

        return view('event.show', [
            'pricevalues' => $values,
            'minPrice' => round($minPrice, 6),
            'maxPrice' => round($maxPrice, 6),
            'pricejump' => $pricejump,
        ]);
    }
}
