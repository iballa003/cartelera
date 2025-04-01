<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = ['titulo', 'cartel_url','es_3d','fecha_inicio','fecha_fin','observaciones'];

    public function sesiones(){
        return $this->hasMany(Sesion::class);
    }

    public function pantallas(){
        return $this->hasManyThrough(Pantalla::class, Sesion::class, 'pelicula_id', 'id', 'id', 'pantalla_id');
    }
}
