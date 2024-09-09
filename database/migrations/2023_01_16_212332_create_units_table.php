<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {                       /* فصل */
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->unsignedBigInteger('course_id')->index();
            $table->unsignedBigInteger('grade_id')->index();
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
        Schema::dropIfExists('units');
    }
};
