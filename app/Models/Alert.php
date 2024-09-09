<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Alert
 *
 * @property int $id
 * @property string $type
 * @property string $context
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Alert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert query()
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Alert whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Alert extends Model
{
    use HasFactory;
    protected $fillable=[
        "type",
        "context",
    ];
}
