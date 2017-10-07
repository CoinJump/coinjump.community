<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Coin;
use App\Currency;
use App\Type;
use App\Pricevalue;

class getCurrentPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin:get-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the latest pricing from Coinbin.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get pricing data
        $apiEndpoint = 'https://api.coinmarketcap.com/v1/ticker/';
        $json = fetchJson($apiEndpoint);

        // For now, only deal with USD
        $usd = Currency::where('name', 'USD')->first();

        // Loop all coins from CoinMarketCap
        foreach ($json as $coin) {
            $symbol = strtoupper($coin['symbol']);
            $name = $coin['name'];

            // Does it already exist?
            $existingCoin = Coin::where('name', $symbol)->first();
            if (!is_a($existingCoin, 'App\Coin')) {
                $newCoin = new Coin();
                $newCoin->name = $symbol;
                $newCoin->long_name = $name;
                $newCoin->save();

                $existingCoin = $newCoin->refresh();
            }

            // Save the latest price
            $value = new Pricevalue();
            $value->price = $coin['price_usd'];
            $value->currency_id = $usd->id;
            $value->coin_id = $existingCoin->id;
            $value->save();
        }
    }
}
