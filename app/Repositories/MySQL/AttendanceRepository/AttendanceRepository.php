<?php
namespace App\Repositories\MySQL\AttendanceRepository;
use App\Repositories\MySQL\AttendanceRepository\InterfaceAttendanceRepository;
use App\Repositories\MySQL\BaseRepository;
use App\Models\Attendance;

class AttendanceRepository extends BaseRepository implements InterfaceAttendanceRepository
{
    /***********************
     * @var Attendance $model
     ***********************/
    protected Attendance $model;

    /*************************
     * @param Attendance $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Attendance $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
