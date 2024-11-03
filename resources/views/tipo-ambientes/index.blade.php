@extends('layouts.app')

@section('content')
    <h1>Tipos de Ambiente</h1>
    <a href="{{ route('tipo-ambientes.create') }}" class="btn btn-primary">Crear Nuevo Tipo</a>
    
    <table id="tipo-ambientesTable" class="table">
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
                        <a href="{{ route('tipo-ambientes.edit', $tipo->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('tipo-ambientes.destroy', $tipo->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection