@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Nuevo Tipo de Ambiente</h2>
        <form action="{{ route('tipo-ambientes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Guardar</button>
        </form>
        <a href="{{ route('tipo-ambientes.index') }}" class="btn btn-secondary mt-3">Volver</a>
    </div>
@endsection