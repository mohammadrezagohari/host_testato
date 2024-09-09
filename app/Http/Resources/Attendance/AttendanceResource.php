<?php

namespace App\Http\Resources\Attendance;

use App\Models\Attendance;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use Verta;
/********
 * @mixin Attendance
 */
class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user" => $this->User,
            "time" => Verta($this->created_at)->format('Y/m/d H:i:s')
        ];
    }
}
