<?php

namespace App\Repositories\MySQL\SectionRepository;

use App\Models\Section;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class SectionRepository extends BaseRepository implements InterfaceSectionRepository
{
    /***********************
     * @var Section $model
     ***********************/
    protected Section $model;

    /*************************
     * @param Section $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Section $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->withIndex()->find($id);
    }


}
