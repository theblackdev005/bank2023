<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('password_plain_text')->nullable();
            $table->integer('gender');
            $table->date('birthday')->nullable();
            $table->string('city');
            $table->string('address');
            $table->string('phone_number');
            $table->string('image')->nullable();
            $table->integer('account_type')->nullable();

            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('language_id')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('identity_verified_at')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->timestamp('first_login_at')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->float('balance', 15, 2)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('customers');
    }
}
