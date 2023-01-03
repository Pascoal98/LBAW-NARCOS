<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy {
    
    use HandlesAuthorization;


    /**
     *  Checks if the user is able to update their account
     */

    public function update(User $user, User $model) {
        return $user->id === $model->id;
    }

    /**
     * Checks if the user can delete the account
     */
    public function delete(User $user, User $model) {
        return $user->id === $model->id;
    }

    /**
     * Check if the user can see another user's followed accounts
     */
    public function followed(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Check whether the user can report another user.
     */
    public function report(User $user, User $model)
    {
        return Auth::check();
    }

    /**
     * Check if the user can follow another account
     */
    public function follow(User $user, User $model)
    {
        return Auth::check();
    }

    /**
     * Check if the user can unfollow the account
     */
    public function unfollow(User $user, User $model)
    {
        return Auth::check();
    }

    /**
     * Checks if the account can suspend another account
     */
    public function suspendUser(User $user, User $userToSuspend)
    {
        return $user->is_admin && !$userToSuspend->is_admin;
    }

    /**
     * Checks if the account can remove the suspension of another account
     */
    public function unsuspendUser(User $user, User $userToUnsuspend)
    {
        return $user->is_admin && !$userToUnsuspend->is_admin;
    }
}