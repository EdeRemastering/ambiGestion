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
        <button type="submit" class="btn btn-primary">Crear Programa</button>
    </form>
</div>
@endsection