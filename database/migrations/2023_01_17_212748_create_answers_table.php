<?php

use App\Enums\AnswerStatus;
use App\Enums\ResultStatusBank;
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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->enum('status', AnswerStatus::ALL)
                ->default(AnswerStatus::unRead)->index();
            $table->text('explain')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('spending')->nullable();
            $table->unsignedTinyInteger('option_question_id')->index()->nullable();
            $table->unsignedTinyInteger('correct_option')->index()->nullable();
            $table->unsignedBigInteger('question_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('exam_id')->index();
            $table->unsignedBigInteger('level_id')->nullable()->index();
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
