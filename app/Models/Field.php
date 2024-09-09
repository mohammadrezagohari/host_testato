<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Field
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Field query()
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $Users
 * @property-read int|null $users_count
 * @method static \Database\Factories\FieldFactory factory(...$parameters)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Grade> $Grades
 * @property-read int|null $grades_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $Courses
 * @property-read int|null $courses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Unit> $Units
 * @property-read int|null $units_count
 * @mixin \Eloquent
 */
class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    public function Users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function Grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function Courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function Units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }


}
