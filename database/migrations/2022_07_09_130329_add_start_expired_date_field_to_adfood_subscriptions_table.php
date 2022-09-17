<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartExpiredDateFieldToAdfoodSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adfood_subscriptions', function (Blueprint $table) {
            $table->date('start_date')->nullable();
            $table->date('expired_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adfood_subscriptions', function (Blueprint $table) {
            //
        });
    }
}
