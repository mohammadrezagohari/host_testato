<?php

namespace App\Repositories\MySQL\AdvertisementRepository;

use App\Models\Advertisement;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class AdvertisementRepository extends BaseRepository implements InterfaceAdvertisementRepository
{
    /***********************
     * @var Advertisement $model
     ***********************/
    protected Advertisement $model;

    /*************************
     * @param Advertisement $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Advertisement $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

}
