<?php

namespace App\Http\Resources\level;

use App\Models\Level;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/****
 * @mixin Level
 */
class LevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */

    public function toArray($request)
    {
        $user = \Auth::user();
        $unit= $this->Section->Unit;
        return [
            'id'                        => $this->id,
            'title'                     => $this->title,
            'quantity_questions'        => $this->quantity_questions,
            'section'                   => $this->Section,
            'unit_id'                   => @$unit->id,
            'grad_id'                   => @$unit->grade_id,
            'course_id'                 => @$unit->course_id,
            'order'                     => $this->order,
            'answer_quantity'           => @$user->Exams ? (int)$user->Answers()->where('level_id', '=', $this->id)->count() : 0,
        ];
    }
}
