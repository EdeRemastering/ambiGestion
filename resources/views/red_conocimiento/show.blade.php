@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Red de Conocimiento</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $redConocimiento->nombre }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Código: {{ $redConocimiento->codigo }}</h6>
            <p class="card-text">{{ $redConocimiento->descripcion }}</p>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('red_conocimiento.edit', $redConocimiento) }}" class="btn btn-warning">Editar</a>
        <form action="{{ route('red_conocimiento.destroy', $redConocimiento) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta Red de Conocimiento?')">Eliminar</button>
        </form>
        <a href="{{ route('red_conocimiento.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>
@endsection