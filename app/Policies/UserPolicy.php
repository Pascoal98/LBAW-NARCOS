<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy {
    
    use HandlesAuthorization;



    public function update(User $user, User $model) {
        return $user->id === $model->id;
    }


    public function delete(User $user, User $model) {
        return $user->id === $model->id;
    }

    public function followed(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    
    public function follow(User $user, User $model)
    {
        return Auth::check();
    }


    public function unfollow(User $user, User $model)
    {
        return Auth::check();
    }
}