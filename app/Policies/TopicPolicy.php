<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Check whether the user can accept a topic.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function accept(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Check whether the user can reject a topic.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reject(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Check whether the user can add a topic to its favorites
     */
    public function addFavorite(User $user)
    {
        return Auth::check();
    }

    /**
     * Check whether the user can add a topic to its favorites
     */
    public function removeFavorite(User $user)
    {
        return Auth::check();
    }

    public function destroy(User $user)
    {
        return $user->is_admin;
    }

    public function propose(User $user)
    {
        return Auth::check();
    }
}