@extends('layouts.app')

@section('titulo', 'Personas')

@section('contenido')


<table id="personasTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personas as $persona)
            <tr>
                <td>{{ $persona->documento }}</td>
                <td>{{ $persona->pnombre }}</td>
                <td>{{ $persona->papellido }}</td>
                <td>{{ $persona->correo }}</td>
                <td>{{ $persona->user->role->name }}</td>
                <td>
                    <a href="{{ route('personas.edit', $persona) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil-fill"></i></a>
                    @if(Auth::user()->role->name === 'admin')
                        <form id="formularioEliminar-{{ $persona->documento }}" action="{{ route('personas.destroy', $persona) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="mensajeDeEliminacion(event, '{{ $persona->documento }}', '{{ $persona->pnombre }}', 'personas')">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    @endif

              

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection