<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoolzeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coolze_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('coolze_customers_id');
            $table->integer('coolze_partners_id');
            $table->integer('coolze_drivers_id');
            $table->integer('coolze_vouchers_id');
            $table->integer('coolze_packages_id');
            $table->string('merk');
            $table->integer('qty');
            $table->date('date');
            $table->time('time');
            $table->string('status');
            $table->string('acc');
            $table->integer('rate')->nullable();
            $table->string('ulasan_rate')->nullable();
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
        Schema::dropIfExists('coolze_orders');
    }
}
