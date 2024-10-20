@extends('layouts.app')

@section('titulo', 'Ver Ficha')

@section('contenido')

    <h1>{{ $ficha->nombre }}</h1>
    <div class="contenedor-ver-elemento card">
        <div class="card-header">Detalles del ficha</div>
        <div class="card-body">
            <p><strong>Número:</strong> {{ $ficha->numero }}</p>
            <p><strong>Capacidad:</strong> {{ $ficha->capacidad }}</p>
            <p><strong>Descripción:</strong> {{ $ficha->descripcion }}</p>
            <p><strong>Tipo:</strong> {{ $ficha->tipo_ficha }}</p>
            <p><strong>Estado:</strong> {{ $ficha->estado_ficha ?? 'No asignada' }}</p>
            <p><strong>Red de conocimiento:</strong> {{ $ficha->nombre_red_conocimiento ?? 'No asignada' }}</p>
    
        </div>
    </div>
    <div class="botones-mostrar-elemento mt-3">
    @if(Auth::user()->role->name == 'admin')
    <a href="{{ route('fichas.edit', $ficha->id_ficha) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil "></i></a>
                <form id="formularioEliminar-{{ $ficha->id_ficha }}" action="{{ route('fichas.destroy', $ficha->id_ficha) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $ficha->id_ficha }}', '{{ $ficha->nombre }}', 'fichas')">
                        <i class="bi bi-trash3 "></i>
                    </button>
                </form>
                @endif
         <a href="{{ route('fichas.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>

@endsection
