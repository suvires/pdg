<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempNombreCursos extends Model
{
    use HasFactory;

    protected $table = 'tempnombrecursos';
    protected $fillable = ['idNombreCurso', 'NombreCurso'];

    // Relaciones con otros modelos
    // Por ejemplo, si este modelo se relaciona con CursosNotas, puedes definir la relación aquí
}
