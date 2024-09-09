<?php
namespace App\Repositories\MySQL\WalletHistoryRepository;
use App\Models\WalletHistory;
use App\Repositories\MySQL\WalletHistoryRepository\InterfaceWalletHistoryRepository;
use App\Repositories\MySQL\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class WalletHistoryRepository extends BaseRepository implements InterfaceWalletHistoryRepository
{
    /***********************
     * @var WalletHistory $model
     ***********************/
    protected WalletHistory $model;

    /*************************
     * @param WalletHistory $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(WalletHistory $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
