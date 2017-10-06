<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricejumpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricejumps', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('coin_id');
            $table->integer('currency_id');
            $table->float('price_from', 20, 8);   // 20 digits total, 8 behind decimal point
            $table->float('price_to', 20, 8);     // 20 digits total, 8 behind decimal point
            $table->boolean('explained')->default(false);
        });
    }
}
