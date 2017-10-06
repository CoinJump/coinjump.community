<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExplanationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('explanations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('pricejump_id');
            $table->string('url');
            $table->string('title');
            $table->string('img');
            $table->string('description');
            $table->integer('confirmed')->default(0);
        });
    }
}
