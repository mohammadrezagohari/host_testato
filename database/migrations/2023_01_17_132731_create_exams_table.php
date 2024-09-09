<?php

use App\Enums\ExamType;
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
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->unsignedTinyInteger('question_quantity');
            $table->unsignedTinyInteger('answer_quantity');
            $table->unsignedInteger('time_exam')->default(30);
            $table->enum('status', ExamType::ALL)->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('course_id')->index();
            $table->unsignedBigInteger('level_id')->index();
            $table->unsignedTinyInteger('score')->nullable();
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
        Schema::dropIfExists('exams');
    }
};
