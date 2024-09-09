<?php
namespace App\Repositories\MySQL\PackageCoinRepository;
use App\Models\PackageCoin;
use App\Repositories\MySQL\PackageCoinRepository\InterfacePackageCoinRepository;
use App\Repositories\MySQL\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class PackageCoinRepository extends BaseRepository implements InterfacePackageCoinRepository
{
    /***********************
     * @var PackageCoin $model
     ***********************/
    protected PackageCoin $model;

    /*************************
     * @param PackageCoin $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(PackageCoin $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


    public function paginate($count)
    {
        return $this->model->paginate($count);
    }
    public function first()
    {
        return $this->model->first();
    }

}
