@extends('layouts.app')

@section('titulo', 'Detalles de la Programación')

@section('contenido')

<div class="card">
    <div class="contenedor-ver-elemento card">
    <div class="card-header">
        Detalles de la Programación
    </div>
    <div class="card-body">
        <p><strong>Ficha:</strong> {{ $programacion->ficha }}</p>
        <p><strong>Ambiente:</strong> {{ $programacion->ambiente }}</p>
        <p><strong>Instructor Asignante:</strong> {{ $programacion->nombre_instructor_asignante }}</p>
        <p><strong>Hora Inicio:</strong> {{ $programacion->hora_inicio }}</p>
        <p><strong>Hora Fin:</strong> {{ $programacion->hora_fin }}</p>
        <p><strong>Fecha Inicio:</strong> {{ $programacion->fecha_inicio }}</p>
        <p><strong>Fecha Fin:</strong> {{ $programacion->fecha_fin }}</p>
        <p><strong>Estado:</strong> {{ $programacion->estado }}</p>
    </div>
</div>
    
    </div>
    @if(Auth::user()->role->name == 'admin')
    <a href="{{ route('programaciones.edit', $programacion->id) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil "></i></a>
                <form id="formularioEliminar-{{ $programacion->id }}" action="{{ route('programaciones.destroy', $programacion->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $programacion->id }}', '{{ $programacion->id }}', 'programaciones')">
                        <i class="bi bi-trash3 "></i>
                    </button>
                </form>
                @endif
         <a href="{{ route('programaciones.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>
    
@endsection
