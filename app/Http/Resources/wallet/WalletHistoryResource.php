<?php

namespace App\Http\Resources\wallet;

use App\Models\WalletHistory;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin WalletHistory
 */
class WalletHistoryResource extends JsonResource
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
            'id'                => $this->id,
            'gold_coin'         => $this->amount,
            'silver_coin'       => $this->bonus,
            'type'              => $this->type,
            'date'              => Verta($this->created_at)->format("Y/m/d"),
            'time'              => Verta($this->created_at)->format("H:m:s")
        ];
    }
}
