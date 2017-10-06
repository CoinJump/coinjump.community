<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Coin;
use App\Currency;
use App\Type;
use App\Pricevalue;
use App\Pricejump;

class detectPriceJumps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin:detect-price-jumps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analize the prices in our database, detect major jumps.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        # Get all coins
        $coins = Coin::all();
        $timestamp = new Carbon('3 hours ago');

        foreach ($coins as $coin) {
            # For each coin, just check USD
            $currency = Currency::find(1)->where('name', 'USD')->first();

            # A "jump" is defined as a 5% price change within the time range of an hour.
            $latestPrices = $coin->value()
                                ->where('currency_id', $currency->id)
                                ->where('created_at', '>=', $timestamp)
                                ->orderBy('price', 'ASC')
                                ->get();

            $lowestPrice = $latestPrices->first();
            $highestPrice = $latestPrices->last();

            if (is_a($lowestPrice, 'App\Pricevalue') && is_a($highestPrice, 'App\Pricevalue')) {

                # What's the 5% margin we need to clear?
                if ($highestPrice->price > 0) {
                    $diff = priceJumpPercentage($lowestPrice->price, $highestPrice->price);

                    if ($diff) {
                        # Did the price go up or down?
                        if ($lowestPrice->created_at > $highestPrice->created_at) {
                            # Price went down
                            $price_from = $highestPrice->price;
                            $price_to = $lowestPrice->price;
                        } else {
                            # Price went up
                            $price_from = $lowestPrice->price;
                            $price_to = $highestPrice->price;
                        }

                        if ($diff > 110 || $diff < 90) {
                            # New peak! Did we already save this one? We only want one an hour!
                            $pricejumps = Pricejump::where('created_at', '>=', $timestamp)->first();

                            if ($pricejumps == null) {
                                $pricejump = new Pricejump();
                                $pricejump->currency_id = $currency->id;
                                $pricejump->coin_id = $coin->id;
                                $pricejump->price_from = $price_from;
                                $pricejump->price_to = $price_to;
                                $pricejump->save();

                                $pricejump = $pricejump->fresh();

                                $tweet = $coin->long_name .' ($'. $coin->name .'): '. $pricejump->getPercentage() .'% '. $pricejump->getPriceDirection() .' (from '. $pricejump->getPriceFromReadable() .' to '. $pricejump->getPriceToReadable() .') http://coinjump.community/event/'. $pricejump->id;

                                # Post this jump on Twitter
                                /* \Twitter::postTweet(
                                    array(
                                        'status' => $tweet,
                                        'format' => 'json'
                                    )
                                ); */
                            }
                        }
                    }
                }
            }
        }
    }
}
