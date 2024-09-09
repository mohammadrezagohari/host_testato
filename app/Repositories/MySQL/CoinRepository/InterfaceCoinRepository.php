<?php

namespace App\Repositories\MySQL\CoinRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceCoinRepository extends IBaseRepository
{
    // Declare your repository methods here
    public function findByName($name);
}
