<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Recommend
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Recommend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommend query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recommend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommend wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recommend whereUserId($value)
 * @mixin \Eloquent
 */
class Recommend extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'recommends';

    public static function isRecommended($user_id, $post_id): bool
    {
        return Recommend::whereUserId($user_id)->wherePostId($post_id)->exists();
    }
}
