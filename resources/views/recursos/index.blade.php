@extends('layouts.app')

@section('titulo', 'Recursos')

@section('contenido')

@section('estados')
    
    @foreach ($estados as $estado)
        @php
            $recursoEnEstado = $recursoPorEstado->firstWhere('estado', $estado->id);
            $cantidad = $recursoEnEstado ? $recursoEnEstado->total : 0;
        @endphp
        <a class="btn btn-success botonEstado">
            {{ ucfirst($estado->nombre) }}: {{ $cantidad }}
        </a>
    @endforeach
    <a class="btn btn-success botonEstadoTotal">Total: {{ $recursosTotal }}</a>
    <!-- Enlace para crear un nuevo recurso -->
    <a href="{{ route('recursos.create') }}" class="btn boton-crear btn-success">Crear Recurso</a>

@endsection

<!-- Tabla de recursos -->
<table id="recursosTable" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ID Recurso</th>
            <th>ID Ambiente</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recursos as $recurso)
        <tr>
            <td>{{ $recurso->id_recurso }}</td>
            <td>{{ $recurso->alias_ambiente }}</td>
            <td>{{ $recurso->descripcion }}</td>
            <td>{{ $recurso->nombre_estado }}</td>
            <td>
                <a href="{{ route('recursos.edit', $recurso->id_recurso) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                <form id="formularioEliminar-{{ $recurso->id_recurso }}" action="{{ route('recursos.destroy', $recurso->id_recurso) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" id="delete" onclick="mensajeDeEliminacion(event, '{{ $recurso->id_recurso }}', '{{ $recurso->descripcion }}', 'recursos')">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

