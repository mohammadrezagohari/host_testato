<?php

namespace App\Http\Resources\invoice;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'can_exam' => true,
            'has_credit' =>true,
            'bonus' => $this->bonus,
            'amount' => $this->amount,
            'user' => $this->user,
        ];
    }

    public function with($request)
    {
        return [
        ];
    }


}
