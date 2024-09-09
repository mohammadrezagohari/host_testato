<?php

namespace App\Http\Resources\story;

use App\Models\Story;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Story
 */
class StoryResource extends JsonResource
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
            'link' => $this->link,
            'priority_order' => $this->priority_order,
            'file_url' => @$this->file_url ? download_data($this->file_url) : null,
            'image_preview' => @$this->image_preview ? download_data($this->image_preview) : null,
            'expire_at' => \Verta($this->expire_at)->formatDifference(),
            'expire_at_miladi' => $this->expire_at,
            'expire_at_shamsi' => \Verta($this->expire_at)->formatJalaliDatetime()
        ];
    }
}
