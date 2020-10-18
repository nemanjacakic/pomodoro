<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimerInterval extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'timer_id', 'title', 'duration'
    ];

    public function timer()
    {
        return $this->belongsTo(Timer::class);
    }
}
