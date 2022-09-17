<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdfoodMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adfood_merchants', function (Blueprint $table) {
            $table->id();
            $table->string('website');
            $table->time('open-restaurant');
            $table->time('close-restaurant');
            $table->longText('about');
            $table->text('menus-restaurant'); //foto
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adfood_merchants');
    }
}
