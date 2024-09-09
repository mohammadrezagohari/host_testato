<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Advertisement
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $video_link
 * @property string $user_id
 * @property int $paid_status
 * @property string $expire_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $User
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement wherePaidStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereVideoLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement withIndex()
 * @mixin \Eloquent
 */
class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'video_link',
        'user_id',
        'paid_status',
        'expire_at'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithIndex($query)
    {
        return $query->with(['User']);
    }
}
