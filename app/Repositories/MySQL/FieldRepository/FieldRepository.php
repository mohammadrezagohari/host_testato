<?php

namespace App\Repositories\MySQL\FieldRepository;

use App\Models\Category;
use App\Models\Field;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of Field
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class FieldRepository extends BaseRepository implements InterfaceFieldRepository
{
    /***********************
     * @var Field $model
     ***********************/
    protected Field $model;

    /*************************
     * @param Field $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Field $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
