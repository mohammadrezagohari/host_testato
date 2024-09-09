<?php

namespace App\Repositories\MySQL\UnitRepository;

use App\Models\Unit;
use App\Repositories\MySQL\IBaseRepository;

interface InterfaceUnitRepository extends IBaseRepository
{
    public function find($id);

    public function deleteDataWithAttachment(Unit $model);

}
