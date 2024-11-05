@extends('layouts.app')
@section('titulo', 'Ambientes')

@section('content')
<div class="container">
    

    <div class="mb-3">
        @foreach ($estados as $estado)
            @php
                $ambientesEnEstado = $estadisticas['ambientesPorEstado']->where('estado', $estado->id)->first();
                $cantidad = $ambientesEnEstado ? $ambientesEnEstado->total : 0;
            @endphp
            <a class="btn btn-success botonEstado">
                {{ ucfirst($estado->nombre) }}: {{ $cantidad }}
            </a>
        @endforeach
        <a class="btn btn-success botonEstadoTotal">Total: {{ $estadisticas['ambientesTotal'] }}</a>
    </div>

    <a href="{{ route('ambientes.create') }}" class="btn btn-success mb-3 boton-crear">Crear Ambiente</a>

    <table id="ambientesTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>Tipo de Ambiente</th>
                <th>Estado</th>
                <th>Red de Conocimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ambientes as $ambiente)
            <tr>
                <td>{{ $ambiente->id }}</td>
                <td>{{ $ambiente->numero }}</td>
                <td>{{ $ambiente->alias }}</td>
                <td>{{ $ambiente->capacidad }}</td>
                <td>{{ $ambiente->tipoAmbiente->nombre }}</td>
                <td>{{ $ambiente->estadoAmbiente->nombre }}</td>
                <td>{{ $ambiente->redConocimiento->nombre }}</td>
                <td>
                    <a href="{{ route('ambientes.show', $ambiente->id) }}" class="btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('ambientes.edit', $ambiente->id) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('ambientes.destroy', $ambiente->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"  onclick="mensajeDeEliminacion(event, '{{ $ambiente->id }}', '{{ $ambiente->alias }}', 'ambientes')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

    