@extends('layouts.app')

@section('titulo', 'Crear Recurso')

@section('contenido')


<div class="contenedor-principal">
    <div class="contenedor-secundario">
        <form action="{{ route('recursos.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="id_ambiente">Ambiente:</label>
                <select name="id_ambiente" id="ambiente">
                    @foreach ($ambientes as $ambiente)
                        <option value="{{ $ambiente->id}}">{{ $ambiente->alias }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="4" placeholder="Descripción del recurso" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" class="form-control" required>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id}}">{{ $estado->nombre }}</option>
                 @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Crear Recurso</button>
        </form>
    </div>
</div>
@endsection