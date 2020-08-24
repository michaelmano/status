<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
