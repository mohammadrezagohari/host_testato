<?php

namespace App\Repositories\MySQL\QuestionRepository;

use App\Repositories\MySQL\IBaseRepository;

interface InterfaceQuestionRepository extends IBaseRepository
{
    public function insertReturnNewInstance($data,$filePath);
    public function getAttachments($id);
    public function getAttachmentsWithType($id, $type);
    public function getCurrentAttachment($id);
    public function getCurrentAttachmentWithType($id,$type);
}
