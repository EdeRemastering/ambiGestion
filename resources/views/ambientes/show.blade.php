@extends('layouts.app')

@section('titulo', 'Ver Ambiente')

@section('contenido')

    <h1>{{ $ambiente->alias }}</h1>
    <div class="contenedor-ver-elemento card">
        <div class="card-header">Detalles del ambiente</div>
        <div class="card-body">
            <p><strong>Número:</strong> {{ $ambiente->numero }}</p>
            <p><strong>Capacidad:</strong> {{ $ambiente->capacidad }}</p>
            <p><strong>Descripción:</strong> {{ $ambiente->descripcion }}</p>
            <p><strong>Tipo:</strong> {{ $ambiente->tipo_ambiente }}</p>
            <p><strong>Estado:</strong> {{ $ambiente->estado_ambiente ?? 'No asignada' }}</p>
            <p><strong>Red de conocimiento:</strong> {{ $ambiente->nombre_red_conocimiento ?? 'No asignada' }}</p>
    
        </div>
    </div>
    <div class="botones-mostrar-elemento mt-3">
    @if(Auth::user()->role->name == 'admin')
    <a href="{{ route('ambientes.edit', $ambiente->id) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                <form id="formularioEliminar-{{ $ambiente->id }}" action="{{ route('ambientes.destroy', $ambiente->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $ambiente->id }}', '{{ $ambiente->alias }}', 'ambientes')">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
    @endif
         <a href="{{ route('ambientes.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>

@endsection
