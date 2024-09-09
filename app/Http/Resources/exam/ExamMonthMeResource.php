<?php

namespace App\Http\Resources\exam;

use App\Models\Exam;
use Illuminate\Http\Resources\Json\JsonResource;

/*****************
 * @mixin Exam
 */
class ExamMonthMeResource extends JsonResource
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
            "id" => $this->id,
            "question_quantity" => $this->question_quantity,
            "time_exam" => $this->time_exam,
            "status" => $this->status,
            "user" => $this->User,
            "course" => $this->Course,
            "level" => $this->Level,
            "time" => Verta($this->created_at)->format('Y/m/d H:i:s')
        ];
    }
}
