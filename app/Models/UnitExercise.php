<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UnitExercise
 *
 * @property-read \App\Models\Unit $Unit
 * @property-read \App\Models\User $User
 * @method static \Database\Factories\UnitExerciseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise whereUnit($id)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise withIndex()
 * @property int $id
 * @property string $file_url
 * @property int $unit_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitExercise whereUserId($value)
 * @mixin \Eloquent
 */
class UnitExercise extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_url',
        'unit_id',
        'user_id',
    ];


    #region Relationship
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    #endregion

    #region Scope
    public function scopeWithIndex($query)
    {
        return $query->with(['User', 'Unit']);
    }

    public function scopeWhereUnit($query, $id)
    {
        return $query->where('unit_id', '=', $id);
    }


    #endregion
}
