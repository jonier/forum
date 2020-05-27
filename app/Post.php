<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['forum_id', 'user_id', 'title', 'description', 'attachment', 'slug'];

        /*
        Con slug podremos usar este campo para las rutas en vez de usar el id del registro. 
        Ahora lo aremos con el nombre del foro y del post no con el id.
     */
    public function getRouteKeyName() {
        return 'slug';
    }

    protected static function boot() {
        parent::boot();

        static::creating(function($post) {
            if( ! App::runningInConsole() ) {
                $post->user_id = auth()->id();
                $post->slug = str_slug($post->title, "-");
            }
        });

        static::deleting(function($post){
            if( ! App::runningInConsole() ) {
                if($post->replies()->count()){
                    foreach ($post->replies as $reply) {
                        if($reply->attachment){
                            Storage::delete('replies/' . $reply->attachment);
                        }
                    }
                    $post->replies()->delete();
                }

                if($post->attachment) {
                    Storage::delete('posts/' . $post->attachment);
                }
            }
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

    public function isOwner() {
        return $this->owner->id === auth()->id();
    }

    ///images/{path}/{attachment}
    public function pathAttachment() {
        $array_attachment = explode("://", $this->attachment);
        if(is_array($array_attachment) && $array_attachment[0] == "https"){
            return $this->attachment;
        }else{
            return "/images/posts/" . $this->attachment;
        }
    }
}
