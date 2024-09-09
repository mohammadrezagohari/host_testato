<?php

namespace App\Http\Resources\unit;

use App\Http\Resources\course\CourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitListResource extends JsonResource
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
            'title' => $this->title,
            'course' => CourseResource::make($this->course),
            'grade' => $this->grade,
            'unit_attachments' => @$this->UnitAttachments ? UnitAttachmentResource::collection($this->UnitAttachments) : null,
            'section_count' => $this->sections()->count()
        ];
    }
}
