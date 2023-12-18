<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnosMoodle extends Model
{
    use HasFactory;

    protected $table = 'alumnosmoodle'; // Nombre de la tabla en la base de datos
    protected $fillable = ['Nombre', 'Apellidos', 'DNI', 'Email']; // Campos asignables en masa


    // Define aquí las relaciones con otras tablas si las hay
}
