<?php

namespace App\Repositories\MySQL\QuestionRepository;

use App\Enums\QuestionFileType;
use App\Models\Question;
use App\Repositories\MySQL\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**********************************************************************************
 *  It's a class for repository of BaseInfo Model
 *  It inheritance form BaseRepository for added other general methods for actions
 *  It implements from IBaseInfoRepository to register the rules
 *********************************************************************************/
class QuestionRepository extends BaseRepository implements InterfaceQuestionRepository
{
    /***********************
     * @var Question $model
     ***********************/
    protected Question $model;

    /*************************
     * @param Question $model
     * pass our model to the BaseRepository
     *************************/
    public function __construct(Question $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function insertReturnNewInstance($data, $filePath)
    {
        $question = new Question;
        $question->title = $data['title'];
        $question->level_id = $data['level_id'];
        $question->course_id = $data['course_id'];
        $question->unit_id = $data['unit_id'];
        $question->section_id = $data['section_id'];
        $question->grade_id = $data['grade_id'];
        $question->teacher_id = $data['teacher_id'];
        $question->save();
        $question->QuestionAttachments()->create([
            'is_current' => true,
            'type' => QuestionFileType::Image,
            'file_url' => $filePath
        ]);
        return $question;
    }


    public function getAttachments($id)
    {
        return $this->model->find($id)->QuestionAttachments;
    }

    public function getAttachmentsWithType($id, $type)
    {
        return $this->model->find($id)->QuestionAttachments()->where('type', '=', $type)->get();
    }


    public function getCurrentAttachment($id)
    {
        return $this->model->find($id)->QuestionAttachments()->where('is_current', '=', true)->get();
    }

    public function getCurrentAttachmentWithType($id,$type)
    {
        return $this->model->find($id)->QuestionAttachments()->where('is_current', '=', true)->where('type', '=', $type)->get();
    }


}
