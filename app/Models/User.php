<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use  HasFactory;

    public $timestamps  = false;

    protected $table = 'authenticated_user';

    /**
     * The attributes that are mass assignable.

     */
    protected $fillable = [
        'username', 'email', 'password', 'date_of_birth',
        'avatar',
    ];


    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follow', 'follower_id', 'followed_id');
    }

    public function suspensions()
    {
        return $this->hasMany(Suspension::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_id');
    }

    public function givenReports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function proposedTopics()
    {
        return $this->hasMany(Topic::class, 'user_id');
    }


    public function post()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function favoriteTopics()
    {
        return $this->belongsToMany(Topic::class, 'topic_follow', 'user_id');
    }

    public function articles()
    {
        return Article::where('author_id', $this->id)->get();
    }

    public function comments()
    {
        return Comment::where('author_id', $this->id)->get();
    }

    public function isFollowing($userId)
    {
        $followList = $this->following->where('id', $userId);
        return count($followList) > 0;
    }

    public function suspensionEndInfo()
    {
        $suspension = $this->suspensions->sortByDesc('end_time')->first();
        if (!isset($suspension)) return null;

        return [
            'reason' => $suspension->reason,
            'end_date' => gmdate('d-m-Y', strtotime($suspension->end_time)),
        ];
    }
}