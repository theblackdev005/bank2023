<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfert_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('currency_id');

            $table->string('recipient_name');
            $table->string('recipient_iban')->nullable();
            $table->string('recipient_address');

            // $table->string('bank_location')->nullable();
            $table->string('bank_swift')->nullable();
            $table->string('bank_name');
            $table->string('bank_address');
            $table->unsignedBigInteger('bank_country_id');

            $table->string('account_number')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('transit_number')->nullable();
            $table->string('institution_number')->nullable();
            $table->string('bsb_code')->nullable();
            $table->string('short_code')->nullable();
            
            $table->timestamp('approved_at')->nullable();
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
        Schema::dropIfExists('transfert_recipients');
    }
}
