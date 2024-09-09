<?php

namespace App\Http\Resources\unit;

use App\Models\Unit;
use Illuminate\Http\Resources\Json\JsonResource;

/**********
 * @mixin Unit
 */
class UnitResource extends JsonResource
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
            'course' => $this->Course,
            'grade' => $this->Grade,
            'fields' => $this->Fields,
            'unit_attachments' => @$this->UnitAttachments ? UnitAttachmentResource::collection($this->UnitAttachments) : null,
            'section_count' => $this->sections
        ];
    }
}
