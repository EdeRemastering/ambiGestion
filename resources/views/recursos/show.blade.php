@extends('layouts.app')
@section('titulo', 'Ver recurso')


@section('content')

    <h1>{{ $recurso->id_recurso}}</h1>
    <div class="contenedor-ver-elemento card">
        <div class="card-header">Detalles del recurso</div>
        <div class="card-body">
            <p><strong>Id:</strong> {{ $recurso->id_recurso }}</p>
            <p><strong>Ambiente al que pertenece:</strong> {{ $recurso->alias_ambiente }}</p>
            <p><strong>Descripción:</strong> {{ $recurso->descripcion }}</p>
            <p><strong>Fecha Registro:</strong> {{ $recurso->fecha_registro }}</p>
            <p><strong>Estado:</strong> {{ $recurso->nombre_estado ?? 'No asignada' }}</p>
        </div>
    </div>
    <div class="botones-mostrar-elemento mt-3">
    <a href="{{ route('recursos.edit', $recurso->id_recurso) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil "></i></a>
                <form id="formularioEliminar-{{ $recurso->id_recurso }}" action="{{ route('recursos.destroy', $recurso->id_recurso) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">

                        <i class="bi bi-trash3 "></i>
                    </button>
                </form>
         <a href="{{ route('recursos.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>

@endsection
