<?php

namespace App\Http\Resources\unitexercise;

use App\Models\UnitExercise;
use Illuminate\Http\Resources\Json\JsonResource;

/***
 * @mixin UnitExercise
 */
class UnitExerciseResource extends JsonResource
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
            'field_id' => $this->Unit->field_id,
            'grade_id' => $this->Unit->grade_id,
            'course_id' => $this->Unit->course_id,
            'unit' => @$this->Unit ? $this->Unit->title : null,
            'unit_id' => @$this->unit_id,
            'file_url' => @$this->file_url ? download_data($this->file_url) : null,
        ];
    }
}
