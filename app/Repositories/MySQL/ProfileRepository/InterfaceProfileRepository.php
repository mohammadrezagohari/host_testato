<?php

namespace App\Repositories\MySQL\ProfileRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceProfileRepository extends IBaseRepository
{
    public function find($id);

    public function step_value($id, $values);

    public function updateProfileByUser($id, $data, $address);

    public function deleteUser($user);

}
