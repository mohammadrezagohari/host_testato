<?php

namespace App\Http\Resources\answersheet;

use App\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerSheetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $answer = Answer::whereExamId($request->exam_id)->where("question_id",'=',$this->Question->id)->first();
        return [
            "id" => $this->id,
            "question" => $this->Question,
            "correct_options_question_id" => $this->options_question_id,
            "video_link" => @$this->video_link ? download_data( @$this->video_link) : null,
            "user_options_question_id" => $answer->option_question_id,
            "is_correct_answer" => $answer->option_question_id == $this->options_question_id,
            "description" => $answer->description,
        ];
    }
}
