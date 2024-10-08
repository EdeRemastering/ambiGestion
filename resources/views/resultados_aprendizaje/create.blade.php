@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Resultado de Aprendizaje</h1>
    <form action="{{ route('resultados_aprendizaje.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="intensidad_horaria" class="form-label">Intensidad Horaria</label>
            <input type="number" class="form-control" id="intensidad_horaria" name="intensidad_horaria" required min="1">
        </div>
        <div class="mb-3">
            <label for="competencia_id" class="form-label">Competencia</label>
            <select class="form-control" id="competencia_id" name="competencia_id" required>
                <option value="">Seleccione una competencia</option>
                @foreach($competencias as $competencia)
                    <option value="{{ $competencia->id }}">{{ $competencia->codigo }} - {{ $competencia->descripcion }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Resultado de Aprendizaje</button>
    </form>
    <a href="{{ route('resultados_aprendizaje.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
</div>
@endsection