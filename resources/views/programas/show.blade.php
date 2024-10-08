@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Programa de Formación</h1>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $programa->nombre }}</h5>
            <p class="card-text"><strong>Código:</strong> {{ $programa->codigo }}</p>
            <p class="card-text"><strong>Versión:</strong> {{ $programa->version }}</p>
            <p class="card-text"><strong>Descripción:</strong> {{ $programa->descripcion }}</p>
            <p class="card-text"><strong>Duración:</strong> {{ $programa->duracion_meses }} meses</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('programas.edit', $programa->id) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('programas.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>
</div>
@endsection