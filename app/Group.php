<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'returning',
        'returning_next_day',
    ];

    protected $dates = [
        'returning',
        'created_at',
    ];

    protected $appends = [
        'overdue',
    ];

    public static function deleteMarker(Marker $marker)
    {
        $group = $marker->group;
        $marker->delete();
        if ($group->markers->count() <= 0) {
            $group->delete();
        }
    }
    
    public function markers()
    {
        return $this->hasMany(Marker::class);
    }

    public function signedOutAt()
    {
        return 'Signed out at '.$this
            ->created_at
            ->format('h:i a');
    }

    public function returningAt()
    {
        if ($this->returning_next_day) {
            $signed_out_yesterday = Carbon::now()
                ->diffInDays($this->created_at) > 0;

            return $signed_out_yesterday
                ? $this->dependingOnTheWeekend('Back in today', 'Back in Monday')
                : $this->dependingOnTheWeekend('Back in tomorrow', 'Back in Monday');
        }

        if ($this->overdue) {
            return 'Returned at '.$this->returning->format('h:i a');
        }

        return 'Returning at '.$this->returning->format('h:i a');
    }

    public function getOverdueAttribute()
    {
        $now = Carbon::now();

        if ($this->returning_next_day) {
            $this->returning = $this->returning->addDay();
        }

        return $this->returning->isPast();
    }

    protected function dependingOnTheWeekend($option_a, $option_b)
    {
        $is_the_weekend = collect([Carbon::SATURDAY, Carbon::SUNDAY])
            ->contains(Carbon::now()->dayOfWeek);

        return !$is_the_weekend
            ? $option_a
            : $option_b;
    }
}
