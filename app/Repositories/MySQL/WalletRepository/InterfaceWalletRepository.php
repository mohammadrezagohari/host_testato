<?php

namespace App\Repositories\MySQL\WalletRepository;

use App\Models\Wallet;
use App\Repositories\MySQL\IBaseRepository;
use phpDocumentor\Reflection\Types\Boolean;

interface InterfaceWalletRepository extends IBaseRepository
{
    public function find($id);
    public function decrease_value_for_payment(Wallet $wallet, $bonus, $amount):bool;
}
