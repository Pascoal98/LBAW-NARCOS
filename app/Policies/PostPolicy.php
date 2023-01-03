<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Check if the user can create a post
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Check if the user can update the post
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->author()->first()->id;
    }

    /**
     * Check if the user can delete the post
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->author()->first()->id || $user->is_admin;
    }

    /**
     * Check if the user can update the feedback
     */
    public function updateFeedback(User $user, Post $post)
    {
        if (!Auth::check()) return false;
        if (!isset($post->author)) return true;

        return $user->id !== $post->author->id;
    }

}