@extends('layouts.app')
@section('titulo', 'Crear ambiente')

@section('content')
<div class="container">



    <form action="{{ route('ambientes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero" class="form-label">Número:</label>
            <input type="text" 
                   name="numero" 
                   id="numero" 
                   class="form-control @error('numero') is-invalid @enderror" 
                   value="{{ old('numero') }}" 
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
                   value="{{ old('alias') }}" 
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
                   value="{{ old('capacidad') }}" 
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
                      required>{{ old('descripcion') }}</textarea>
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
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo') == $tipo->id ? 'selected' : '' }}>
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
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}" {{ old('estado') == $estado->id ? 'selected' : '' }}>
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
                @foreach ($redes_de_conocimiento as $red)
                    <option value="{{ $red->id }}" {{ old('red_de_conocimiento') == $red->id ? 'selected' : '' }}>
                        {{ $red->nombre }}
                    </option>
                @endforeach
            </select>
            @error('red_de_conocimiento')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">Crear Ambiente</button>
            <a href="{{ route('ambientes.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>
@endsection