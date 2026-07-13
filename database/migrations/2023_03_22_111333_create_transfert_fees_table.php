<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfert_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('transfert_id');
            $table->unsignedBigInteger('transfert_currency_id');
            $table->string('name');
            $table->float('cost', 15, 2);
            $table->string('code');
            $table->text('instructions');
            $table->integer('percentage');
            $table->integer('load_delay');
            $table->timestamp('load_at')->nullable();
            $table->timestamp('payed_at')->nullable();
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
        Schema::dropIfExists('transfert_fees');
    }
}
