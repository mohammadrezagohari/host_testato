<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Suggestion
 *
 * @property int $id
 * @property string $context
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Suggestion whereUserId($value)
 * @mixin \Eloquent
 */
class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'context'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
