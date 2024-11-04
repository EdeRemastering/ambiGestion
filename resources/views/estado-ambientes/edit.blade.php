@extends('layouts.app')
@section('titulo', 'Editar estado de ambiente')

@section('content')
<div class="contenedor-principal">
    <div class="contenedor-secundario">


            <form action="{{ route('estado-ambientes.update', $estadoAmbiente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre', $estadoAmbiente->nombre) }}" 
                           required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('estado-ambientes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection