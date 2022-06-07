<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Recommend
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @method static Builder|Recommend newModelQuery()
 * @method static Builder|Recommend newQuery()
 * @method static Builder|Recommend query()
 * @method static Builder|Recommend whereId($value)
 * @method static Builder|Recommend wherePostId($value)
 * @method static Builder|Recommend whereUserId($value)
 * @mixin Eloquent
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
