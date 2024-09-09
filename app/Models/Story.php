<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Story
 *
 * @property int $id
 * @property string $title
 * @property string|null $link
 * @property int $priority_order
 * @property string $file_url
 * @property string|null $mime_type
 * @property string $file_size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Story newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Story newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Story query()
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story wherePriorityOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $Users
 * @property-read int|null $users_count
 * @method static \Database\Factories\StoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Story withIndex()
 * @property string $image_preview
 * @property string $expire_at
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereImagePreview($value)
 * @mixin \Eloquent
 */
class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'priority_order',
        'file_url',
        'image_preview',
        'expire_at',
    ];


    #region Relationship
    public function Users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    #endregion
    #region scope
    public function scopeWithIndex($query)
    {
        return $query->with(['Users']);
    }
    #endregion

    /////// TODO: Create a model for visited Stories { who visited its and how many visited its ...}

}
