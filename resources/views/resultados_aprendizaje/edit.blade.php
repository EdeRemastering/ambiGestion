@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Resultado de Aprendizaje</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('resultados_aprendizaje.update', $resultadoAprendizaje->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label for="codigo">Código</label>
        <input type="text" class="form-control" id="codigo" name="codigo" value="{{ old('codigo', $resultadoAprendizaje->codigo) }}" required>
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" required>{{ old('descripcion', $resultadoAprendizaje->descripcion) }}</textarea>
    </div>

    <div class="form-group">
        <label for="intensidad_horaria">Intensidad Horaria</label>
        <input type="number" class="form-control" id="intensidad_horaria" name="intensidad_horaria" value="{{ old('intensidad_horaria', $resultadoAprendizaje->intensidad_horaria) }}" required min="1">
    </div>

    <div class="form-group">
        <label for="competencia_id">Competencia</label>
        <select class="form-control" id="competencia_id" name="competencia_id" required>
            @foreach($competencias as $competencia)
                <option value="{{ $competencia->id }}" {{ $resultadoAprendizaje->competencia_id == $competencia->id ? 'selected' : '' }}>
                    {{ $competencia->codigo }} - {{ $competencia->descripcion }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar Resultado de Aprendizaje</button>
</form>

    <a href="{{ route('resultados_aprendizaje.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
</div>
@endsection