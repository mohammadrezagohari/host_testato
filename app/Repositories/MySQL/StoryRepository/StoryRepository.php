<?php

namespace App\Repositories\MySQL\StoryRepository;

use App\Models\Story;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class StoryRepository extends BaseRepository implements InterfaceStoryRepository
{
    /***********************
     * @var Story $model
     ***********************/
    protected Story $model;

    /*************************
     * @param Story $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Story $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
