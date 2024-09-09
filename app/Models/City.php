<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $province_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Province|null $Province
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City searchByName($name)
 * @mixin \Eloquent
 */
class City extends Model
{
    use HasFactory;

    protected $table = "cities";
    protected $fillable = ['name', 'slug', 'province_id'];

    public function Province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    #region Scope
    public function scopeWhereProvinceId($query, $provinceId)
    {
        return $query->where('province_id', '=', $provinceId);
    }

    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%")->orWhere('slug', 'like', "%{$name}s%");
    }
    #endregion
}
