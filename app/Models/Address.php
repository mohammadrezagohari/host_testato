<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property string|null $details
 * @property string|null $lat
 * @property string|null $lon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $Address
 * @property-read int|null $address_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $User
 * @property-read int|null $user_count
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    #region Relationship
    public function User(): HasMany
    {
        return $this->HasMany(User::class);
    }
    #endregion
}
