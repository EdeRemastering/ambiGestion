@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Tipo de Ambiente</h2>
        <form action="{{ route('tipo-ambientes.update', $tipoAmbiente->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $tipoAmbiente->nombre }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        </form>
        <a href="{{ route('tipo-ambientes.index') }}" class="btn btn-secondary mt-3">Volver</a>
    </div>
@endsection