<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps  = false;

    protected $table = 'post';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'published_date', 'is_edited'
    ];

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function feedback() {
        return $this->hasMany(Feedback::class);
    }

}