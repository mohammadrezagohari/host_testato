<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|SaveBox[] $SaveBoxes
 * @property-read int|null $save_boxes_count
 * @method static CategoryFactory factory(...$parameters)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @property-read Collection|\App\Models\Bookmark[] $Bookmarks
 * @property-read int|null $bookmarks_count
 * @property-read \App\Models\User|null $User
 * @property int|null $user_id
 * @method static Builder|Category whereUserId($value)
 * @method static Builder|Category withIndex()
 * @property int $is_all
 * @method static Builder|Category whereIsAll($value)
 * @mixin Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'is_all'];

    public function Bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    #region Scope
    public function scopeWithIndex($query)
    {
        return $query->with([
            'Bookmarks',
            'User',
        ]);
    }

    #endregion
}
