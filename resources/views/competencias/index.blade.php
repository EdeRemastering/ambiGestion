@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Competencias</h1>
    <a href="{{ route('competencias.create') }}" class="btn btn-primary mb-3">Crear Nueva Competencia</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Programa de Formación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($competencias as $competencia)
            <tr>
                <td>{{ $competencia->codigo }}</td>
                <td>{{ $competencia->descripcion }}</td>
                <td>{{ $competencia->programaFormacion->nombre }}</td>
                <td>
                    <a href="{{ route('competencias.show', $competencia->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('competencias.edit', $competencia->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('competencias.destroy', $competencia->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta competencia?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection