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

        # Detect 2 kinds of jumps:
        # - 24h price increases
        # - 7d price increases
        $timestampShort = 24; // 24h
        $timestampLong  = 168; // 168h = 7d

        $hoursAgo = [ $timestampShort, $timestampLong ];

        foreach ($coins as $coin) {
            # For each coin, just check USD
            $currency = Currency::find(1)->where('name', 'USD')->first();

            foreach ($hoursAgo as $hourAgo) {
                $timerange = new Carbon($hoursAgo .' hours ago');

                # A "jump" is defined as a 10% price change within a specific timeframe.
                $latestPrices = $coin->value()
                                    ->where('currency_id', $currency->id)
                                    ->where('created_at', '>=', $timerange)
                                    ->orderBy('created_at', 'ASC')
                                    ->get();

                $firstPrice = $latestPrices->first();
                $lastPrice = $latestPrices->last();

                if (is_a($firstPrice, 'App\Pricevalue') && is_a($lastPrice, 'App\Pricevalue')) {
                    # We can't divide by 0, check that
                    if ($lastPrice->price > 0) {
                        # How big was this jump?
                        $percentageJump = priceJumpPercentage($firstPrice->price, $lastPrice->price);

                        if ($percentageJump) {
                            # Did the price go up or down?
                            if ($percentageJump > 10 || $percentageJump < -10) {
                                # New jump! Did we already save this one? We only want one per timeframe!
                                $pricejumps = Pricejump::where('created_at', '>=', $timerange)->first();

                                if ($pricejumps == null) {
                                    $pricejump = new Pricejump();
                                    $pricejump->currency_id = $currency->id;
                                    $pricejump->coin_id = $coin->id;
                                    $pricejump->price_from = $firstPrice->price;
                                    $pricejump->price_to = $lastPrice->price;
                                    $pricejump->timeframe = $hourAgo;
                                    $pricejump->save();

                                    $pricejump = $pricejump->fresh();

                                    $tweet = $coin->long_name .' ($'. $coin->name .'): '. $pricejump->getPercentage() .'% '. $pricejump->getPriceDirection() .' (from '. $pricejump->getPriceFromReadable() .' to '. $pricejump->getPriceToReadable() .') '. $pricejump->getPermalink();

                                    # Post this jump on Twitter
                                    \Twitter::postTweet(
                                        array(
                                            'status' => $tweet,
                                            'format' => 'json'
                                        )
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
