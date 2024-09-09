<?php

namespace App\Repositories\MySQL\SectionRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceSectionRepository extends IBaseRepository
{
    public function find($id);

}
