<?php

namespace App\Repositories\MySQL\MenuRepository;

use App\Models\BaseInfo;
use App\Models\Menu;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class MenuRepository extends BaseRepository implements InterfaceMenuRepository
{
    /***********************
     * @var Menu $model
     ***********************/
    protected Menu $model;

    /*************************
     * @param Menu $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Menu $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
