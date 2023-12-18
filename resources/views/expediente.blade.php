@extends('layouts.app')

@section('content')
    @if (!$alumno)
        <h2>Error</h2>
        <p>No se encontró al alumno.</p>
    @else
        <h2>Expediente de {{ $alumno->Nombre }} {{ $alumno->Apellidos }}</h2>
        <p>{{ $alumno->Email }}</p>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-6">Id Alumno</dt>
                        <dd class="col-sm-6">{{ $alumno->idAlumno }}</dd>
                        <dt class="col-sm-6">Id Moodle</dt>
                        <dd class="col-sm-6">{{ $alumno->idMoodle }}</dd>
                        <dt class="col-sm-6">Nombre</dt>
                        <dd class="col-sm-6">{{ $alumno->Nombre }}</dd>
                        <dt class="col-sm-6">Apellidos</dt>
                        <dd class="col-sm-6">{{ $alumno->Apellidos }}</dd>
                        <dt class="col-sm-6">DNI</dt>
                        <dd class="col-sm-6">{{ $alumno->DNI }}</dd>
                    </dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-6">Dirección</dt>
                        <dd class="col-sm-6">{{ $alumno->Direccion }}</dd>
                        <dt class="col-sm-6">CP</dt>
                        <dd class="col-sm-6">{{ $alumno->CP }}</dd>
                        <dt class="col-sm-6">Población</dt>
                        <dd class="col-sm-6">{{ $alumno->Poblacion }}</dd>
                        <dt class="col-sm-6">Provincia</dt>
                        <dd class="col-sm-6">{{ $alumno->Provincia }}</dd>
                        <dt class="col-sm-6">País</dt>
                        <dd class="col-sm-6">{{ $alumno->Pais }}</dd></dl>
                </div>
                <div class="col-md-4">
                    <dl class="row">
                        <dt class="col-sm-6">Teléfono</dt>
                        <dd class="col-sm-6">{{ $alumno->Telefono }}</dd>
                        <dt class="col-sm-6">Sexo</dt>
                        <dd class="col-sm-6">{{ $alumno->Sexo }}</dd>
                        <dt class="col-sm-6">Fecha de Nacimiento</dt>
                        <dd class="col-sm-6">{{ \Carbon\Carbon::parse($alumno->FechaNacimiento)->format('d/m/Y') }}</dd>
                        <dt class="col-sm-6">Titulación</dt>
                        <dd class="col-sm-6 text-truncate">{{ $alumno->Titulacion }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @foreach ($programas as $programa)
                <h3>{{ $programa->NombreCurso }}</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id Curso</th>
                            <th>Id Curso Moodle</th>
                            <th>Nombre Curso</th>
                            <th>Nota media</th>
                            <th>Finalizado</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Prórrogas</th>
                            <th>Homologado</th>
                            <th>Fecha real de fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $programa->idCurso }}</td>
                            <td>{{ $programa->idCursoMoodle }}</td>
                            <td>{{ $programa->NombreCurso }}</td>
                            <td>{{ $programa->Media }}</td>
                            <td>{{ $programa->Finalizado }}</td>
                            <td>{{ \Carbon\Carbon::parse($programa->FechaInicio)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($programa->FechaFin)->format('d/m/Y') }}</td>
                            <td>{{ $programa->NumProrroga }}</td>
                            <td>{{ $programa->Homologado }}</td>
                            <td>{{ \Carbon\Carbon::parse($programa->FechaFinReal)->format('d/m/Y') }}</td>
                        </tr>
                    </tbody>
                </table>
                @if(count($programa->asignaturas))
                <h4>Asignaturas</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>IdNota</th>
                            <th>IdCurso</th>
                            <th>IdCursoMoodle</th>
                            <th>IdBloque</th>
                            <th>Nombre</th>
                            <th>Convocatoria</th>
                            <th>Convalidada</th>
                            <th>Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programa->asignaturas as $asignatura)
                            <tr>
                                <td>{{ $asignatura->idNota }}</td>
                                <td>{{ $asignatura->idCurso }}</td>
                                <td>{{ $asignatura->idCursoMoodle }}</td>
                                <td>{{ $asignatura->idBloque }}</td>
                                <td>{{ $asignatura->NombreAsignatura }}</td>
                                <td>{{ $asignatura->Convocatoria }}</td>
                                <td>{{ $asignatura->Convalidada }}</td>
                                <td>{{ $asignatura->Nota }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <p>No ha cursado ninguna asignatura.</p>
                @endif
                @if ($programa->Observaciones)
                    <h4>Observaciones</h4>
                    <p>{{ $programa->Observaciones }}</p>
                @endif
            @endforeach
        </div>
    @endif
@endsection