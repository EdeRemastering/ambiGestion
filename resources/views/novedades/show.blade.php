@extends('layouts.app')


@section('content')

    <h1>{{ $novedad->nombre}}</h1>
    <div class="contenedor-ver-elemento card">
        <div class="card-header">Detalles del novedad</div>
        <div class="card-body">
            <p><strong>Id:</strong> {{ $novedad->id }}</p>
            <p><strong>Id recurso:</strong> {{ $novedad->id_recurso }}</p>

            <p><strong>Descripción:</strong> {{ $novedad->descripcion }}</p>
            <p><strong>Fecha Registro:</strong> {{ $novedad->fecha_registro }}</p>
            <p><strong>Estado:</strong> {{ $novedad->nombre_estado_novedad ?? 'No asignada' }}</p>
            <p><strong>Fecha solución:</strong> {{ $novedad->fecha_solucion ?? 'No asignada' }}</p>
            <p><strong>Descripción solución:</strong> {{ $novedad->descripcion_solucion ?? 'No asignada' }}</p>
        </div>
    </div>
    <div class="botones-mostrar-elemento mt-3">
    @if(Auth::user()->role->name == 'admin')
    <a href="{{ route('novedades.edit', $novedad->id) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil "></i></a>
                <form id="formularioEliminar-{{ $novedad->id}}" action="{{ route('novedades.destroy', $novedad->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                        <i class="bi bi-trash3 "></i>
                    </button>
                </form>
                @endif
         <a href="{{ route('novedades.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>

@endsection
