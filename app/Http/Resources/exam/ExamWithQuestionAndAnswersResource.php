<?php

namespace App\Http\Resources\exam;

use App\Http\Resources\question\QuestionHasBookmarkResource;
use App\Http\Resources\question\QuestionResource;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**********
 * @mixin Exam
 */
class ExamWithQuestionAndAnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        @$this->Answers ? $questions = Question::whereIn('id', $this->Answers()->pluck('question_id'))->orderByDesc('id')->get() : $questions=null;
        return [
            'id' => $this->id,
            'answers' => @$this->Answers,
            'questions' => @$questions ? QuestionHasBookmarkResource::collection($questions)->additional(['user_id' => $this->user_id]) : QuestionHasBookmarkResource::collection($questions),
        ];
    }
}
