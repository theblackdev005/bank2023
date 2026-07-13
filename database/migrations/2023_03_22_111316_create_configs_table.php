<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('value')->nullable();
            $table->text('comment');
            $table->boolean('readonly');
            $table->string('auto_set')->nullable();
            $table->enum('input_type', ['boolean', 'text', 'textarea', 'email', 'tel', 'number']);

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
        Schema::dropIfExists('configs');
    }
}
