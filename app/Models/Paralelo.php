<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Paralelo extends Model
{
    //Habilitar el guardado
    use HasFactory;
    //enseñarle o mostrale como esta estructurada
    protected $fillable = ['nombre'];
    //Enseñarle coomo esta relacionada
    public function estudiante(){
        return $this ->hasMany(Estudiante::class);
    }
}
