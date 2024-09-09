<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SummaryFormula
 *
 * @property int $id
 * @property string $file_url
 * @property int $unit_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Unit $Unit
 * @property-read \App\Models\User $User
 * @method static \Database\Factories\SummaryFormulaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula query()
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula withIndex()
 * @method static \Illuminate\Database\Eloquent\Builder|SummaryFormula whereUnit($id)
 * @mixin \Eloquent
 */
class SummaryFormula extends Model
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
