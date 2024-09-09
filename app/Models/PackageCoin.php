<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PackageCoin
 *
 * @property int $id
 * @property string $title
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCoin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCoin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCoin query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCoin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCoin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCoin whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCoin whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageCoin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PackageCoin extends Model
{
    use HasFactory;
}
