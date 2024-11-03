@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Red de Conocimiento</h1>
    <form action="{{ route('red_conocimiento.update', $redConocimiento) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="codigo">Código</label>
            <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo', $redConocimiento->codigo) }}" required>
            @error('codigo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $redConocimiento->nombre) }}" required>
            @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $redConocimiento->descripcion) }}</textarea>
            @error('descripcion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Red de Conocimiento</button>
    </form>
</div>
@endsection