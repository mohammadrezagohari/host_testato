<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OptionQuestion
 *
 * @property int $id
 * @property int $question_id
 * @property string|null $captions
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion whereCaptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OptionQuestion extends Model
{
    use HasFactory;
}
