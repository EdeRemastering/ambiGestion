@extends('layouts.app')
@section('titulo', 'Estados de ambientes')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('estado-ambientes.create') }}" class="btn btn-success">
            Crear Nuevo Estado
        </a>
    </div>

    
            <table id="estado-ambientesTable" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estados as $estado)
                        <tr>
                            <td>{{ $estado->id }}</td>
                            <td>{{ $estado->nombre }}</td>
                            <td>
                                <div class="btn-group">
                                <a href="{{ route('estado-ambientes.show', $estado->id) }}" 
                                       class="btn btn-sm btn-success">
                                       <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('estado-ambientes.edit', $estado->id) }}" 
                                       class="btn btn-sm btn-success">
                                       <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('estado-ambientes.destroy', $estado->id) }}" 
                                          method="POST" ></form>
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"  onclick="mensajeDeEliminacion(event, '{{ $estado->id }}', '{{ $estado->nombre }}', 'estado de ambientes')"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

</div>
@endsection