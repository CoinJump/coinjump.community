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
        # Get all coins
        $coins = Coin::all();

        # For now, only deal with USD
        $usd = Currency::where('name', 'USD')->first();

        foreach ($coins as $coin) {
            $coinLowerCased = strtolower($coin->name);
            $apiEndpoint = "https://coinbin.org/". $coinLowerCased;

            # Fetch the current price from API
            $json = fetchJson($apiEndpoint);
            $data = $json['coin'];

            # Store price in DB
            $value = new Pricevalue();
            $value->price = $data['usd'];
            $value->currency_id = $usd->id;
            $value->coin_id = $coin->id;
            $value->save();
        }
    }
}
