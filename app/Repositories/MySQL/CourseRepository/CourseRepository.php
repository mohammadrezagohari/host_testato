<?php

namespace App\Repositories\MySQL\CourseRepository;

use App\Models\Course;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class CourseRepository extends BaseRepository implements InterfaceCourseRepository
{
    /***********************
     * @var Course $model
     ***********************/
    protected Course $model;

    /*************************
     * @param Course $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Course $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
