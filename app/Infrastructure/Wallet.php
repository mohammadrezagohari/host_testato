<?php

namespace App\Infrastructure;

use App\Repositories\MySQL\WalletHistoryRepository\InterfaceWalletHistoryRepository;
use App\Repositories\MySQL\WalletRepository\InterfaceWalletRepository;
use App\Repositories\MySQL\WalletRepository\WalletRepository;

class Wallet
{


    public function decrease_value_for_payment($user, $gold = null, $silver = null)
    {
        $wallet = \App\Models\Wallet::whereUserId($user)->first();
        $walletHistory = new WalletHistory();
        $walletHistory->store($wallet);
        if (@$silver) {
            $wallet->bonus = $wallet->bonus - $silver;
        }
        if (@$gold) {
            $wallet->amount = $wallet->amount - $gold;
        }
        return $wallet->save();
    }
}
