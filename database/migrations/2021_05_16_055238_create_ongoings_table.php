    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOngoingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ongoings', function (Blueprint $table) {
            $table->id();
            $table->integer('customers_id'); //relasi
            $table->integer('doctors_id')->nullable(); //relasi
            $table->integer('groomers_id')->nullable(); //relasi table user
            $table->date('date');
            $table->time('time');
            $table->integer('metode_layanan');
            $table->integer('status'); //in_cart, pending, success, cancel, failed
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
        Schema::dropIfExists('ongoings');
    }
}
