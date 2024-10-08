@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultados de Aprendizaje</h1>
    <a href="{{ route('resultados_aprendizaje.create') }}" class="btn btn-primary mb-3">Crear Nuevo Resultado de Prendizaje</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Intensidad Horaria</th>
                <th>Competencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultados as $resultado)
            <tr>
                <td>{{ $resultado->codigo }}</td>
                <td>{{ Str::limit($resultado->descripcion, 50) }}</td>
                <td>{{ $resultado->intensidad_horaria }} horas</td>
                <td>{{ $resultado->competencia->codigo }}</td>
                <td>
                    <a href="{{ route('resultados_aprendizaje.show', $resultado->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('resultados_aprendizaje.edit', $resultado->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('resultados_aprendizaje.destroy', $resultado->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este resultado de formación?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection