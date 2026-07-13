<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('uniqid')->unique();
            $table->float('amount', 15, 2);
            $table->unsignedBigInteger('currency_id');
            $table->integer('duration');
            $table->text('goal');

            $table->float('teag')->nullable();
            $table->float('monthly_payment')->nullable();
            $table->float('total_interest')->nullable();
            $table->float('total_mpayment')->nullable();
            $table->string('start_at')->nullable();
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
        Schema::dropIfExists('loan_requests');
    }
}
