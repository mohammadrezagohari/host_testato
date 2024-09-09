<?php

namespace App\Repositories\MySQL\VersionRepository;

use App\Models\Version;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class VersionRepository extends BaseRepository implements InterfaceVersionRepository
{
    /***********************
     * @var Version $model
     ***********************/
    protected Version $model;

    /*************************
     * @param Version $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Version $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
