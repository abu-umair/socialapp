<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdfoodMerchantsIdFieldToAdfoodFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adfood_food', function (Blueprint $table) {
            $table->integer('adfood_merchants_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adfood_food', function (Blueprint $table) {
            //
        });
    }
}
