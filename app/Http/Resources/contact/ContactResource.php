<?php

namespace App\Http\Resources\contact;

use App\Models\Contact;
use Illuminate\Http\Resources\Json\JsonResource;

/***************
 * @mixin Contact
 */
class ContactResource extends JsonResource
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
            'instagram'     => $this->instagram,
            'mobile'        => $this->mobile,
            'email'         => $this->email,
            'address'       => $this->address
        ];
    }
}
