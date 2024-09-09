<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Section
 *
 * @property int $id
 * @property string $title
 * @property int $unit_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Level[] $Levels
 * @property-read int|null $levels_count
 * @property-read Collection|Question[] $Questions
 * @property-read int|null $questions_count
 * @property-read Unit|null $Unit
 * @method static Builder|Section newModelQuery()
 * @method static Builder|Section newQuery()
 * @method static Builder|Section query()
 * @method static Builder|Section whereCreatedAt($value)
 * @method static Builder|Section whereId($value)
 * @method static Builder|Section whereTitle($value)
 * @method static Builder|Section whereUnitId($value)
 * @method static Builder|Section whereUpdatedAt($value)
 * @method static \Database\Factories\SectionFactory factory(...$parameters)
 * @method static Builder|Section withIndex()
 * @method static Builder|Section whereUnit($unit_id)
 * @mixin Eloquent
 */
class Section extends Model
{
    use HasFactory;

    protected $fillable = ['title','unit_id'];

    #region relationships

    /*************
     * فصل ها
     * @return BelongsTo
     */
    public function Unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /*********
     *سطح ها
     * @return HasMany
     */

    public function Levels(): HasMany
    {
        return $this->HasMany(Level::class);
    }

    /********************
     * سوالات
     * @return HasMany
     */
    public function Questions(): HasMany
    {
        return $this->HasMany(Question::class);
    }

    #endregion


    #region scope
    public function scopeWithIndex($query)
    {
        return $query->with(['Unit']);
    }
    public function scopeWhereUnit($query,$unit_id)
    {
        return $query->where('unit_id','=',$unit_id);///join('units','sections.id','=','units.id')->where('units.id','=',$unit_id);
    }
    #endregion
}
