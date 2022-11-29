<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Post
{
  protected $table = 'comment';

  protected $primaryKey = 'post_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public static function boot()
    {
        parent::boot();

        // All the queries are joined with the post table
        static::addGlobalScope(function ($query) {
            $query->join('post', 'post_id', '=', 'id');
        });
    }

    public function article() {
      return $this->belongsTo(Article::class, 'article_id');
    }

    public function post() {
      return $this->belongsTo(Content::class);
    }

    public function parent_comment() {
      return $this->belongsTo(Comment::class, 'parent_comment_id');
    } 

    public function child_comments() {
      return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function getInfo() {
      $published_date = date('F j, Y', strtotime( $this['published_date'] ) ) ;
      $isAuthor = isset($this->author) ? $this->author->id === Auth::id() : false;

      $feedback = Auth::check()
        ? Auth::user()->feedback->where('post_id', '=', $this['id'])->first()
        : null;

      $liked = false;
      $disliked = false;

      if (!is_null($feedback)) {
        $liked = $feedback['is_like'];
        $disliked = !$feedback['is_like'];
      }

      return [
          'id' => $this->post_id, 
          'body' => $this->body,
          'likes' => $this->likes,
          'dislikes' => $this->dislikes,
          'published_date' => $published_date,
          'article_id' => $this->article_id,
          'is_edited' => $this->is_edited,
          'liked' => $liked,
          'disliked' => $disliked,
          'isAuthor' => $isAuthor,
          'hasFeedback' => $this['likes'] != 0 || $this['dislikes'] != 0,
          'author' => isset($this->author) ? [
              'id' => $this->author->id,
              'name' => $this->author->name,
              'avatar' => $this->author->avatar,
          ] : null,
      ];
    }
}