<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Forum extends Model
{
    protected $table = 'forums';
    /* 
        Con $fillable, diremos que campos podran ser insertados, de esta manera evitaremos las asignaciones masivas,
        en la cual podrian haver inyecciones.

        Si en cambio de $fillable usamos "protected $garded = [];" $garded permitira guardar en todos los campos de la tabla
    */
    protected $fillable = ['name', 'description', 'slug'];

    /*
        Con slug podremos usar este campo para las rutas en vez de usar el id del registro. 
        Ahora lo aremos con el nombre del foro y del post no con el id.
     */
    public function getRouteKeyName() {
        return 'slug';
    }

    protected static function boot() {
        parent::boot();

        static::creating(function($forum) {
            if( ! App::runningInConsole() ) {
                $forum->slug = str_slug($forum->name, "-");
            }
        });
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function replies() {
        return $this->hasManyThrough(Reply::class, Post::class);
    }
}
