<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricevaluesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricevalues', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->float('price', 20, 8);   // 20 digits total, 8 behind decimal point
            $table->integer('currency_id');
            $table->integer('coin_id');
        });
    }

}
