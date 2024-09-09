<?php

namespace App\Repositories\MySQL\WalletRepository;

use App\Models\Unit;
use App\Models\Wallet;
use App\Repositories\MySQL\BaseRepository;

class WalletRepository extends BaseRepository implements InterfaceWalletRepository
{
    /***********************
     * @var Wallet $model
     ***********************/
    protected Wallet $model;

    /*************************
     * @param Wallet $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Wallet $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function find($id)
    {
        $this->model->withIndex()->find($id);
    }

    public function decrease_value_for_payment(Wallet $wallet, $bonus, $amount): bool
    {
        if ($bonus)
            $wallet->bonus-=$bonus;

        if ($amount)
            $wallet->amount-=$amount;
        return $wallet->save();
    }
}
