@extends('layouts.app')
@section('titulo', 'Ver resultado de aprendizaje')

@section('content')
<div class="container">

    @if($resultado)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Código: {{ $resultado->codigo ?? 'N/A' }}</h5>
                <p class="card-text"><strong>Descripción:</strong> {{ $resultado->descripcion ?? 'N/A' }}</p>
                <p class="card-text"><strong>Intensidad Horaria:</strong> {{ $resultado->intensidad_horaria ?? 'N/A' }} horas</p>
                @if($resultado->competencia)
                    <p class="card-text"><strong>Competencia:</strong> {{ $resultado->competencia->codigo }} - {{ $resultado->competencia->descripcion }}</p>
                @else
                    <p class="card-text"><strong>Competencia:</strong> No asignada</p>
                @endif
            </div>
        </div>

            
            <a href="{{ route('resultados_aprendizaje.edit', $resultado->id) }}" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                    @if(Auth::user()->role->name === 'admin')
                        <form action="{{ route('resultados_aprendizaje.destroy', $resultado->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"onclick="mensajeDeEliminacion(event, '{{ $resultado->id }}', '{{ $resultado->nombre }}', 'resultados_aprendizaje')"><i class="bi bi-trash"></i></button>
                        </form>
                    @endif
                    <a href="{{ route('resultados_aprendizaje.index') }}" class="btn btn-secondary">Volver al listado</a>


    @else
        <div class="alert alert-danger">
            Resultado de aprendizaje no encontrado.
        </div>
        <a href="{{ route('resultados_aprendizaje.index') }}" class="btn btn-secondary">Volver al listado</a>
    @endif
</div>
@endsection


