<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notas extends Model
{
    use HasFactory;

    protected $table = 'notas';
    protected $fillable = ['Convocatoria', 'Convalidada', 'Nota'];

    // Relación con TempNombreCursos
    // public function nombreCurso()
    // {
    //     return $this->belongsTo(TempNombreCursos::class, 'idCurso');
    // }

    // // Relación con TempNombreAsignaturas
    // public function nombreAsignatura()
    // {
    //     return $this->belongsTo(TempNombreAsignaturas::class, 'idBloque');
    // }
}
