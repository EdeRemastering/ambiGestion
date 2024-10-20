@extends('layouts.app')

@section('titulo', 'Novedades')

@section('contenido')
@section('estados')
    <!-- Enlace para crear una nueva novedad -->
@foreach ($estados as $estado)
    @php
        // Busca en la colección el primer registro donde el estado coincida con el ID del estado actual
        $novedadesEnEstado = $novedadesPorEstado->firstWhere('estado', $estado->id);
        
        // Si encontró novedades en ese estado, usa el valor de total; si no, asigna 0
        $cantidad = $novedadesEnEstado ? $novedadesEnEstado->total : 0;
    @endphp
    <a class="btn btn-success botonEstado">
        {{ ucfirst($estado->nombre) }}: {{ $cantidad }}
    </a>
@endforeach
<a class="btn btn-success botonEstadoTotal">Total: {{ $novedadesTotal }}</a>

<a href="{{ route('novedades.create') }}" class="btn boton-crear btn-success">Crear Novedad</a>
@endsection


<!-- Tabla de novedades -->
<table id="novedadesTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha de Registro</th>
            <th>Estado de Novedad</th>
            <th>Fecha de Solución</th>
            <th>Descripción Solución</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($novedades as $novedad)
        <tr>
            <td>{{ $novedad->id }}</td>
            <td>{{ $novedad->nombre }}</td>
            <td>{{ $novedad->descripcion }}</td>
            <td>{{ $novedad->fecha_registro }}</td>
            <td>{{ $novedad->nombre_estado_novedad }}</td>
            <td>{{ $novedad->fecha_solucion }}</td>
            <td>{{ $novedad->descripcion_solucion }}</td>
            <td>
                <a href="{{ route('novedades.show', $novedad->id) }}" class="btn btn-success btn-sm"><i class="bi bi-eye "></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
