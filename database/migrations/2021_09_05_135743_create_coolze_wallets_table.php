<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoolzeWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coolze_wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('coolze_customers_id');
            $table->integer('history_topup');
            $table->integer('history_out');
            $table->integer('total');
            $table->integer('coolpoin');
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
        Schema::dropIfExists('coolze_wallets');
    }
}
