<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    
    public function create(User $user)
    {
        return Auth::check();
    }

    
    public function update(User $user, Post $post)
    {
        return $user->id === $post->author()->first()->id;
    }

    
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->author()->first()->id || $user->is_admin;
    }

    
    public function updateFeedback(User $user, Post $post)
    {
        if (!Auth::check()) return false;
        if (!isset($post->author)) return true;

        return $user->id !== $post->author->id;
    }

}