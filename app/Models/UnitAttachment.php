<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UnitAttachment
 *
 * @property int $id
 * @property string $image_url
 * @property int $unit_Id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Unit|null $Unit
 * @method static \Illuminate\Database\Eloquent\Builder|UnitAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitAttachment whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitAttachment whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitAttachment whereUpdatedAt($value)
 * @method static \Database\Factories\UnitAttachmentFactory factory(...$parameters)
 * @mixin \Eloquent
 */
class UnitAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['image_url'];

    #region relationships
    public function Unit(): belongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    #endregion
}
