<?php

namespace App\Http\Resources\question;

use App\Http\Resources\question_attachment\QuestionAttachmentResource;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;


/****
 * @mixin Question
 */
class QuestionHasBookmarkResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'questions_type' => $this->questions_type,
            'level' => $this->Level,
            'course' => $this->Course,
            'unit' => $this->Unit,
            'section' => $this->Section,
            'grade' => $this->Grade,
            'teacher' => $this->Teacher,
            'is_bookmark' => @$this->user_id && @$this->Bookmarks()->where('user_id', '=', $this->user_id)->count() ? true : false,
            'question_attachments' => @$this->QuestionAttachments ? QuestionAttachmentResource::collection($this->QuestionAttachments) : null,
        ];
    }
}
