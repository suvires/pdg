@extends('layouts.app')

@section('content')
    <h2>Buscador de alumnos</h2>
    <form action="{{ route('buscar', ['conexion' => $conexion]) }}" method="GET">
        @csrf <!-- Token CSRF -->
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ request('nombre') }}">
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ request('apellidos') }}">
        </div>
        <div class="form-group">
            <label for="dni">DNI:</label>
            <input type="text" class="form-control" id="dni" name="dni" value="{{ request('dni') }}">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ request('email') }}">
        </div>
        <div class="form-group">
            <label for="curso">Curso:</label>
            <select class="form-control" id="curso" name="curso">
                <option value="">Todos</option>
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->idCursoMoodle }}" {{ request('curso') == $curso->idCursoMoodle ? 'selected' : '' }}>{{ $curso->NombreCurso }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
    <h2>Resultados de la búsqueda</h2>
    @if ($alumnos->isEmpty())
        <p>No se encontraron alumnos.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>IdAlumno</th>
                    <th>IdMoodle</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Dirección</th>
                    <th>CP</th>
                    <th>Población</th>
                    <th>Provincia</th>
                    <th>País</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Sexo</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Tituación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $alumno)
                    <tr>
                        <td>
                            @if($alumno->idMoodle)
                                <a href="{{ route('expediente', ['conexion' => $conexion, 'idAlumnoMoodle' => $alumno->idMoodle]) }}">Ver expediente</a>
                            @endif
                            </td>
                        <td>{{ $alumno->idAlumno }}</td>
                        <td>{{ $alumno->idMoodle }}</td>
                        <td>{{ $alumno->Nombre }}</td>
                        <td>{{ $alumno->Apellidos }}</td>
                        <td>{{ $alumno->DNI }}</td>
                        <td>{{ $alumno->Direccion }}</td>
                        <td>{{ $alumno->CP }}</td>
                        <td>{{ $alumno->Poblacion }}</td>
                        <td>{{ $alumno->Provincia }}</td>
                        <td>{{ $alumno->Pais }}</td>
                        <td>{{ $alumno->Email }}</td>
                        <td>{{ $alumno->Telefono }}</td>
                        <td>{{ $alumno->Sexo }}</td>
                        <td>{{ \Carbon\Carbon::parse($alumno->FechaNacimiento)->format('d/m/Y') }}</td>
                        <td>{{ $alumno->Titulacion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="d-flex justify-content-center">
        {{ $alumnos->links() }}
    </div>
@endsection