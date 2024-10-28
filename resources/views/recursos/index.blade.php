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
  
    <div class="acciones">
  
    <!-- Enlace para crear un nuevo recurso -->
    @if(Auth::user()->role->name == 'admin')
    <a href="{{ route('recursos.create') }}" class="btn boton-crear btn-success">Crear Recurso</a>
    @endif
    <a href="{{ route('recursos.pdf') }}" class="btn boton-crear btn-success" target="_blank">PDF</a>

    </div>
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
                <a href="{{ route('recursos.show', $recurso->id_recurso) }}" class="btn btn-success btn-sm"><i class="bi bi-eye "></i></a>
            
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

