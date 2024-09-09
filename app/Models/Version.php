<?php

namespace App\Models;

use App\Enums\VersionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Version
 *
 * @property int $id
 * @property int $version_base
 * @property string $version_name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Version newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Version newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Version query()
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereIsApp()
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereIsData()
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereVersionBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereVersionName($value)
 * @property string|null $application_file
 * @method static \Illuminate\Database\Eloquent\Builder|Version whereApplicationFile($value)
 * @mixin \Eloquent
 */
class Version extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_base',
        'version_name',
        'type',
        'application_file'
    ];


    public function scopeWhereIsApp($query)
    {
        return $query->where('type', '=', VersionType::APP);
    }

    public function scopeWhereIsData($query)
    {
        return $query->where('type', '=', VersionType::DATA);
    }
}
