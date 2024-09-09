<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Level
 *
 * @property int $id
 * @property string $title
 * @property int $quantity_questions
 * @property int $section_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $Questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Section|null $Section
 * @method static \Illuminate\Database\Eloquent\Builder|Level newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Level newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Level query()
 * @method static \Illuminate\Database\Eloquent\Builder|Level whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level whereQuantityQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Level whereUpdatedAt($value)
 * @method static \Database\Factories\LevelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Level withIndex()
 * @method static \Illuminate\Database\Eloquent\Builder|Level withIndexSection()
 * @property int $order
 * @method static \Illuminate\Database\Eloquent\Builder|Level whereOrder($value)
 * @mixin \Eloquent
 */
class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'quantity_questions',
        'section_id',
        'order',
    ];

    #region Relationship

    public function Questions(): HasMany
    {
        return $this->HasMany(Question::class);
    }

    public function Section(): BelongsTo
    {
        return $this->BelongsTo(Section::class);
    }

    #endregion

    #region Scopes

    public function scopeWithIndexSection($query)
    {
        return $query->with(['Section']);
    }

    public function scopeWithIndex($query)
    {
        return $query->with(['Section', 'Questions', 'Exam']);
    }

    public function scopeWhereSectionId($query, $id)
    {
        return $query->join('sections','levels.section_id','=','sections.id')
        ->where('sections.id', '=', $id)->select('levels.*');
    }
    #endregion
}
