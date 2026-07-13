<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_histories', function (Blueprint $table) {
            $table->id();
            $table->string('uniqid')->unique();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('external_id');
            $table->string('sender');
            $table->string('msisdn');
            $table->integer('cost')->nullable();
            $table->enum('status', [0, 1, 2])->default(2);
            $table->text('message');
            $table->float('sms_balance')->default(0);
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
        Schema::dropIfExists('sms_histories');
    }
}
