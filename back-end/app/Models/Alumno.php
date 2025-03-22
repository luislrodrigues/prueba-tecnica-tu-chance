<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends Model
{
    use HasFactory,SoftDeletes;

    protected $table ='alumnos';

    protected $fillable = [
        'id',
        'nombre', 
        'fecha_nacimiento', 
        'nombre_padre', 
        'nombre_madre',
        'grado_id',
        'seccion',
        'fecha_ingreso',
        'estado'
    ];

    public function grado(){
        return $this->belongsTo(Grado::class);
    }
}
