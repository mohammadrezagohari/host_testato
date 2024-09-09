<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\WalletHistory
 *
 * @property int $id
 * @property int $wallet_id
 * @property int $amount
 * @property string $status
 * @property int $is_expired
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Wallet|null $Wallet
 * @method static Builder|WalletHistory newModelQuery()
 * @method static Builder|WalletHistory newQuery()
 * @method static Builder|WalletHistory query()
 * @method static Builder|WalletHistory whereAmout($value)
 * @method static Builder|WalletHistory whereCreatedAt($value)
 * @method static Builder|WalletHistory whereId($value)
 * @method static Builder|WalletHistory whereIsExpired($value)
 * @method static Builder|WalletHistory whereStatus($value)
 * @method static Builder|WalletHistory whereUpdatedAt($value)
 * @method static Builder|WalletHistory whereWalletId($value)
 * @property int|null $bonus
 * @method static Builder|WalletHistory whereAmount($value)
 * @method static Builder|WalletHistory whereBonus($value)
 * @property int $base_price_coin
 * @method static Builder|WalletHistory whereBasePriceCoin($value)
 * @property string|null $type
 * @method static Builder|WalletHistory whereType($value)
 * @mixin Eloquent
 */
class WalletHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'amount',
        'bonus',
        'base_price_coin',
        'type',
    ];

    public function Wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
