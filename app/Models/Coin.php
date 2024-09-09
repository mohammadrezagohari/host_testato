<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Coin
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Coin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coin query()
 * @property int $id
 * @property string $coin_name
 * @property string|null $rank
 * @property float $coin_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereCoinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereCoinName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereUpdatedAt($value)
 * @method static \Database\Factories\CoinFactory factory(...$parameters)
 * @mixin \Eloquent
 */
class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'coin_name',
        'rank',
        'coin_amount',
    ];

    public function scopeWhereCoinName($query, $name)
    {
        $query->where('coin_name', '=', $name);
    }

}
