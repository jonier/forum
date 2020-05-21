<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $table = 'forums';
    /* 
        Con $fillable, diremos que campos podran ser insertados, de esta manera evitaremos las asignaciones masivas,
        en la cual podrian haver inyecciones.

        Si en cambio de $fillable usamos "protected $garded = [];" $garded permitira guardar en todos los campos de la tabla
    */
    protected $fillable = ['name', 'description'];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function replies() {
        return $this->hasManyThrough(Reply::class, Post::class);
    }
}
