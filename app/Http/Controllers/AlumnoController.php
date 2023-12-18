<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumnosMoodle;
use App\Models\TempNombreCursos;
use App\Models\CursosNotas;
use App\Models\Notas;
use Illuminate\Pagination\Paginator;

class AlumnoController extends Controller
{

    public function select()
    {
        $conexion = "";
        return view('select', compact('conexion'));
    }
    public function index($conexion)
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        $alumnosMoodle = new AlumnosMoodle();
        $alumnosMoodle->setConnection('mysql_'.$conexion);
        $query = $alumnosMoodle->newQuery();
        $query->orderBy('idAlumno', 'desc');
        $sql = $query->toSql();
        // echo '<pre>'.$sql.'</pre>';

        $alumnos = $query->paginate(10);

        $tempNombreCursos = new TempNombreCursos();
        $tempNombreCursos->setConnection('mysql_'.$conexion);
        $cursos = $tempNombreCursos->orderBy('NombreCurso', 'asc')->get();
        return view('busqueda', compact('alumnos', 'cursos', 'conexion'));
    }

    public function buscar($conexion, Request $request)
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        $alumnosMoodle = new AlumnosMoodle();
        $alumnosMoodle->setConnection('mysql_'.$conexion);
        $query = $alumnosMoodle->newQuery();

        // Filtrar por nombre, apellidos, DNI y email si se proporcionan
        if ($request->filled('nombre')) {
            $query->where('Nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->filled('apellidos')) {
            $query->where('Apellidos', 'like', '%' . $request->apellidos . '%');
        }
        if ($request->filled('dni')) {
            $query->where('DNI', 'like', '%' . $request->dni . '%');
        }
        if ($request->filled('email')) {
            $query->where('Email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('curso')) {
            $idCursoMoodle = $request->curso; // Obtenemos el idCursoMoodle del request

            $query->join('cursosnotas', 'alumnosmoodle.idAlumno', '=', 'cursosnotas.idAlumno')
                  ->where('cursosnotas.idCursoMoodle', $idCursoMoodle);
        }

        $query->orderBy('alumnosmoodle.idAlumno', 'ASC');


        $sql = $query->toSql();
        // echo '<pre>'.$sql.'</pre>';

        // $bindings = $query->getBindings();
        // echo '<pre>'; print_r($bindings); echo '</pre>';

        // Recuperar los parámetros de búsqueda
        $searchParams = $request->only('nombre', 'apellidos', 'dni', 'email', 'curso');

        // Obtener los resultados paginados y añadir los parámetros de búsqueda
        $alumnos = $query->paginate(10)->appends($searchParams);
        $sql = $query->toSql();
        // echo '<pre>'.$sql.'</pre>';

        $tempNombreCursos = new TempNombreCursos();
        $tempNombreCursos->setConnection('mysql_'.$conexion);
        $query = $tempNombreCursos->newQuery();
        $query->orderBy('NombreCurso', 'asc');
        $cursos = $query->get();

        return view('busqueda', compact('alumnos', 'cursos', 'conexion'));
    }

    public function expediente($conexion, $idAlumno)
    {
        $alumno = new AlumnosMoodle();
        $alumno->setConnection('mysql_'.$conexion);
        $query = $alumno->newQuery();
        $query->where('idAlumno', $idAlumno);
        $sql = $query->toSql();
        // echo '<pre>'.$sql.'</pre>';

        // $bindings = $query->getBindings();
        // echo '<pre>'; print_r($bindings); echo '</pre>';

        $alumno = $query->first();
        // echo '<pre>'; print_r($alumno); echo '</pre>';

        $cursosNotas = new CursosNotas();
        $cursosNotas->setConnection('mysql_'.$conexion);
        $query = $cursosNotas->newQuery();
        $query->where('idAlumno', $idAlumno);
        // $sql = $query->toSql();
        // echo '<pre>'.$sql.'</pre>';

        // $bindings = $query->getBindings();
        // echo '<pre>'; print_r($bindings); echo '</pre>';

        $programas = $query->get();
        foreach ($programas as $key => $value) {
            $tempNombreCursos = new TempNombreCursos();
            $tempNombreCursos->setConnection('mysql_'.$conexion);
            $query = $tempNombreCursos->newQuery();
            $curso = $query->where('idCursoMoodle', $value->idCursoMoodle)->first();
            $programas[$key]->NombreCurso = $curso->NombreCurso;

            $notas = new Notas();
            $notas->setConnection('mysql_'.$conexion);
            $query = $notas->newQuery();
            $query->join('tempnombreasignaturas', 'notas.idBloque', '=', 'tempnombreasignaturas.idBloque')
            ->join('cursosnotas', 'notas.idCurso', '=', 'cursosnotas.idCurso')
            ->where('notas.idCursoMoodle', $programas[$key]->idCursoMoodle)
            ->where('cursosnotas.idAlumno', $alumno->idAlumno)
            ->select('notas.*', 'tempnombreasignaturas.NombreAsignatura');

            // $sql = $query->toSql();
            // echo '<pre>'.$sql.'</pre>';

            // $bindings = $query->getBindings();
            // echo '<pre>'; print_r($bindings); echo '</pre>';

            $programas[$key]->asignaturas = $query->get();
        }

        return view('expediente', compact('alumno', 'programas', 'conexion'));
    }
}
