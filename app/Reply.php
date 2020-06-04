<?php

namespace App;

use App\Notifications\NewReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class Reply extends Model
{
    protected $table = "replies";

    protected $fillable = ['user_id', 'post_id', 'reply', 'attachment'];

    /*
        Para agregar atributos extras se usa la propiedad $appends. 
        En este caso queremos traer el nombre del foro
    */
    protected $appends = ['forum'];

    protected static function boot() {
        parent::boot();

        static::creating(function($reply) {
            if( ! App::runningInConsole() ) {
                $reply->user_id = auth()->id();
                self::notifyPostOwner($reply);
            }
        });

        static::deleting(function($reply){
            if( ! App::runningInConsole() ) {
                if($reply->attachment) {
                    Storage::delete('replies/' . $reply->attachment);
                }
            }
        });
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getForumAttribute() {
        return $this->post->forum;
    }

    public function isAuthor() {
        return $this->author->id === auth()->id();
    }

    public function pathAttachment() {
        $array_attachment = explode("://", $this->attachment);
        if(is_array($array_attachment) && $array_attachment[0] == "https"){
            return $this->attachment;
        }else{
            return "/images/replies/" . $this->attachment;
        }
    }

    public static function notifyPostOwner($reply) {
        $reply->post->owner->notify(new NewReply($reply));
    }
}
