@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Competencia</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Código: {{ $competencia->codigo }}</h5>
            <p class="card-text"><strong>Descripción:</strong> {{ $competencia->descripcion }}</p>
            <p class="card-text"><strong>Programa de Formación:</strong> {{ $competencia->programaFormacion->nombre }}</p>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('competencias.edit', $competencia->id) }}" class="btn btn-warning">Editar</a>
        <form action="{{ route('competencias.destroy', $competencia->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta competencia?')">Eliminar</button>
        </form>
        <a href="{{ route('competencias.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>
@endsection