<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Board
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $type
 * @property int $user_only
 * @method static Builder|Board newModelQuery()
 * @method static Builder|Board newQuery()
 * @method static Builder|Board query()
 * @method static Builder|Board whereAlias($value)
 * @method static Builder|Board whereId($value)
 * @method static Builder|Board whereName($value)
 * @method static Builder|Board whereType($value)
 * @method static Builder|Board whereUserOnly($value)
 * @mixin Eloquent
 */
class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';
    protected $primaryKey = 'id';

    public static function getBoardByName($name): Board
    {
        return $name == 'all' ? Board::getAllBoard() : Board::whereName($name)->first();
    }

    public static function getAllBoard(): Board
    {
        $allBoard = new Board;
        $allBoard->name = 'all';
        $allBoard->alias = '전체';
        return $allBoard;
    }

    public function getPost($number): Post
    {
        if ($this->name == 'all') {
            return Post::orderBy('id')->skip($number - 1)->first();
        } else {
            return Post::whereBoardId($this->id)->orderBy('id')->skip($number - 1)->first();
        }
    }


    public function isAllBoard(): bool
    {
        return $this->name == 'all';
    }
}
