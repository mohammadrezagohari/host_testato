<?php
namespace App\Repositories\MySQL\AlertRepository;
use App\Repositories\MySQL\AlertRepository\InterfaceAlertRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Models\Alert;

class AlertRepository extends BaseRepository implements InterfaceAlertRepository
{
    /***********************
     * @var Alert $model
     ***********************/
    protected Alert $model;

    /*************************
     * @param Alert $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Alert $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
