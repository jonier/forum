<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['forum_id', 'user_id', 'title', 'description'];

    protected static function boot() {
        parent::boot();

        static::creating(function($post) {
            $post->user_id = auth()->id;
        });
    }

    public function forum() {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }
}
