<?php

namespace App\Http\Resources\familiar;

use App\Models\Familiar;
use Illuminate\Http\Resources\Json\JsonResource;

/************
 * @mixin Familiar
 */
class FamiliarResource extends JsonResource
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
            'created_at' => $this->created_at,
        ];
    }
}
