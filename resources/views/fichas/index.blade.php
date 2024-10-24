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
                <td>{{ $ficha->jornada }}</td>
                <td>{{ $ficha->fecha_inicio }}</td>
                <td>{{ $ficha->fecha_fin }}</td>
                <td>{{ $ficha->created_at }}</td>
                <td>
                    <a href="{{ route('fichas.show', $ficha->id_ficha) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-eye "></i>
                    </a>
                   
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
