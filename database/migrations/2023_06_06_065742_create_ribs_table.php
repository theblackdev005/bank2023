<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRibsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('currency_id');
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('rib_key')->nullable();
            $table->string('iban')->nullable();
            $table->string('swift_bic')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamp('enabled_at')->nullable();

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
        Schema::dropIfExists('ribs');
    }
}
