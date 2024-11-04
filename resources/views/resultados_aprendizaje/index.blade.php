@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultados de Aprendizaje</h1>
    <a href="{{ route('resultados_aprendizaje.create') }}" class="btn btn-primary mb-3">Crear Nuevo Resultado de Aprendizaje</a>

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

    <table id="resultados_aprendizajeTable" class="table">
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
            @foreach($resultadosAprendizaje as $resultado)
            <tr>
                <td>{{ $resultado->codigo }}</td>
                <td>{{ Str::limit($resultado->descripcion, 50) }}</td>
                <td>{{ $resultado->intensidad_horaria }} horas</td>
                <td>
                    @if($resultado->competencia)
                        {{ $resultado->competencia->codigo }} 
                        (Total: {{ $resultado->competencia->duracion_horas }} horas, 
                        Disponibles para nuevo: {{ $resultado->competencia->horasDisponibles() }} horas)
                    @else
                        No asignada
                    @endif
                </td>
                <td>
                    <a href="{{ route('resultados_aprendizaje.show', $resultado->id) }}" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('resultados_aprendizaje.edit', ['resultadoAprendizaje' => $resultado->id]) }}" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                     <form action="{{ route('resultados_aprendizaje.destroy', $resultado->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"onclick="mensajeDeEliminacion(event, '{{ $resultado->id }}', '{{ $resultado->nombre }}', 'resultados')"><i class="bi bi-trash"></i></button>
                        </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection