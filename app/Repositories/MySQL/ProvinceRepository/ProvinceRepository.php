<?php

namespace App\Repositories\MySQL\ProvinceRepository;

use App\Models\Province;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class ProvinceRepository extends BaseRepository implements InterfaceProvinceRepository
{
    /***********************
     * @var Province $model
     ***********************/
    protected Province $model;

    /**************************************
     * @param Province $model
     * pass our model to the BaseRepository
     **************************************/
    public function __construct(Province $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
