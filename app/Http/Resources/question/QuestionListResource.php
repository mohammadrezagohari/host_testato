<?php

namespace App\Http\Resources\question;

use App\Enums\AttachmentType;
use App\Enums\QuestionType;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Question
 */
class QuestionListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image = $this->QuestionAttachments->where('type', '=', AttachmentType::IMAGE)
            ->where('is_current', '=', true)->first();

        $video = $this->QuestionAttachments->where('type', '=', AttachmentType::VIDEO)
            ->where('is_current', '=', true)->first();

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
            'video' => @$video ? download_data($video->file_url) : "",
            'image' => @$image ? download_data($image->file_url) : "",
//            'image' => @$image ?? download_data($image->file_url),
        ];
    }
}
