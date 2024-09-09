<?php

namespace App\Http\Resources\section;

use App\Models\Section;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/*****
 * @mixin Section
 * */
class SectionResource extends JsonResource
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
            'title' => $this->title,
            'unit' => $this->Unit,
            'course' => $this->Unit->Course
        ];
    }
}
