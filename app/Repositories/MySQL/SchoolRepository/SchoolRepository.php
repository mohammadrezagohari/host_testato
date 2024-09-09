<?php

namespace App\Repositories\MySQL\SchoolRepository;

use App\Models\School;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of School Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class SchoolRepository extends BaseRepository implements InterfaceSchoolRepository
{
    /***********************
     * @var School $model
     ***********************/
    protected School $model;

    /*************************
     * @param School $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(School $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }



}
