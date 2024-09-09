<?php

namespace App\Http\Resources\wallet;

use App\Models\Wallet;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @mixin Wallet
 */
class WalletResource extends JsonResource
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
            'has_credit' => $this->has_credit,
            'bonus' => $this->bonus,
            'amount' => $this->amount,
            'user' => $this->user,
        ];
    }
}
