<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/{conexion}/expediente/{idAlumnoMoodle}', [AlumnoController::class, 'expediente'])->name('expediente');
Route::get('/{conexion}/busqueda', [AlumnoController::class, 'buscar'])->name('buscar');
Route::get('/{conexion}', [AlumnoController::class, 'index'])->name('index');
Route::get('/', [AlumnoController::class, 'select']);
