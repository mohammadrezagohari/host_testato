<?php

namespace App\Repositories\MySQL\SliderRepository;

use App\Models\Slider;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class SliderRepository extends BaseRepository implements InterfaceSliderRepository
{
    /***********************
     * @var Slider $model
     ***********************/
    protected Slider $model;

    /*************************
     * @param Slider $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Slider $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
