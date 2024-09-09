<?php

namespace App\Repositories\MySQL\LevelRepository;

use App\Models\Level;
use App\Repositories\MySQL\BaseRepository;
use Exception;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class LevelRepository extends BaseRepository implements InterfaceLevelRepository
{
    /***********************
     * @var Level $model
     ***********************/
    protected Level $model;

    /*************************
     * @param Level $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Level $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

}
