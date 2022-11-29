<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public $timestamps  = false;

    protected $table = 'topic';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function areasExpertise()
    {
        return $this->belongsToMany(User::class, 'area_of_expertise')->withPivot('reputation');
    }

    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_topic');
    }

    public function articleTopics()
    {
        return $this->belongsToMany(Article::class, 'article_topic', 'topic_id', 'article_id');
    }

    public static function listTagsByState($topic_state)
    {
        return Tag::where('state', $topic_state)
            ->orderBy('name', 'asc')->get();
    }

    public function isFavorite($user_id)
    {
        $favoriteList = $this->favoriteUsers->where('id', $user_id);
        return count($favoriteList) > 0;
    }
}