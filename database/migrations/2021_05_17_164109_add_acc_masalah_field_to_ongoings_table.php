<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccMasalahFieldToOngoingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ongoings', function (Blueprint $table) {
            $table->longText('masalah_hewan');
            $table->integer('acc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ongoings', function (Blueprint $table) {
            $table->dropColumn('masalah_hewan');
            $table->dropColumn('acc');
            
        });
    }
}
