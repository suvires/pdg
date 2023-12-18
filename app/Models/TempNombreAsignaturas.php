<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempNombreAsignaturas extends Model
{
    use HasFactory;

    protected $table = 'tempnombreasignaturas';
    protected $fillable = ['idNombreAsignatura', 'idCurso', 'idBloque'];

    // Relaciones con otros modelos
    // Por ejemplo, si este modelo se relaciona con Notas, puedes definir la relación aquí
}
