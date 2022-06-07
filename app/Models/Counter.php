<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Counter
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Counter newModelQuery()
 * @method static Builder|Counter newQuery()
 * @method static Builder|Counter query()
 * @method static Builder|Counter whereCreatedAt($value)
 * @method static Builder|Counter whereId($value)
 * @method static Builder|Counter whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Counter extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'counters';

    public static function increaseAndGet(): Counter
    {
        $now = Carbon::now();
        $now->setHours(0);
        $now->setMinutes(0);
        $now->setSeconds(0);
        $counter = Counter::where('date', '=', $now)->first();
        if ($counter == null) {
            $counter = new Counter;
            $counter->date = $now;
            $counter->count = 1;
        } else {
            $counter->count++;
        }
        $counter->save();
        return $counter;
    }

    public static function getFullCount(): int
    {
        return Counter::all()->sum('count');
    }
}
