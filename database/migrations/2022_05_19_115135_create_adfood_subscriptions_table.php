<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdfoodSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adfood_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->integer('price');
            $table->integer('price_discount')->nullable();
            $table->string('profit_a')->nullable();
            $table->string('profit_b')->nullable();
            $table->string('profit_c')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('adfood_subscriptions');
    }
}
