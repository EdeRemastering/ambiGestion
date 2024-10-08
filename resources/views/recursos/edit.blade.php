@extends('layouts.app')

@section('titulo', 'Editar Recurso')

@section('contenido')

<div class="contenedor-principal">
    <div class="contenedor-secundario">
        <form action="{{ route('recursos.update', $recurso->id_recurso) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="id_ambiente">ID Ambiente:</label>
                <select name="id_ambiente" id="ambiente">
                    @foreach ($ambientes as $ambiente)
                        <option value="{{ $ambiente->id }}" {{ old('alias', $ambiente->alias)}}>{{ $ambiente->alias }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required>{{ $recurso->descripcion }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" class="form-control" required>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}" {{ old('nombre', $estado->nombre)}}>{{ $estado->nombre }}</option>
                 @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Recurso</button>
        </form>
    </div>
</div>
@endsection