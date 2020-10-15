<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($email = false)
    {
        return 'https://www.gravatar.com/avatar/' . md5($email ?? $this->email) . '?s=100&d=mp';
    }

    public function timers()
    {
        return $this->hasMany(Timer::class);
    }

    public function timerIntervals()
    {
        return $this->hasMany(TimerInterval::class);
    }

    public function settings()
    {
        return $this->hasMany(Settings::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        $settings = [
            [
                'key' => 'timerSoundEnabled',
                'value' => true,
                'type' => 'boolean',
                'label' => 'timer'
            ],
            [
                'key' => 'timerSound',
                'value' => '/audio/magic-mallet.wav',
                'type' => 'string',
                'label' => 'timer'
            ],
            [
              'key' => 'showNotifications',
              'value' => true,
              'type' => 'boolean',
              'label' => 'timer'
          ]
        ];

        $timers = [
            [
                'order' => 0,
                'name' => 'Pomodoro',
                'duration' => 1500
            ],
            [
                'order' => 1,
                'name' => 'Short break',
                'duration' => 300
            ],
            [
                'order' => 2,
                'name' => 'Long break',
                'duration' => 900
            ]
        ];

        static::created(function ($user) use ($settings, $timers) {
                $user->settings()->createMany($settings);

                $user->timers()->createMany($timers);
        });
    }
}
