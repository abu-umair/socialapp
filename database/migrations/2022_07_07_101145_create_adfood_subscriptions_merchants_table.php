<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdfoodSubscriptionsMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adfood_subscriptions_merchants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('merchants_id');
            $table->bigInteger('subscriptions_id');
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
        Schema::dropIfExists('adfood_subscriptions_merchants');
    }
}
