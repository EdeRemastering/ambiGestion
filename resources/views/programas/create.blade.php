@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Programa de Formación</h1>
    <form action="{{ route('programas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required>
        </div>
        <div class="form-group">
            <label for="version">Versión</label>
            <input type="text" class="form-control" id="version" name="version" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="form-group">
            <label for="duracion_meses">Duración (meses)</label>
            <input type="number" class="form-control" id="duracion_meses" name="duracion_meses" required>
        </div>
        <div class="form-group">
            <label for="red_conocimiento_id">Red de Conocimiento</label>
            <select class="form-control @error('red_conocimiento_id') is-invalid @enderror" id="red_conocimiento_id" name="red_conocimiento_id" required>
                <option value="">Seleccione una Red de Conocimiento</option>
                @foreach($redesConocimiento as $red)
                    <option value="{{ $red->id }}" {{ old('red_conocimiento_id') == $red->id ? 'selected' : '' }}>
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
        <button type="submit" class="btn btn-primary">Crear Programa de Formación</button>
    </form>
</div>
@endsection