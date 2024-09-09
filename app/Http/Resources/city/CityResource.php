<?php

namespace App\Http\Resources\city;

use App\Models\City;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/****
 * @mixin City
 */
class CityResource extends JsonResource
{
    /************
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'province' => $this->Province,
        ];
    }
}
