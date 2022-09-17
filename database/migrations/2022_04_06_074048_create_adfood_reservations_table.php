<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdfoodReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adfood_reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('adfood_merchants_id');
            $table->integer('adfood_users_id');
            $table->integer('jumlah-orang');
            $table->integer('coolze_packages_id');
            $table->date('date');
            $table->time('time');
            $table->string('status');
            $table->string('acc');
            $table->integer('rate')->nullable();
            $table->string('ulasan_rate')->nullable();
            $table->text('pothos-coment');
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
        Schema::dropIfExists('adfood_reservations');
    }
}
