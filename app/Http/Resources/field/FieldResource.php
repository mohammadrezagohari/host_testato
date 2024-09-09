<?php

namespace App\Http\Resources\field;

use App\Models\Field;
use Illuminate\Http\Resources\Json\JsonResource;

/****
 * @mixin Field
 */
class FieldResource extends JsonResource
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
            'name' => $this->name
        ];
    }
}
