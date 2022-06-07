<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string|null $password
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post wherePassword($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post whereUserId($value)
 * @mixin Eloquent
 * @property int $board_id
 * @method static Builder|Post whereBoardId($value)
 * @property int $recommend
 * @property int $view
 * @method static Builder|Post whereRecommend($value)
 * @method static Builder|Post whereView($value)
 */
class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    public function getBoard()
    {
        return Board::find($this->board_id);
    }

    public function getUser()
    {
        return User::find($this->user_id);
    }

    public function getComments(): Collection
    {
        return Comment::wherePostId($this->id)->get();
    }

    public function getCommentsCount(): int
    {
        return Comment::wherePostId($this->id)->count();
    }

    public function increaseView(): void
    {
        $this->view++;
        $this->save();
    }

    public function getRecommendsCount(): int
    {
        return Recommend::wherePostId($this->id)->count();
    }


    public function getSimpleCreatedAt(): string
    {
        $now = Carbon::now();
        $target = $this->created_at;
        if ($now->year == $target->year &&
            $now->month == $target->month &&
            $now->day == $target->day) {
            return $this->created_at->format('H:i');
        } else {
            return $this->created_at->format('m-d');
        }
    }

    public function getBoardNumber(): int
    {
        return Post::whereBoardId($this->board_id)->where('id', '<=', $this->id)->count();
    }
}
