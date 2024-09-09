<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Bookmark
 *
 * @property int $id
 * @property string $description
 * @property int $user_id
 * @property int $question_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $Category
 * @property-read \App\Models\Question|null $Question
 * @property-read \App\Models\User|null $User
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookmark withIndex()
 * @mixin \Eloquent
 */
class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'user_id',
        'question_id',
        'category_id',
    ];

    #region relationships

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function Question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
    #endregion


    #region scope
    public function scopeWithIndex($query)
    {
        return $query->with(['Question', 'Category', 'User']);
    }
    #endregion
}
