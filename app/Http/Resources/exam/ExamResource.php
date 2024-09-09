<?php

namespace App\Http\Resources\exam;

use App\Models\Exam;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/*******
 * @mixin Exam
 */
class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "question_quantity"=>$this->question_quantity,
            "time_exam"=>$this->time_exam,
            "status"=>$this->status,
            "user"=>$this->User,
            "course"=>$this->Course,
            "level"=>$this->Level,
        ];
    }
}
