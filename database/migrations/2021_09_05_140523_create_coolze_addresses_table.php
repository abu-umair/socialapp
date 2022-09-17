<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoolzeAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coolze_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('coolze_customers_id')->nullable();
            $table->integer('coolze_partners_id')->nullable();
            $table->longText('address');
            $table->string('long');
            $table->string('lat');
            $table->integer('alamat_utama')->default('1');
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
        Schema::dropIfExists('coolze_addresses');
    }
}
