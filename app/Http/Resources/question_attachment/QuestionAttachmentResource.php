<?php

namespace App\Http\Resources\question_attachment;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionAttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "file_url" => @$this->file_url ? download_data($this->file_url) : null,
            "type" => @$this->type,
            "is_current" => @$this->is_current,
            "question_id" => @$this->question_id
        ];
    }
}
