@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Competencia</h1>
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
            <label for="programa_formacion_id" class="form-label">Programa de Formación</label>
            <select class="form-control" id="programa_formacion_id" name="programa_formacion_id" required>
                @foreach($programas as $programa)
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
@endsection