<?php

namespace App\Http\Resources\unit;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitAttachmentResource extends JsonResource
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
            "image_url" => @$this->image_url ? download_data($this->image_url) : null,
        ];
    }
}
