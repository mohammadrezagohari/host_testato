<?php

namespace App\Http\Resources\answer;

use App\Models\Answer;
use Illuminate\Http\Resources\Json\JsonResource;

/***********
 * @mixin Answer
 */
class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'description' => $this->description,
            'spending' => $this->spending,
            'option_question_id' => $this->option_question_id,
            'correct_option' => $this->correct_option,
            'question_id' => $this->question_id,
            'user_id' => $this->user_id,
            'exam_id' => $this->exam_id,
            'created_at' => $this->created_at,
        ];

    }
}
