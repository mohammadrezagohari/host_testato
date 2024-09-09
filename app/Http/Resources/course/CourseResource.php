<?php

namespace App\Http\Resources\course;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Course
 */
class CourseResource extends JsonResource
{
    /***************************************
     * Transform the resource into an array.
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'background' => $this->background,
            'icon' => download_data($this->icon),
            'units' => $this->Units,
            'description' => $this->description,
            'quantity_test' => $this->Questions->count(),
            'quantity_description' => $this->quantity_description,
            'unit_count' => $this->Units->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
