@extends('layouts.app')


@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="contenedor-principal">

    <div class="contenedor-secundario">
        <form action="{{ route('novedades.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el nombre de la novedad" required>
            </div>

            
            <div class="form-group mb-3">
                <label for="id_recurso">Recurso:</label>
                <select id="id_recurso" name="id_recurso" class="form-control" required>
                    @foreach ($recursos as $recurso)
                        <option value="{{ $recurso->id_recurso}}">{{ $recurso->descripcion }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="4" placeholder="Descripción de la novedad" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="estado">Estado Novedad:</label>
                <select id="estado" name="estado" class="form-control" required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id}}">{{ $estado->nombre }}</option>
                    @endforeach
                </select>
            </div>


            <button type="submit" class="btn btn-primary">Crear Novedad</button>
        </form>
    </div>
</div>
@endsection