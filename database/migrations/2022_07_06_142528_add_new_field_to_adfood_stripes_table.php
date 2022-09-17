<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToAdfoodStripesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adfood_stripes', function (Blueprint $table) {
            $table->text('created')->nullable();
            $table->text('id_card')->nullable();
            $table->text('livemode')->nullable();
            $table->text('type')->nullable();
            $table->text('addressLine1')->nullable();
            $table->text('addressLine2')->nullable();
            $table->text('brand')->nullable();
            $table->integer('expMonth')->nullable();
            $table->integer('expYear')->nullable();
            $table->text('funding')->nullable();
            $table->text('last4')->nullable();
            $table->text('number')->nullable();
            $table->string('token')->nullable();
            $table->text('id_paymentmethod')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adfood_stripes', function (Blueprint $table) {
            //
        });
    }
}
