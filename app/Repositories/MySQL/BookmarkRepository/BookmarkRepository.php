<?php

namespace App\Repositories\MySQL\BookmarkRepository;

use App\Models\Bookmark;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class BookmarkRepository extends BaseRepository implements InterfaceBookmarkRepository
{
    /***********************
     * @var Bookmark $model
     ***********************/
    protected Bookmark $model;

    /*************************
     * @param Bookmark $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Bookmark $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

}
