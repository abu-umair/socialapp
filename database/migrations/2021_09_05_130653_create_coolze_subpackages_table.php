<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoolzeSubpackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coolze_subpackages', function (Blueprint $table) {
            $table->id();
            $table->integer('coolze_packages_id');
            $table->string('deskripsi_title');
            $table->integer('price_dasar');
            $table->integer('price_diskon')->nullable();
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
        Schema::dropIfExists('coolze_subpackages');
    }
}
