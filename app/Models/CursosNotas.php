<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursosNotas extends Model
{
    use HasFactory;

    protected $table = 'cursosnotas';
    protected $fillable = ['idCurso', 'idAlumnoMoodle', 'Media', 'Finalizado', 'FechaInicio', 'FechaFin', 'FechaFinReal', 'Homologado', 'Observaciones', 'NumProrroga'];

    // Relaciones con otros modelos
    // public function alumnoMoodle()
    // {
    //     return $this->belongsTo(AlumnosMoodle::class, 'idAlumnoMoodle');
    // }

    // public function nombreCurso()
    // {
    //     return $this->belongsTo(TempNombreCursos::class, 'idCurso');
    // }
}
