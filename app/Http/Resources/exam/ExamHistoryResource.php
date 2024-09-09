<?php

namespace App\Http\Resources\exam;

use App\Models\Exam;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Verta;

/**********
 * @mixin Exam
 */
class ExamHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $correctAnswerQuantity = @$this->Answers()->whereColumn('correct_option', '=', 'option_question_id')->count();
        return [
            'id' => @$this->id,
            'name' => @$this->name,
            'level' => @$this->Level ? $this->Level->title : null,
            'section' =>@$this->Level? $this->Level->Section->title : null,
            'unit' => @$this->Level ? $this->Level->Section->Unit->title : null,
            'question_quantity' => @$this->question_quantity,
            'correct_answer' => $correctAnswerQuantity,
            'wrong_and_no_answer' => $this->question_quantity - $correctAnswerQuantity,
            "time" => Verta($this->created_at)->format('Y/m/d H:i:s')
        ];
    }
}
