<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property string $title
 * @property string|null $icon
 * @property string|null $background
 * @property int $quantity_test
 * @property int $quantity_description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Question[] $Questions
 * @property-read int|null $questions_count
 * @method static Builder|Course newModelQuery()
 * @method static Builder|Course newQuery()
 * @method static Builder|Course query()
 * @method static Builder|Course whereBackground($value)
 * @method static Builder|Course whereCreatedAt($value)
 * @method static Builder|Course whereIcon($value)
 * @method static Builder|Course whereId($value)
 * @method static Builder|Course whereQuantityDescription($value)
 * @method static Builder|Course whereQuantityTest($value)
 * @method static Builder|Course whereTitle($value)
 * @method static Builder|Course whereUpdatedAt($value)
 * @property-read Collection|Exam[] $Exams
 * @property-read int|null $exams_count
 * @property-read Collection|Grade[] $Grades
 * @property-read int|null $grades_count
 * @property-read Collection|Unit[] $Units
 * @property-read int|null $units_count
 * @method static CourseFactory factory(...$parameters)
 * @method static Builder|Course whereUnitsIsUnderGrade($grade)
 * @method static Builder|Course withIndexUnits()
 * @property string $description
 * @property int|null $field_id
 * @property int|null $grade_id
 * @method static Builder|Course whereDescription($value)
 * @method static Builder|Course whereFieldId($value)
 * @method static Builder|Course whereGradeId($value)
 * @property-read Field|null $Field
 * @property-read \App\Models\Grade|null $Grade
 * @method static Builder|Course whereCourseHasGradeAndField($grade, $field)
 * @method static Builder|Course withIndex()
 * @mixin Eloquent
 */
class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'background',
        'description',
    ];


    #region relationships
//    public function Field()
//    {
//        return $this->belongsTo(Field::class);
//    }
    /**************************
     * سوالات
     * @return HasMany
     */
    public function Questions(): HasMany
    {
        return $this->HasMany(Question::class);
    }

//    /**********
//     * مقطع تحصیلی
//     * @return BelongsTo
//     */
//    public function Grade(): BelongsTo
//    {
//        return $this->belongsTo(Grade::class);
//    }

    /**************************
     * فصل
     * @return HasMany
     */
    public function Units(): HasMany
    {
        return $this->HasMany(Unit::class);
    }

    /**************************
     * امتحانات
     * @return HasMany
     */
    public function Exams(): HasMany
    {
        return $this->HasMany(Exam::class);
    }
    #endregion


    #region Scope
    public function scopeWithIndexUnits($query)
    {
        return $query->with(['Units']);
    }
    public function scopeWithIndex($query)
    {
        return $query->with(['Units','Questions']);
    }

    public function scopeWhereUnitsIsUnderGrade($query, $grade)
    {
        return $query->where('grade_id','=',$grade);
//        return $query->whereHas('Units', function ($query) use ($grade) {
//            $query->where('grade_id', '=', $grade);
//        });

    }
    public function scopeWhereCourseHasGradeAndField($query, $grade, $field)
    {
        return $query->where('grade_id','=',$grade)->where('field_id','=',$field);
//        return $query->whereHas('Units', function ($query) use ($grade) {
//            $query->where('grade_id', '=', $grade);
//        });

    }
    #endregion
}
