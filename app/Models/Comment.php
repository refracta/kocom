<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int $reply
 * @property string $comment
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $password
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereComment($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment wherePassword($value)
 * @method static Builder|Comment wherePostId($value)
 * @method static Builder|Comment whereReply($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUserId($value)
 * @mixin Eloquent
 * @property string $content
 * @method static Builder|Comment whereContent($value)
 * @property int $deleted
 * @method static Builder|Comment whereDeleted($value)
 */
class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;
    public int $level = 0;
    protected $table = 'comments';

    public function getUser()
    {
        return User::find($this->user_id);
    }
}
