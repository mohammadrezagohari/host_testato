<?php

namespace App\Http\Resources\package;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageCoinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'gold_coin'=>$this->title,
            'quantity'=>$this->quantity,
        ];
    }
}
