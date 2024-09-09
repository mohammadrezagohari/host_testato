<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SaveBox
 *
 * @property int $id
 * @property int $question_id
 * @property int $answer_id
 * @property int $category_id
 * @property int $user_id
 * @property int $course_id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaveBox whereUserId($value)
 * @mixin \Eloquent
 */
class SaveBox extends Model
{
    use HasFactory;

}
