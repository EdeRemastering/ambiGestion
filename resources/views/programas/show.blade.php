@extends('layouts.app')

@section('titulo', 'Ver Programa')

@section('contenido')

    <h1>{{ $programa->nombre }}</h1>
    <div class="contenedor-ver-elemento card">
        <div class="card-header">Detalles del Programa</div>
        <div class="card-body">
            <p><strong>Versión:</strong> {{ $programa->version }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $programa->fecha_creacion }}</p>
            <p><strong>Duración (meses):</strong> {{ $programa->duracion_meses }}</p>
            <p><strong>Requisitos de Ingreso:</strong> {{ $programa->requisitos_ingreso }}</p>
            <p><strong>Requisitos de Formación:</strong> {{ $programa->requisitos_formacion }}</p>
            <p><strong>Red de Conocimiento:</strong> {{ $programa->nombre_red_conocimiento ?? 'No asignada' }}</p>
        </div>
    </div>
    <div class="botones-mostrar-elemento mt-3">
    <a href="{{ route('programas.edit', $programa->id) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                <form id="formularioEliminar-{{ $programa->id }}" action="{{ route('programas.destroy', $programa->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $programa->id }}', '{{ $programa->nombre }}', 'programas')">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </form>
         <a href="{{ route('programas.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>

@endsection
