<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionAttachment
 *
 * @property int $id
 * @property string $file_url
 * @property int $is_current
 * @property int $question_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment whereIsCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment whereUpdatedAt($value)
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionAttachment whereType($value)
 * @property-read \App\Models\Question|null $Question
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Answer> $Answers
 * @property-read int|null $answers_count
 * @mixin \Eloquent
 */
class QuestionAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_url',
        'type',
        'is_current',
        'question_id',
    ];

    public function Question()
    {
        return $this->belongsTo(Question::class);
    }
    public function Answers()
    {
        return $this->hasMany(Answer::class,'question_id');
    }

}
