<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $title
 * @property int $priority_order
 * @property string $file_url
 * @property string|null $mime_type
 * @property string $file_size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider wherePriorityOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Database\Factories\SliderFactory factory(...$parameters)
 * @mixin \Eloquent
 */
class Slider extends Model
{
    use HasFactory;
    protected $fillable= [
        'title',
        'priority_order',
        'file_url',
        'mime_type',
        'file_size',
    ];


}
