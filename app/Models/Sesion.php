<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $fillable = ['pantalla_id', 'pelicula_id','fecha', 'hora'];

    public function pantalla(){
        return $this->belongsTo(Pantalla::class);
    }

    public function pelicula(){
        return $this->belongsTo(Pelicula::class);
    }
}
