<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\School
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|School newModelQuery()
 * @method static Builder|School newQuery()
 * @method static Builder|School query()
 * @method static Builder|School whereCreatedAt($value)
 * @method static Builder|School whereId($value)
 * @method static Builder|School whereName($value)
 * @method static Builder|School whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $Users
 * @property-read int|null $users_count
 * @method static \Database\Factories\SchoolFactory factory(...$parameters)
 * @mixin Eloquent
 */
class School extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function Users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
