<?php

namespace App\Repositories\MySQL\UnitRepository;

use App\Models\Unit;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class UnitRepository extends BaseRepository implements InterfaceUnitRepository
{
    /***********************
     * @var Unit $model
     ***********************/
    protected Unit $model;

    /*************************
     * @param Unit $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Unit $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


    public function find($id)
    {
        $this->model->withIndex()->find($id);
    }


    /*******************************
     * drop instance of model
     * @method bool deleteDataWithAttachment()
     * @param Unit $model
     *******************************/
    public function deleteDataWithAttachment(Unit $model): ?bool
    {
        if (!@$model)
            return false;

        $model->UnitAttachments->delete();
        return $model->delete();
    }
}
