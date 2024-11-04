@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Personas</h2>

    <form action="{{ route('personas.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar personas..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <table id="personasTable" class="table">
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
                <a href="{{ route('personas.show', $persona) }}" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a>

                    <a href="{{ route('personas.edit', $persona) }}" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                    @if(Auth::user()->role->name === 'admin')
                        <form action="{{ route('personas.destroy', $persona) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"onclick="mensajeDeEliminacion(event, '{{ $persona->documento }}', '{{ $persona->pnombre }}', 'personas')"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection