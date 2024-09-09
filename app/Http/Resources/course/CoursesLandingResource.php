<?php

namespace App\Http\Resources\course;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

/***
 * @mixin Course
 */
class CoursesLandingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'question_count' => $this->Questions->count(),
        ];
    }
}
