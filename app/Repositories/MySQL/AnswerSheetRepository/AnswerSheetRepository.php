<?php

namespace App\Repositories\MySQL\AnswerSheetRepository;

use App\Models\AnswerSheet;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class AnswerSheetRepository extends BaseRepository implements InterfaceAnswerSheetRepository
{
    /***********************
     * @var AnswerSheet $model
     ***********************/
    protected AnswerSheet $model;

    /*************************
     * @param AnswerSheet $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(AnswerSheet $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
