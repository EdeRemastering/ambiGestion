@extends('layouts.app')
@section('titulo', 'Tipos de ambiente')

@section('content')
    <a href="{{ route('tipo-ambientes.create') }}" class="btn btn-success mb-3 boton-crear">Crear Tipo</a>
    
    <table id="tipo-ambientesTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tiposAmbiente as $tipo)
                <tr>
                    <td>{{ $tipo->id }}</td>
                    <td>{{ $tipo->nombre }}</td>
                    <td>
                    <a href="{{ route('tipo-ambientes.show', $tipo->id) }}" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('tipo-ambientes.edit', $tipo->id) }}" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('tipo-ambientes.destroy', $tipo->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"  onclick="mensajeDeEliminacion(event, '{{ $tipo->id }}', '{{ $tipo->nombre }}', 'tipo de ambientes')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection