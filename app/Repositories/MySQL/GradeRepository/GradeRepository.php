<?php

namespace App\Repositories\MySQL\GradeRepository;

use App\Models\Grade;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class GradeRepository extends BaseRepository implements InterfaceGradeRepository
{
    /**
     * @var Grade
     */
    protected Grade $model;

    /*************************
     * @param Grade $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Grade $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
