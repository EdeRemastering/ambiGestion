@extends('layouts.app')

@section('titulo', 'Programación')

@section('contenido')

@section('estados')
<div class="acciones">
@if(Auth::user()->role->name == 'admin' || Auth::user()->role->name == 'instructor_lider' )

<!-- Enlace para crear una nueva programación -->
<a href="{{ route('programaciones.create') }}" class="btn boton-crear btn-success">Crear Programación</a>
@endif
<a href="{{ route('programaciones.pdf') }}" class="btn boton-crear btn-success" target="_blank">PDF</a>

</div>
@endsection

<!-- Tabla de programación -->
<table id="programacionesTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Ficha</th>
            <th>Ambiente</th>
            <th>Instructor Asignante</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($programaciones as $programacion)
        <tr>
            <td>{{ $programacion->ficha }}</td>
            <td>{{ $programacion->ambiente }}</td>
            <td>{{ $programacion->nombre_instructor_asignante }}</td>
            <td>{{ $programacion->fecha_inicio }}</td>
            <td>{{ $programacion->fecha_fin }}</td>
            <td>{{ $programacion->estado }}</td>
            <td>
            <a href="{{ route('programaciones.show', $programacion->id) }}" class="btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
