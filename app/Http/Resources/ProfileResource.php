<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/*******
 * @mixin User
 */
class ProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'avatar' => @$this->avatar,
            'full_name' => @$this->name,
            'sex' => @$this->sex,
            'grade' => @$this->Grade,
            'field' => @$this->Field,
            'familiar_id' => @$this->familiar_id,
            'familiar' => @$this->Familiar,
            'city' => @$this->City,
            'province' => @$this->Province,
            'mobile' => @$this->mobile,
            'school' => @$this->School,
            'roles' => @$this->roles ?? null,
        ];
    }
}
