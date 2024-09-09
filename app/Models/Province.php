<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Province
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $Cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Province searchByName($name)
 * @mixin \Eloquent
 */
class Province extends Model
{
    use HasFactory;

    protected $table = "provinces";
    protected $fillable = [
        'name', 'slug'
    ];

    public function Cities(): HasMany
    {
        return $this->hasMany(City::class);
    }


    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%")->orWhere('slug', 'like', "%{$name}s%");
    }
}
