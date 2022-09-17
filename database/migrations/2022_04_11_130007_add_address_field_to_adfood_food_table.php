<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressFieldToAdfoodFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adfood_merchants', function (Blueprint $table) {
            $table->longText('address')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adfood_merchants', function (Blueprint $table) {
            //
        });
    }
}
