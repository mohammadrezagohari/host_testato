<?php

namespace App\Http\Resources\version;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class VersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => @$this->id,
            'version_base' => @$this->version_base,
            'version_name' => @$this->version_name,
            'application_file' => @$this->application_file ? download_data($this->application_file) : "",
            'type' => @$this->type
        ];
    }
}
