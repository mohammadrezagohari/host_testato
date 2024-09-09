<?php

namespace App\Repositories\MySQL\CityRepository;

use App\Models\City;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class CityRepository extends BaseRepository implements InterfaceCityRepository
{
    /***********************
     * @var City $model
     ***********************/
    protected City $model;

    /**************************************
     * @param City $model
     * pass our model to the BaseRepository
     **************************************/
    public function __construct(City $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
