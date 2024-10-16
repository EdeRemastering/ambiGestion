@extends('layouts.app')

@section('titulo', 'Programas')


@section('contenido')

@section('estados')

    <!-- Enlace para crear un nuevo ficha -->
    <a href="{{ route('programas.create') }}" class="btn boton-crear btn-success">Crear Programa</a>
@endsection


<table id="programasTable" class="table table-striped " style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Versión</th>
                    <th>Fecha de Creación</th>
                    <th>Red de Conocimiento</th>
                    <th>Duración (meses)</th>
                    <th>Requisitos de Ingreso</th>
                    <th>Requisitos de Formación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programas as $programa)
                <tr>
                    <td>{{ $programa->id }}</td>
                    <td>{{ $programa->nombre }}</td>
                    <td>{{ $programa->version }}</td>
                    <td>{{ $programa->fecha_creacion }}</td>
                    <td>{{ $programa->red_conocimiento }}</td>
                    <td>{{ $programa->duracion_meses }}</td>
                    <td>{{ $programa->requisitos_ingreso }}</td>
                    <td>{{ $programa->requisitos_formacion }}</td>
                    <td>
                    <a href="{{ route('programas.edit', $programa->id) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    <form id="formularioEliminar-{{ $programa->id }}" action="{{ route('programas.destroy', $programa->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $programa->id }}', '{{ $programa->alias }}', 'programas')">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
@endsection