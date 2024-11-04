@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-success mb-4">Listado de Jornadas</h1>

    <a href="{{ route('jornadas.create') }}" class="btn btn-success mb-3">Crear Nueva Jornada</a>

    <table id="jornadasTable" class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Hora de Inicio</th>
                <th>Hora de Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jornadas as $jornada)
            <tr>
                <td>{{ $jornada->nombre }}</td>
                <td>{{ $jornada->hora_inicio }}</td>
                <td>{{ $jornada->hora_fin }}</td>
                <td>
                    <a href="{{ route('jornadas.show', $jornada) }}" class="btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('jornadas.edit', $jornada) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('jornadas.destroy', $jornada) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"onclick="mensajeDeEliminacion(event, '{{ $jornada->id }}', '{{ $jornada->nombre }}', 'jornadas')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection