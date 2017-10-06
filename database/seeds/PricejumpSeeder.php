<?php

use Illuminate\Database\Seeder;
use App\Pricejump;

class PricejumpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Delete all */
        DB::table('pricejumps')->delete();

        /* Dummy data */
        Pricejump::create(['coin_id' => '1', 'currency_id' => '1', 'price_from' => '4120', 'price_to' => '4325']);
    }
}
