<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pricevalues', function (Blueprint $table) {
            $table->index(['coin_id', 'currency_id', 'created_at']); /* Compound index for price jump calculations */
            $table->index(['coin_id', 'currency_id']); /* Compound index for graph generations */
        });
    }
}
