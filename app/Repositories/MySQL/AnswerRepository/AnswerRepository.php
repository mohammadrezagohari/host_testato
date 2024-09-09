<?php

namespace App\Repositories\MySQL\AnswerRepository;

use App\Models\Answer;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class AnswerRepository extends BaseRepository implements InterfaceAnswerRepository
{
    /***********************
     * @var Answer $model
     ***********************/
    protected Answer $model;

    /*************************
     * @param Answer $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Answer $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

}
