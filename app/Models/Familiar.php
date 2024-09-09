<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Familiar
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $Users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Familiar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Familiar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Familiar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Familiar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Familiar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Familiar whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Familiar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Familiar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function Users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
