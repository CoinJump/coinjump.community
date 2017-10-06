<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Delete all */
        DB::table('currencies')->delete();

        /* Dummy data */
        Currency::create(['name' => 'USD', 'symbol' => '$']);
        Currency::create(['name' => 'EUR', 'symbol' => '€']);
    }
}
