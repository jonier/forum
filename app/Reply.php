<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = "replies";

    protected $fillable = ['user_id', 'post_id', 'reply'];

    /*
        Para agregar atributos extras se usa la propiedad $appends. 
        En este caso queremos traer el nombre del foro
    */
    protected $appends = ['forum'];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getForumAttribute() {
        return $this->post->forum;
    }
}
