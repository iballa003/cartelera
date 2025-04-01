<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pantalla extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'orientacion','modo'];

    public function sesiones(){
        return $this->hasMany(Sesion::class);
    }

    public function peliculas(){
        return $this->hasManyThrough(Pelicula::class, Sesion::class, 'pantalla_id', 'id', 'id', 'pelicula_id');
    }
}
