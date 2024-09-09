<?php

use App\Enums\QuestionType;
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
    {   // سوالات
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->enum('questions_type', QuestionType::ALL);
            $table->unsignedBigInteger('level_id')->index();
            $table->unsignedBigInteger('course_id')->index();
            $table->unsignedBigInteger('unit_id')->index();
            $table->unsignedBigInteger('section_id')->index();
            $table->unsignedBigInteger('grade_id')->index();
            $table->unsignedBigInteger('teacher_id')->nullable();
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
        Schema::dropIfExists('questions');
    }
};
