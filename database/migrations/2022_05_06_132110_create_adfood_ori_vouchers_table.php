<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdfoodOriVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adfood_ori_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('foto');
            $table->string('coupon_code');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('min_purchase');
            $table->integer('discount')->nullable();
            $table->string('vendor')->nullable();
            $table->boolean('status')->default('1');
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
        Schema::dropIfExists('adfood_ori_vouchers');
    }
}
