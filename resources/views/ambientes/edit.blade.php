@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Ambiente</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ambientes.update', $ambiente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="numero" class="form-label">Número:</label>
            <input type="text" 
                   name="numero" 
                   id="numero" 
                   class="form-control @error('numero') is-invalid @enderror" 
                   value="{{ old('numero', $ambiente->numero) }}" 
                   required>
            @error('numero')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alias" class="form-label">Alias:</label>
            <input type="text" 
                   name="alias" 
                   id="alias" 
                   class="form-control @error('alias') is-invalid @enderror" 
                   value="{{ old('alias', $ambiente->alias) }}" 
                   required>
            @error('alias')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad:</label>
            <input type="number" 
                   name="capacidad" 
                   id="capacidad" 
                   class="form-control @error('capacidad') is-invalid @enderror" 
                   value="{{ old('capacidad', $ambiente->capacidad) }}" 
                   required>
            @error('capacidad')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" 
                      id="descripcion" 
                      class="form-control @error('descripcion') is-invalid @enderror" 
                      required>{{ old('descripcion', $ambiente->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <select name="tipo" 
                    id="tipo" 
                    class="form-select @error('tipo') is-invalid @enderror" 
                    required>
                <option value="">Seleccione un tipo</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" 
                            {{ (old('tipo', $ambiente->tipo_id) == $tipo->id) ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('tipo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <select name="estado" 
                    id="estado" 
                    class="form-select @error('estado') is-invalid @enderror" 
                    required>
                <option value="">Seleccione un estado</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado->id }}" 
                            {{ (old('estado', $ambiente->estado_id) == $estado->id) ? 'selected' : '' }}>
                        {{ $estado->nombre }}
                    </option>
                @endforeach
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="red_de_conocimiento" class="form-label">Red de Conocimiento:</label>
            <select name="red_de_conocimiento" 
                    id="red_de_conocimiento" 
                    class="form-select @error('red_de_conocimiento') is-invalid @enderror" 
                    required>
                <option value="">Seleccione una red de conocimiento</option>
                @foreach($redes_de_conocimiento as $red)
                    <option value="{{ $red->id }}" 
                            {{ (old('red_de_conocimiento', $ambiente->red_conocimiento_id) == $red->id) ? 'selected' : '' }}>
                        {{ $red->nombre }}
                    </option>
                @endforeach
            </select>
            @error('red_de_conocimiento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Actualizar Ambiente</button>
            <a href="{{ route('ambientes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection