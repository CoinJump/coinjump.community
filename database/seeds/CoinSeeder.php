<?php

use Illuminate\Database\Seeder;
use App\Coin;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Delete all */
        DB::table('coins')->delete();

        /* Dummy data */
        Coin::create(['name' => 'BTC', 'long_name' => 'Bitcoin']);
        Coin::create(['name' => 'ETH', 'long_name' => 'Ethereum']);
        Coin::create(['name' => 'LTC', 'long_name' => 'Litecoin']);
    }
}
