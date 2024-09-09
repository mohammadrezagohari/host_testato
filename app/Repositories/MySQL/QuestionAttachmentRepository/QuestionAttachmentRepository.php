<?php

namespace App\Repositories\MySQL\QuestionAttachmentRepository;

use App\Models\QuestionAttachment;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class QuestionAttachmentRepository extends BaseRepository implements InterfaceQuestionAttachmentRepository
{
    /***********************
     * @var QuestionAttachment $model
     ***********************/
    protected QuestionAttachment $model;

    /**************************************
     * @param QuestionAttachment $model
     * pass our model to the BaseRepository
     **************************************/
    public function __construct(QuestionAttachment $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
