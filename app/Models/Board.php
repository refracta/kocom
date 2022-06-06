<?php

namespace App\Models;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Board newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Board newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Board query()
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereUserOnly($value)
 * @mixin \Eloquent
 */
class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';
    protected $primaryKey = 'id';

    public static function getAllBoard(): Board
    {
        $allBoard = new Board;
        $allBoard->name = 'all';
        $allBoard->alias = '전체';
        return $allBoard;
    }

    public static function getBoardByName($name): Board
    {
        return $name == 'all' ? Board::getAllBoard() : Board::whereName($name)->first();
    }

    public function getPost($number): Post
    {
        if($this->name == 'all'){
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
