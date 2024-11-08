@extends('layouts.app')
@section('titulo', 'Editar competencia')

@section('content')
<div class="contenedor-principal">
    <div class="contenedor-secundario">
    <form action="{{ route('competencias.update', $competencia->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $competencia->codigo }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ $competencia->descripcion }}</textarea>
        </div>
        <div class="mb-3">
            <label for="duracion_horas" class="form-label">Intensidad Horaria</label>
            <input type="number" class="form-control" id="duracion_horas" name="duracion_horas" value="{{ $competencia->duracion_horas }}" required min="1">
        </div>
        <div class="mb-3">
            <label for="programa_formacion_id" class="form-label">Programa de Formación</label>
            <select class="form-control" id="programa_formacion_id" name="programa_formacion_id" required>
                @foreach($programasFormacion as $programa)
                    <option value="{{ $programa->id }}" {{ $competencia->programa_formacion_id == $programa->id ? 'selected' : '' }}>
                        {{ $programa->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Competencia</button>
    </form>
    <a href="{{ route('competencias.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
</div>
</div>
</div>
@endsection