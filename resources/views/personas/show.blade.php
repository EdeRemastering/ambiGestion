@extends('layouts.app')

@section('titulo', 'Ver Persona')

@section('contenido')

    <h1>{{ $persona->pnombre }} {{ $persona->papellido }}</h1>
    <div class="contenedor-ver-elemento card">
        <div class="card-header">Detalles de la Persona</div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $persona->id }}</p>
            <p><strong>Documento:</strong> {{ $persona->documento }}</p>
            <p><strong>Primer Nombre:</strong> {{ $persona->pnombre }}</p>
            <p><strong>Segundo Nombre:</strong> {{ $persona->snombre ?? 'N/A' }}</p>
            <p><strong>Primer Apellido:</strong> {{ $persona->papellido }}</p>
            <p><strong>Segundo Apellido:</strong> {{ $persona->sapellido ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $persona->telefono }}</p>
            <p><strong>Correo:</strong> {{ $persona->correo }}</p>
            <p><strong>Dirección:</strong> {{ $persona->direccion }}</p>
            <p><strong>Rol:</strong> {{ $persona->rol->descripcion ?? 'N/A' }}</p>
            <p><strong>Grupo Sanguíneo:</strong> {{ $persona->grupoSanguineo->descripcion ?? 'N/A' }}</p>
            <p><strong>Tipo de Contrato:</strong> {{ $persona->tipoContrato->descripcion ?? 'N/A' }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $persona->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>Última Actualización:</strong> {{ $persona->updated_at->format('Y-m-d H:i:s') }}</p>
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
