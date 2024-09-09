<?php

namespace App\Models;

use App\Enums\ExamType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Exam
 *
 * @property int $id
 * @property int $question_quantity
 * @property int $time_exam
 * @property string $status
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereQuestionQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereTimeExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereUserId($value)
 * @property int $course_id
 * @property int $level_id
 * @property int|null $score
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Answer[] $Answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\Course|null $Course
 * @property-read \App\Models\Level|null $Level
 * @property-read \App\Models\User|null $User
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereCourse($id)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereUser($id)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam withIndex()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam withIndexAndAnswers()
 * @property int|null $answer_quantity
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereAnswerQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereStatusUnfinished()
 * @method static \Database\Factories\ExamFactory factory(...$parameters)
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereKeyword($keyword, $startDate = null, $endDate = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereDateBetween($startDate, $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereKeywordIs($keyword)
 * @mixin \Eloquent
 */
class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'score',
        'question_quantity',
        'time_exam',
        'status',
        'user_id',
        'course_id',
        'level_id',
        'answer_quantity',
    ];

    #region Relationship

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function Answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function Level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    #endregion

    #region scope
    public function scopeWithIndex($query)
    {
        return $query->with(['User', 'Course', 'Level']);
    }

    public function scopeWithIndexAndAnswers($query)
    {
        return $query->with(['User', 'Course', 'Level', 'Answers']);
    }

    public function scopeWhereUser($query, $id)
    {
        return $query->where('user_id', '=', $id);
    }

    public function scopeWhereCourse($query, $id)
    {
        return $query->where('course_id', '=', $id);
    }

    public function scopeWhereKeyword($query, $keyword, $startDate = null, $endDate = null)
    {
        if (@$startDate && @$endDate) {
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        return $query->where('name', 'like', "%{$keyword}%");
    }

    public function scopeWhereDateBetween($query, $startDate , $endDate )
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeWhereKeywordIs($query, $keyword)
    {
        return $query->where('name', 'like', "%{$keyword}%");
    }

    public function scopeWhereStatusUnfinished($query)
    {
        return $query->whereNotIn('status', ExamType::finishedCollection);
    }
    #endregion


}
