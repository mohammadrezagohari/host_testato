<?php

namespace App\Models;

use Database\Factories\UnitFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Unit
 *
 * @property int $id
 * @property string $title
 * @property int $course_id
 * @property int $grade_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Course|null $Course
 * @property-read Grade|null $Grade
 * @property-read Collection|Question[] $Questions
 * @property-read int|null $questions_count
 * @property-read Collection|UnitAttachment[] $UnitAttachments
 * @property-read int|null $unit_attachments_count
 * @method static Builder|Unit newModelQuery()
 * @method static Builder|Unit newQuery()
 * @method static Builder|Unit query()
 * @method static Builder|Unit whereCourseId($value)
 * @method static Builder|Unit whereCreatedAt($value)
 * @method static Builder|Unit whereGradeId($value)
 * @method static Builder|Unit whereId($value)
 * @method static Builder|Unit whereTitle($value)
 * @method static Builder|Unit whereUpdatedAt($value)
 * @property-read Collection|Section[] $Sections
 * @property-read int|null $sections_count
 * @method static UnitFactory factory(...$parameters)
 * @method static Builder|Unit withIndex()
 * @method static Builder|Unit whereCourse($id)
 * @method static Builder|Unit whereGrade($id)
 * @property-read Collection|SummaryFormula[] $SummaryFormulas
 * @property-read int|null $summary_formulas_count
 * @property-read Collection|UnitExercise[] $UnitExercises
 * @property-read int|null $unit_exercises_count
 * @property-read UnitAttachment|null $Attachment
 * @property int|null $field_id
 * @method static Builder|Unit whereFieldId($value)
 * @property-read Collection<int, \App\Models\Field> $Fields
 * @property-read int|null $fields_count
 * @mixin Eloquent
 */
class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'course_id' ,
        'grade_id',
    ];

    #region relationships

    /*****************
     * سوالات
     * @return HasMany
     */
    public function Questions(): HasMany
    {
        return $this->HasMany(Question::class);
    }

    /*************
     * درس ها
     * @return BelongsTo
     */
    public function Course(): belongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /*******************
     *  مقطع
     * @return BelongsTo
     */
    public function Grade(): belongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    /******
     * بخش ها
     * @return hasMany
     */
    public function Sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    /****************
     * پیوست فصل
     * @return HasMany
     */
    public function UnitAttachments(): hasMany
    {
        return $this->hasMany(UnitAttachment::class);
    }


    public function Attachment()
    {
        return $this->hasOne(UnitAttachment::class);
    }

    /***
     *  خلاصه فرمول
     * @return HasMany
     */
    public function SummaryFormulas(): HasMany
    {
        return $this->hasMany(SummaryFormula::class);
    }

    /*****
     * تمرین های فصل
     * @return HasMany
     */
    public function UnitExercises(): HasMany
    {
        return $this->hasMany(UnitExercise::class);
    }

    /******************
     * رشته تحصیلی
     * @return BelongsToMany
     */
    public function Fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class);
    }
    #endregion


    #region scope
    public function scopeWithIndex($query)
    {
        return $query->with(['Course', 'Grade']);
    }

    public function scopeWhereCourse($query, $id)
    {
        return $query->where('course_id', '=', $id);
    }

    public function scopeWhereGrade($query, $id)
    {
        return $query->where('grade_id', '=', $id);
    }
    #endregion
}
