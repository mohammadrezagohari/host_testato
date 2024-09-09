<?php

namespace App\Infrastructure;

use App\Enums\WalletHistoryStatus;
use App\Repositories\MySQL\WalletHistoryRepository\InterfaceWalletHistoryRepository;

class WalletHistory
{
    public function store($walletItem)
    {
        return \App\Models\WalletHistory::create([
            'wallet_id' => $walletItem->id,
            'amount' => $walletItem->amount,
            'bonus' => $walletItem->bonus,
            'is_expired' => false,
            'status' => WalletHistoryStatus::PAID
        ]);
    }
}
