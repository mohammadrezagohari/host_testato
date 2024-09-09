<?php

namespace App\Http\Resources\grade;

use App\Models\Grade;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/***************
 * @mixin Grade
 */
class GradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => @$this->id,
            'name' => @$this->name,
            'priority' => @$this->priority,
        ];
    }
}
