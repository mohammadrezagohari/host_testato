<?php

namespace App\Repositories\MySQL\BaseInfoRepository;

use App\Models\BaseInfo;
use App\Repositories\MySQL\BaseInfoRepository\InterfaceBaseInfoRepository;
use App\Repositories\MySQL\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseInfoRepository extends BaseRepository implements InterfaceBaseInfoRepository
{
    /***********************
     * @var BaseInfo $model
     ***********************/
    protected BaseInfo $model;

    /*************************
     * @param BaseInfo $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(BaseInfo $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function findFirstSection($sectionName, $key)
    {
        return $this->model
            ->where('section', '=', $sectionName)
            ->where('key', '=', $key)
            ->first();
    }

    public function getSection($sectionName)
    {
        return $this->model
            ->where('section', '=', $sectionName)
            ->get();
    }


    public function first(){
        return $this->model->first();
    }

}
