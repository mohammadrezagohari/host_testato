<?php

namespace App\Repositories\MySQL\PackageCoinRepository;
use App\Repositories\MySQL\IBaseRepository;

interface InterfacePackageCoinRepository extends IBaseRepository
{
    public function paginate($count);
}
