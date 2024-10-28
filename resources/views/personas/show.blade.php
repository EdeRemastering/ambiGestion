@extends('layouts.app')

@section('titulo', 'Ver Persona')

@section('contenido')

    <h1>{{ $persona->pnombre }} {{ $persona->papellido }}</h1>
    <div class="contenedor-ver-elemento card">
        <div class="card-header">Detalles de la Persona</div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $persona->id }}</p>
            <p><strong>Documento:</strong> {{ $persona->documento }}</p>
            <p><strong>Nombre completo:</strong> {{ $persona->pnombre }} {{ $persona->snombre }} {{ $persona->papellido }} {{ $persona->sapellido }}</p>
            <p><strong>Teléfono:</strong> {{ $persona->telefono }}</p>
            <p><strong>Correo:</strong> {{ $persona->correo }}</p>
            <p><strong>Dirección:</strong> {{ $persona->direccion }}</p>
            <p><strong>Rol:</strong> {{ $persona->role_name ?? 'N/A' }}</p>
            <p><strong>Grupo Sanguíneo:</strong> {{ $persona->grupo_sanguineo_descripcion ?? 'N/A' }}</p>
            <p><strong>Tipo de Contrato:</strong> {{ $persona->contrato_descripcion ?? 'N/A' }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $persona->created_at}}</p>
            <p><strong>Última Actualización:</strong> {{ $persona->updated_at}}</p>
        </div>
    </div>

    <div class="botones-mostrar-elemento mt-3">
        @if(Auth::user()->role->name == 'admin')
            <a href="{{ route('personas.edit', $persona->id) }}" class="btn btn-success btn-sm">
                <i class="bi bi-pencil "></i> 
            </a>
            <form id="formularioEliminar-{{ $persona->id }}" action="{{ route('personas.destroy', $persona->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $persona->id }}', '{{ $persona->pnombre }} {{ $persona->papellido }}', 'personas')">
                    <i class="bi bi-trash3 "></i> 
                </button>
            </form>
        @endif
        <a href="{{ route('personas.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>

@endsection
