@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Estados de Ambiente</h2>
        <a href="{{ route('estado-ambientes.create') }}" class="btn btn-success">
            Crear Nuevo Estado
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
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
                                    <a href="{{ route('estado-ambientes.edit', $estado->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        Editar
                                    </a>
                                    <form action="{{ route('estado-ambientes.destroy', $estado->id) }}" 
                                          method="POST" 
                                          style="display:inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este estado?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection