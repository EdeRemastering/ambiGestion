@extends('layouts.app')
@section('titulo', 'Editar programa')

@section('content')
<div class="contenedor-principal">
    <div class="contenedor-secundario">
    @if(isset($programa))
        <form action="{{ route('programas.update', $programa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $programa->nombre }}" required>
            </div>
            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $programa->codigo }}" required>
            </div>
            <div class="mb-3">
                <label for="version" class="form-label">Versión</label>
                <input type="text" class="form-control" id="version" name="version" value="{{ $programa->version }}" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required>{{ $programa->descripcion }}</textarea>
            </div>
            <div class="mb-3">
                <label for="duracion_meses" class="form-label">Duración (meses)</label>
                <input type="number" class="form-control" id="duracion_meses" name="duracion_meses" value="{{ $programa->duracion_meses }}" required>
            </div>
            <div class="form-group">
            <label for="red_conocimiento_id">Red de Conocimiento</label>
            <select class="form-control @error('red_conocimiento_id') is-invalid @enderror" id="red_conocimiento_id" name="red_conocimiento_id" required>
                <option value="">Seleccione una Red de Conocimiento</option>
                @foreach($redesConocimiento as $red)
                    <option value="{{ $red->id }}" {{ (old('red_conocimiento_id', $programa->red_conocimiento_id) == $red->id) ? 'selected' : '' }}>
                        {{ $red->nombre }}
                    </option>
                @endforeach
            </select>
            @error('red_conocimiento_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Programa de Formación</button>
    </form>
</div>
</div>

    @else
        <p>No se encontró el programa de formación.</p>
    @endif
    <a href="{{ route('programas.index') }}" class="btn btn-secondary mt-3">Volver a la lista</a>
</div>
@endsection