<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Grade
 *
 * @property int $id
 * @property string $name
 * @property int $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Grade newModelQuery()
 * @method static Builder|Grade newQuery()
 * @method static Builder|Grade query()
 * @method static Builder|Grade whereCreatedAt($value)
 * @method static Builder|Grade whereId($value)
 * @method static Builder|Grade whereName($value)
 * @method static Builder|Grade wherePriority($value)
 * @method static Builder|Grade whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $Courses
 * @property-read int|null $courses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $Questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $Users
 * @property-read int|null $users_count
 * @method static \Database\Factories\GradeFactory factory(...$parameters)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Unit[] $Units
 * @property-read int|null $units_count
 * @property int|null $field_id
 * @property-read \App\Models\Field|null $Field
 * @method static Builder|Grade whereFieldId($value)
 * @mixin Eloquent
 */
class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'priority'
    ];

    #region Relationship

    public function Units(): HasMany
    {
        return $this->hasMany(Unit::Class);
    }

    /**************************
     * سوالات
     * @return HasMany
     */
    public function Questions(): HasMany
    {
        return $this->HasMany(Question::class);
    }

    public function Users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    #endregion

}
