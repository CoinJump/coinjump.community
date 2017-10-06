<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CoinSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(PricejumpSeeder::class);
    }
}
