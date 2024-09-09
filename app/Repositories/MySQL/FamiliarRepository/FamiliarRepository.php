<?php
namespace App\Repositories\MySQL\FamiliarRepository;
use App\Repositories\MySQL\FamiliarRepository\InterfaceFamiliarRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Models\Familiar;

class FamiliarRepository extends BaseRepository implements InterfaceFamiliarRepository
{
    /***********************
     * @var Familiar $model
     ***********************/
    protected Familiar $model;

    /*************************
     * @param Familiar $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Familiar $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
