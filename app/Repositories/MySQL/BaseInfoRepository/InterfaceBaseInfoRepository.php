<?php

namespace App\Repositories\MySQL\BaseInfoRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceBaseInfoRepository extends IBaseRepository
{
    public function findFirstSection($sectionName, $key);

    public function getSection($sectionName);

    public function first();
}
