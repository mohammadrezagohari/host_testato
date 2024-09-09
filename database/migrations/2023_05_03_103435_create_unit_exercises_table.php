<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_exercises', function (Blueprint $table) {
            $table->id();
            $table->string('file_url');
            $table->unsignedBigInteger('unit_id')->index();
            $table->foreign('unit_id')->on('units')->references('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->on('users')->references('id');
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
        Schema::dropIfExists('unit_exercises');
    }
};
