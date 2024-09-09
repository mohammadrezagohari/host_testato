<?php
namespace App\Repositories\MySQL\RoleRepository;
use App\Repositories\MySQL\RoleRepository\InterfaceRoleRepository;
use App\Repositories\MySQL\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements InterfaceRoleRepository
{
    /***********************
     * @var Role $model
     ***********************/
    protected Role $model;

    /*************************
     * @param Role $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Role $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
