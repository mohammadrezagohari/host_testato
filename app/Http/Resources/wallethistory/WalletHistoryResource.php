<?php

namespace App\Http\Resources\wallethistory;

use App\Enums\CoinType;
use App\Models\Coin;
use App\Models\WalletHistory;
use Illuminate\Http\Resources\Json\JsonResource;

/*****
 * @mixin WalletHistory
 */
class WalletHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $goldCoin = Coin::where('coins.coin_name', '=', CoinType::Gold)->first();
        return [
            'id'            => $this->id,
            'gold_coin'     => $this->amount,
            'price'         => $this->amount * $goldCoin->coin_amount,
            'silver_coin'   => $this->bonus,
            'type'          => $this->type,
            'date'          => Verta($this->created_at)->format("Y/m/d"),
            'time'          => Verta($this->created_at)->format("H:m:s")
        ];
    }
}
