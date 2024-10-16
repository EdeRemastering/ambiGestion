@extends('layouts.app')

@section('titulo', 'Fichas')

@section('contenido')
    <!-- Enlace para crear una nueva ficha -->
    @section('estados')
        <a href="{{ route('fichas.create') }}" class="btn boton-crear btn-success">Crear Ficha</a>
    @endsection

    <table id="fichasTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID Ficha</th>
                <th>ID Programa de Formación</th>
                <th>Nombre</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Jornada</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fichas as $ficha)
            <tr>
                <td>{{ $ficha->id_ficha }}</td>
                <td>{{ $ficha->id_programa_formacion }}</td>
                <td>{{ $ficha->nombre }}</td>
                <td>{{ $ficha->hora_entrada }}</td>
                <td>{{ $ficha->hora_salida }}</td>
                <td>{{ $ficha->jornada }}</td>
                <td>{{ $ficha->fecha_inicio }}</td>
                <td>{{ $ficha->fecha_fin }}</td>
                <td>{{ $ficha->fecha_creacion }}</td>
                <td>
                    <a href="{{ route('fichas.edit', $ficha->id) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <form id="formularioEliminar-{{ $ficha->id }}" action="{{ route('fichas.destroy', $ficha->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $ficha->id }}', '{{ $ficha->alias }}', 'fichas')">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
