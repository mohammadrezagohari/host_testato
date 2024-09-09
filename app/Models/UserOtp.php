<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as BuilderAlias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;
use PhpParser\Builder;

/**
 * App\Models\UserOtp
 *
 * @property int $id
 * @property int $user_id
 * @property string $otp
 * @property string|null $expire_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static BuilderAlias|UserOtp newModelQuery()
 * @method static BuilderAlias|UserOtp newQuery()
 * @method static BuilderAlias|UserOtp query()
 * @method static BuilderAlias|UserOtp whereCreatedAt($value)
 * @method static BuilderAlias|UserOtp whereExpireAt($value)
 * @method static BuilderAlias|UserOtp whereId($value)
 * @method static BuilderAlias|UserOtp whereOtp($value)
 * @method static BuilderAlias|UserOtp whereUpdatedAt($value)
 * @method static BuilderAlias|UserOtp whereUserId($value)
 * @property-read \App\Models\User $User
 * @property-read mixed $sms
 * @method static BuilderAlias|UserOtp notExpire()
 * @method static BuilderAlias|UserOtp checkCode()
 * @mixin \Eloquent
 */
class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'otp', 'expire_at'];
    protected $casts = [
        'otp' => 'integer'
    ];

    /***************
     * @return int
     */
    public function getSmsAttribute(): int
    {
        return $this->otp;
    }

    /******************************
     *
     *****************************/
    public function scopeNotExpire($query)
    {
        return $query->where(function ($builder) {
            $builder->where('expire_at', ">=", now()->format("Y-m-d H:i:s"));
        });
    }

    public function scopeCheckCode($query,$code)
    {
        return $query->where(fn ($builder) => $builder->where('otp', '=', $code));
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }


}
