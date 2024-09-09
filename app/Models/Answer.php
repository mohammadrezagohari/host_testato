<?php

namespace App\Models;

use App\Enums\AnswerStatus;
use App\Enums\AttachmentType;
use App\Enums\DataTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Answer
 *
 * @property int $id
 * @property string $status
 * @property string|null $explain
 * @property int|null $option_question_id
 * @property int $question_id
 * @property int $user_id
 * @property int $exam_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AnswerSheet|null $AnswerSheet
 * @property-read \App\Models\Exam|null $Exam
 * @property-read \App\Models\OptionQuestion|null $OptionQuestion
 * @property-read \App\Models\Question|null $Question
 * @property-read \App\Models\User|null $User
 * @method static \Illuminate\Database\Eloquent\Builder|Answer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereExplain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereOptionQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer searchByName($name)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereInQuestion($questions)
 * @property string|null $description
 * @property int|null $spending
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereSpending($value)
 * @property int|null $correct_option
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereCorrectOption($value)
 * @property-read \App\Models\QuestionAttachment|null $QuestionAttachment
 * @property int|null $level_id
 * @method static \Illuminate\Database\Eloquent\Builder|Answer whereLevelId($value)
 * @mixin \Eloquent
 */
class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'explain',
        'user_id',
        'exam_id',
        'level_id',
        'spending',
        'question_id',
        'description',
        'option_question_id',
        'correct_option',

    ];

    #region Relationships

    /****************************
     * سوالات
     * @return BelongsTo
     */
    public function Question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function QuestionAttachment(): BelongsTo
    {
        return $this->belongsTo(QuestionAttachment::class, 'question_id', 'question_id')->where('type', '=', AttachmentType::IMAGE)->where('is_current', '=', true);
    }

    /******************
     * پاسخنامه
     * @return HasOne
     */
    public function AnswerSheet(): HasOne
    {
        return $this->hasOne(AnswerSheet::class);
    }

    /********************
     * کاربر
     * @return BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*******
     *امتحان
     * @return BelongsTo
     */
    public function Exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
    #endregion


    #region Scope
    public function scopeSearchByName($query, $name)
    {
        return $query->where('explain', 'like', "%{$name}%");
    }

    public function scopeWhereInQuestion($query, $questions)
    {
        return $query->whereIn('question_id', $questions);
    }
    #endregion


}
