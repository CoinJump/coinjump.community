<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Coin;
use App\Currency;
use App\Type;
use App\Pricevalue;

class updateAvailableCoins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin:get-new-coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If new coins are detected, add them to our database.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apiEndpoint = 'https://coinbin.org/coins';
        $json = fetchJson($apiEndpoint);

        foreach ($json['coins'] as $coin => $data) {
            $ticker = strtoupper($data['ticker']);
            $name = $data['name'];

            // Does it already exist?
            $existingCoin = Coin::where('name', $ticker)->first();
            if (!is_a($existingCoin, 'App\Coin')) {
                $newCoin = new Coin();
                $newCoin->name = $ticker;
                $newCoin->long_name = $name;
                $newCoin->save();
            }
        }
    }
}
