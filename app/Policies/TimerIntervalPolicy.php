<?php

namespace App\Policies;

use App\Models\TimerInterval;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimerIntervalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TimerInterval  $timerInterval
     * @return mixed
     */
    public function access(User $user, TimerInterval $timerInterval)
    {
        return $user->id === $timerInterval->user_id;
    }
}
