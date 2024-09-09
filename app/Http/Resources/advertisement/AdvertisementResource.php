<?php

namespace App\Http\Resources\advertisement;

use App\Models\Advertisement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/******
 * @mixin Advertisement
 */
class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => @$this->id,
            'title' => @$this->title,
            'link' => @$this->link,
            'video_link' => @$this->video_link ? download_data( @$this->video_link) : null,
            'user' => @$this->User,
            'paid_status' => @$this->paid_status,
            'expire_at' => verta(@$this->expire_at)->format("Y/m/d"),
        ];
    }
}
