<?php

namespace App\Repositories\MySQL\SaveBoxRepository;

use App\Models\Answer;
use App\Models\SaveBox;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class SaveBoxRepository extends BaseRepository implements InterfaceSaveBoxRepository
{
    /***********************
     * @var SaveBox $model
     ***********************/
    protected SaveBox $model;

    /*************************
     * @param SaveBox $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(SaveBox $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
