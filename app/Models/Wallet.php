<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Wallet
 *
 * @method static Builder|Wallet newModelQuery()
 * @method static Builder|Wallet newQuery()
 * @method static Builder|Wallet query()
 * @property int $id
 * @property float $amount
 * @property float $bonus
 * @property int $has_credit
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $User
 * @method static Builder|Wallet whereAmount($value)
 * @method static Builder|Wallet whereBonus($value)
 * @method static Builder|Wallet whereCreatedAt($value)
 * @method static Builder|Wallet whereHasCredit($value)
 * @method static Builder|Wallet whereId($value)
 * @method static Builder|Wallet whereUpdatedAt($value)
 * @method static Builder|Wallet whereUserId($value)
 * @method static Builder|Wallet withIndex()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WalletHistory[] $WalletHistories
 * @property-read int|null $wallet_histories_count
 * @mixin Eloquent
 */
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'bonus',
        'has_credit',
        'user_id'
    ];
    #region Relationships
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function WalletHistories(): HasMany
    {
        return $this->hasMany(WalletHistory::class);
    }
    #endregion

    #region scope
    public function scopeWithIndex($query)
    {
        return $query->with(['user']);
    }



    #endregion
}
