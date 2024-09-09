<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $title
 * @property string $questions_type
 * @property int $level_id
 * @property int $course_id
 * @property int $unit_id
 * @property int $section_id
 * @property int $grade_id
 * @property int|null $teacher_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course|null $Course
 * @property-read \App\Models\Grade|null $Grade
 * @property-read \App\Models\Level|null $Level
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionAttachment[] $QuestionAttachments
 * @property-read int|null $question_attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionOption[] $QuestionOptions
 * @property-read int|null $question_options_count
 * @property-read \App\Models\Section|null $Section
 * @property-read \App\Models\Unit|null $Unit
 * @method static \Database\Factories\QuestionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestionsType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question withIndex()
 * @property-read \App\Models\User|null $Teacher
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bookmark[] $Bookmarks
 * @property-read int|null $bookmarks_count
 * @property-read \App\Models\AnswerSheet|null $AnswerSheet
 * @mixin \Eloquent
 */
class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'questions_type',
        'level_id',
        'course_id',
        'unit_id',
        'section_id',
        'grade_id',
        'teacher_id'
    ];

    #region relationships

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function Level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function Grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function Unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function Section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function AnswerSheet(): HasOne
    {
        return $this->hasOne(AnswerSheet::class);
    }

    public function Course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function QuestionAttachments(): HasMany
    {
        return $this->HasMany(QuestionAttachment::class);
    }

    public function Bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }
    #endregion

    #region Scope
    public function scopeWithIndex($query)
    {
        return $query->with([
            'QuestionAttachments',
            'Level',
            'Course',
            'Unit',
            'Section',
            'Grade',
            'Teacher'
        ]);
    }

    #endregion
}
