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
    public function index($conexion)
    {
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        $alumnosMoodle = new AlumnosMoodle();
        $alumnosMoodle->setConnection('mysql_'.$conexion);
        $query = $alumnosMoodle->newQuery();
        $query->orderBy('idMoodle', 'desc');
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
        AlumnosMoodle::setConnection('mysql_'.$conexion);
        $query = AlumnosMoodle::query();

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

            $query->join('cursosnotas', 'alumnosmoodle.idMoodle', '=', 'cursosnotas.idAlumnoMoodle')
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

        TempNombreCursos::setConnection('mysql_'.$conexion);
        $cursos = TempNombreCursos::orderBy('NombreCurso', 'asc')->get();

        return view('busqueda', compact('alumnos', 'cursos'));
    }

    public function expediente($conexion, $idAlumnoMoodle)
    {
        AlumnosMoodle::setConnection('mysql_'.$conexion);
        $query = AlumnosMoodle::query();
        $query->where('idMoodle', $idAlumnoMoodle);
        $sql = $query->toSql();
        // echo '<pre>'.$sql.'</pre>';

        // $bindings = $query->getBindings();
        // echo '<pre>'; print_r($bindings); echo '</pre>';

        $alumno = $query->first();
        // echo '<pre>'; print_r($alumno); echo '</pre>';

        CursosNotas::setConnection('mysql_'.$conexion);
        $query = CursosNotas::where('idAlumnoMoodle', $idAlumnoMoodle);
        // $sql = $query->toSql();
        // echo '<pre>'.$sql.'</pre>';

        // $bindings = $query->getBindings();
        // echo '<pre>'; print_r($bindings); echo '</pre>';

        $programas = $query->get();
        foreach ($programas as $key => $value) {
            TempNombreCursos::setConnection('mysql_'.$conexion);
            $curso = TempNombreCursos::where('idCursoMoodle', $value->idCursoMoodle)->first();
            $programas[$key]->NombreCurso = $curso->NombreCurso;

            Notas::setConnection('mysql_'.$conexion);
            $query = Notas::join('tempnombreasignaturas', 'notas.idBloque', '=', 'tempnombreasignaturas.idBloque')
            ->join('cursosnotas', 'notas.idCurso', '=', 'cursosnotas.idCurso')
            ->where('notas.idCursoMoodle', $programas[$key]->idCursoMoodle)
            ->where('cursosnotas.idAlumnoMoodle', $alumno->idMoodle)
            ->select('notas.*', 'tempnombreasignaturas.NombreAsignatura');

            // $sql = $query->toSql();
            // echo '<pre>'.$sql.'</pre>';

            // $bindings = $query->getBindings();
            // echo '<pre>'; print_r($bindings); echo '</pre>';

            $programas[$key]->asignaturas = $query->get();
        }

        return view('expediente', compact('alumno', 'programas'));
    }
}
