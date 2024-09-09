<?php
namespace App\Repositories\MySQL\CoinRepository;
use App\Repositories\MySQL\CoinRepository\InterfaceCoinRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Models\Coin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CoinRepository extends BaseRepository implements InterfaceCoinRepository
{
    /***********************
     * @var Coin $model
     ***********************/
    protected Coin $model;

    /*************************
     * @param Coin $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Coin $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function findByName($name)
    {
        return $this->model->where('coin_name','=',$name)->first();
    }
}
