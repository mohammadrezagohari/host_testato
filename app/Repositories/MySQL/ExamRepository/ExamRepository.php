<?php

namespace App\Repositories\MySQL\ExamRepository;

use App\Models\Course;
use App\Models\Exam;
use App\Repositories\MySQL\BaseRepository;
use NumberToWords\NumberToWords;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class ExamRepository extends BaseRepository implements InterfaceExamRepository
{

    /***********************
     * @var Exam $model
     ***********************/
    protected Exam $model;

    /*************************
     * @param Exam $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Exam $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function SetExamName($course, $userId)
    {
        $counterExam = $this->model->whereCourse($course)->whereUser($userId)->count();
        $numberToWords = new NumberToWords();
        $currentCourse = Course::find($course);
        $result = null;
        if ($counterExam == 0)
            $result = "{$currentCourse->title} " . NumberToWords::transformNumber('fa', 1);
        else
            $result = "{$currentCourse->title} " . NumberToWords::transformNumber("fa", ($counterExam + 1));

        return $result;
    }

    public function getUserHistoryExamsHasDateAndSearch($userId, $from_date, $to_date, $search = null)
    {
        $query = $this->model->where('user_id', '=', $userId)
            ->whereBetween("created_at", [$from_date, $to_date]);

        if (@$search) {
            $query->where('name', '=', $search);
        }
        return $query;
    }
}
