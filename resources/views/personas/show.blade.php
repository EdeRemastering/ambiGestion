@extends('layouts.app')
@section('titulo', 'Ver persona')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">{{ $persona->pnombre }} {{ $persona->papellido }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>ID:</strong> {{ $persona->id }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Documento:</strong> {{ $persona->documento }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Primer Nombre:</strong> {{ $persona->pnombre }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Segundo Nombre:</strong> {{ $persona->snombre ?? 'N/A' }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Primer Apellido:</strong> {{ $persona->papellido }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Segundo Apellido:</strong> {{ $persona->sapellido ?? 'N/A' }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Teléfono:</strong> {{ $persona->telefono }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Correo:</strong> {{ $persona->correo }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Dirección:</strong> {{ $persona->direccion }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Rol:</strong> {{ $persona->rol->descripcion ?? 'N/A' }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Grupo Sanguíneo:</strong> {{ $persona->grupoSanguineo->descripcion ?? 'N/A' }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Tipo de Contrato:</strong> {{ $persona->tipoContrato->descripcion ?? 'N/A' }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Fecha de Creación:</strong> {{ $persona->created_at->format('Y-m-d H:i:s') }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Última Actualización:</strong> {{ $persona->updated_at->format('Y-m-d H:i:s') }}
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('personas.edit', $persona) }}" class="btn btn-success btn-sm mb-2 mb-md-0"><i class="bi bi-eye"></i></a>
        <form action="{{ route('personas.destroy', $persona) }}" method="POST" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger"onclick="mensajeDeEliminacion(event, '{{ $persona->documento }}', '{{ $persona->pnombre }}', 'personas')"><i class="bi bi-trash"></i></button>
            </form>
            <a href="{{ route('personas.index') }}" class="btn btn-secondary btn-sm mb-2 mb-md-0">Volver a la lista</a>

    </div>
</div>

<style>
    @media (max-width: 768px) {
        .card-body .row > div {
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .card-body .row > div:last-child {
            border-bottom: none;
        }
    }
</style>
@endsection