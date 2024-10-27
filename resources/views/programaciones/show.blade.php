@extends('layouts.app')

@section('titulo', 'Ver Programación')

@section('contenido')
    <h1>Programación</h1>
    
    <div class="contenedor-ver-elemento card">
        <div class="card-header">Detalles de la Programación</div>
        <div class="card-body">
            <p><strong>Ficha:</strong> {{ $programacion->ficha }}</p>
            <p><strong>Ambiente:</strong> {{ $programacion->ambiente }}</p>
            <p><strong>Instructor asignante:</strong> {{ $programacion->nombre_instructor_asignante }} </p>
            <p><strong>Hora de Inicio:</strong> {{ $programacion->hora_inicio }}</p>
            <p><strong>Hora de Fin:</strong> {{ $programacion->hora_fin }}</p>
            <p><strong>Fecha de Inicio:</strong> {{ $programacion->fecha_inicio }}</p>
            <p><strong>Fecha de Fin:</strong> {{ $programacion->fecha_fin }}</p>
            <p><strong>Estado:</strong> {{ $programacion->estado }}</p>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Instructor</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($diasSemana as $dia)
                        <tr>
                            <td>{{ $dia->nombre }}</td>
                            <td>
                                @if(isset($asignacionesDiarias[$dia->id]))
                                    {{ $asignacionesDiarias[$dia->id] }}
                                @else
                                    Sin instructor asignado
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="botones-mostrar-elemento mt-3">
        @if(Auth::user()->role->name == 'admin' || Auth::user()->role->name == 'instructor_lider')
            <a href="{{ route('programaciones.edit', $programacion->id) }}" class="btn btn-success btn-sm">
                <i class="bi bi-pencil "></i>
            </a>
            <form id="formularioEliminar-{{ $programacion->id }}" action="{{ route('programaciones.destroy', $programacion->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $programacion->id }}', '{{ $programacion->ficha }}', 'programaciones')">
                    <i class="bi bi-trash3 "></i>
                </button>
            </form>
        @endif
        <a href="{{ route('programaciones.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>
@endsection
