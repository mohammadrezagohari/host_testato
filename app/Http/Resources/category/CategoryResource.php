<?php

namespace App\Http\Resources\category;

use App\Enums\QuestionCategory;
use App\Models\Bookmark;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/******************
 * @mixin Category
 *****************/
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $allCategoryCount = Bookmark::whereUserId($this->User->id)->count();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_all' => (bool)$this->is_all,
            'user' => $this->User,
            'quantity' => $this->name == QuestionCategory::AllQuestion ? $allCategoryCount : $this->Bookmarks->count(),
        ];
    }
}
