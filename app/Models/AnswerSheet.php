<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\AnswerSheet
 *
 * @property int $id
 * @property int $question_id
 * @property int|null $options_question_id
 * @property string|null $captions
 * @property string|null $video_link
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|AnswerSheet newModelQuery()
 * @method static Builder|AnswerSheet newQuery()
 * @method static Builder|AnswerSheet query()
 * @method static Builder|AnswerSheet whereCaptions($value)
 * @method static Builder|AnswerSheet whereCreatedAt($value)
 * @method static Builder|AnswerSheet whereDescription($value)
 * @method static Builder|AnswerSheet whereId($value)
 * @method static Builder|AnswerSheet whereOptionsQuestionId($value)
 * @method static Builder|AnswerSheet whereQuestionId($value)
 * @method static Builder|AnswerSheet whereUpdatedAt($value)
 * @method static Builder|AnswerSheet whereVideoLink($value)
 * @property-read \App\Models\OptionQuestion|null $OptionQuestion
 * @property-read \App\Models\Question|null $Question
 * @method static Builder|AnswerSheet whereInQuestion($questionIds)
 * @method static Builder|AnswerSheet withIndex()
 * @mixin Eloquent
 */
class AnswerSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'captions',
        'video_link',
        'description',
        'question_id',
        'options_question_id',
    ];


    #region Relationship
    public function Question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function OptionQuestion(): BelongsTo
    {
        return $this->belongsTo(OptionQuestion::class);
    }
    #endregion


    #region Scope
    public function scopeWhereInQuestion($query, $questionIds)
    {
        return $query->whereIn('question_id', $questionIds);
    }

    public function scopeWhereQuestionId($query, $questionId)
    {
        return $query->whereIn('question_id', $questionId);
    }


    public function scopeWithIndex($query)
    {
        return $query->with(['Question']);
    }
    #endregion

}
