<?php

namespace App\Repositories\MySQL\SummaryFormulaRepository;

use App\Models\SummaryFormula;
use App\Repositories\MySQL\BaseRepository;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class SummaryFormulaRepository extends BaseRepository implements InterfaceSummaryFormulaRepository
{
    /***********************
     * @var SummaryFormula $model
     ***********************/
    protected SummaryFormula $model;

    /*************************
     * @param SummaryFormula $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(SummaryFormula $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


}
