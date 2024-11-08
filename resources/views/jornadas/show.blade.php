@extends('layouts.app')
@section('titulo', 'Ver jornada')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $jornada->nombre }}</h5>
            <p class="card-text"><strong>Hora de Inicio:</strong> {{ $jornada->hora_inicio }}</p>
            <p class="card-text"><strong>Hora de Fin:</strong> {{ $jornada->hora_fin }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('jornadas.edit', $jornada) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('jornadas.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>
</div>
@endsection