@extends('layouts.app')

@section('titulo', 'Novedades')

@section('content')
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

<div class="acciones">
@if(Auth::user()->role->name == 'admin')
<a href="{{ route('novedades.create') }}" class="btn boton-crear btn-success">Crear Novedad</a>
@endif
<a href="{{ route('novedades.pdf') }}" class="btn boton-crear btn-success" target="_blank">PDF</a>

</div>

<!-- Tabla de novedades -->
<table id="novedadesTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Id recurso</th>

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
            <td>{{ $novedad->id_recurso }}</td>
            <td>{{ $novedad->descripcion }}</td>
            <td>{{ $novedad->fecha_registro }}</td>
            <td>{{ $novedad->nombre_estado_novedad }}</td>
            <td>{{ $novedad->fecha_solucion }}</td>
            <td>{{ $novedad->descripcion_solucion }}</td>
            <td>
                <a href="{{ route('novedades.show', $novedad->id) }}" class="btn btn-success btn-sm"><i class="bi bi-eye "></i></a>
                
                <a href="{{ route('novedades.edit', $novedad->id) }}" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                    @if(Auth::user()->role->name === 'admin')
                        <form action="{{ route('novedades.destroy', $novedad->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"onclick="mensajeDeEliminacion(event, '{{ $novedad->id }}', '{{ $novedad->nombre }}', 'novedades')"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
