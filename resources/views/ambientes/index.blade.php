@extends('layouts.app')

@section('titulo', 'Ambientes')

@section('contenido')

@section('estados')

        @foreach ($estados as $estado)
            @php
                // Buscar el estado actual en la colección de ambientes por estado
                $ambientesEnEstado = $ambientesPorEstado->firstWhere('estado', $estado->id);
                $cantidad = $ambientesEnEstado ? $ambientesEnEstado->total : 0;
            @endphp
            <a class="btn btn-success botonEstado">
                {{ ucfirst($estado->nombre) }}: {{ $cantidad }}
            </a>
        @endforeach
        <a class="btn btn-success botonEstadoTotal">Total: {{ $ambientesTotal }}</a>

    
    <!-- Enlace para crear un nuevo ambiente -->
    <a href="{{ route('ambientes.create') }}" class="btn boton-crear btn-success">Crear Ambiente</a>
@endsection

<!-- Tabla de ambientes -->
<table id="ambientesTable" class="table table-striped " style="width:100%">
    <thead>
        <tr>
            <th>Número</th>
            <th>Alias</th>
            <th>Capacidad</th>
            <th>Tipo</th>
            <th>Red de Conocimiento</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ambientes as $ambiente)
        <tr>
            <td>{{ $ambiente->numero }}</td>
            <td>{{ $ambiente->alias }}</td>
            <td>{{ $ambiente->capacidad }}</td>
            <td>{{ $ambiente->tipo_ambiente }}</td>
            <td>{{ $ambiente->nombre_red_de_conocimiento }}</td>
            <td>{{ $ambiente->estado_ambiente }}</td>
            <td>
                <a href="{{ route('ambientes.show', $ambiente->id) }}" class="btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
        
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection

