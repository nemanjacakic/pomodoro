<?php

namespace App\Policies;

use App\Models\Timer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Timer  $timer
     * @return mixed
     */
    public function access(User $user, Timer $timer)
    {
        return $user->id === $timer->user_id;
    }
}
