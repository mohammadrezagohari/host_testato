<?php

namespace App\Http\Resources\summary;

use App\Models\SummaryFormula;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**********
 * @mixin SummaryFormula
 */
class SummaryFormulaResource extends JsonResource
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
            'unit' => @$this->Unit ? $this->Unit->title : null,
            'file_url' => @$this->file_url ? download_data($this->file_url) : null,
        ];
    }
}
