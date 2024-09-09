<?php

namespace App\Repositories\MySQL\CategoryRepository;

use App\Models\Category;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class CategoryRepository extends BaseRepository implements InterfaceCategoryRepository
{
    /***********************
     * @var Category $model
     ***********************/
    protected Category $model;

    /*************************
     * @param Category $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Category $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
