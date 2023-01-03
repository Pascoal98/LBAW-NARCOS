<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Post
{
  protected $table = 'article';

  protected $primaryKey = 'post_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title', 'thumbnail',
    ];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->join('post', 'post_id', '=', 'id');
        });
    }

    public function comments() {
      return $this->hasMany(Comment::class, 'article_id');
    }

    public function post() {
      return $this->belongsTo(Post::class);
    }

    public function articleTopics() {
      return $this->belongsToMany(Topic::class, 'article_topic', 'article_id', 'topic_id');
    }

    public function getParsedComments() {
      return $this->comments->filter(function ($comment) {
        return $comment->parent_comment_id === null;
      })->sortBy([['likes', 'desc'], ['published_date', 'desc']])
        ->map(function ($comment) {

          $commentInfo = $comment->getInfo();
          $children = $this->comments->filter(function ($comment) use($commentInfo) {
            return $comment->parent_comment_id === $commentInfo['id'];
          })->sortBy([['likes', 'desc'], ['published_date', 'desc']])
            ->map(fn ($comment) => $comment->getInfo());

          $commentInfo['children'] = $children;
          $commentInfo['hasFeedback'] = $commentInfo['hasFeedback'] || !$commentInfo['children']->isEmpty();
          return $commentInfo;
        });
    }
}