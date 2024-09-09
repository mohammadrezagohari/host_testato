<?php

namespace App\Repositories\MySQL\UnitExerciseRepository;

use App\Models\UnitExercise;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class UnitExerciseRepository extends BaseRepository implements InterfaceUnitExerciseRepository
{
    /***********************
     * @var UnitExercise $model
     ***********************/
    protected UnitExercise $model;

    /*************************
     * @param UnitExercise $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(UnitExercise $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
