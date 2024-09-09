<?php

namespace App\Http\Resources\slider;

use App\Models\Slider;
use Illuminate\Http\Resources\Json\JsonResource;

/******************
 * @mixin Slider
 */
class SliderResource extends JsonResource
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
            'title' => $this->title,
            'priority_order' => $this->priority_order,
            'file_url' => @$this->file_url ? download_data($this->file_url) : null,
            'mime_type' => $this->mime_type,
            'file_size' => $this->file_size,
        ];
    }
}
