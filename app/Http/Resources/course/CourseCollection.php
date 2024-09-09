<?php

namespace App\Http\Resources\course;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

/***********
 * @mixin Course
 */
class CourseCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        $grade_id = $this->grade_me;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'background' => $this->background,
            'icon' => @$this->icon ? download_data($this->icon) : null,
            'units' => $this->Units,
            'description' => $this->description,
            'grade_id' => $this->grade_me,
            'unit_count' => @$grade_id ? $this->Units()->where('grade_id', '=', $grade_id)->count() : $this->Units->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
