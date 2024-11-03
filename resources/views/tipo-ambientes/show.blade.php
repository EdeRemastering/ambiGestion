@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detalles del Tipo de Ambiente</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $tipoAmbiente->nombre }}</h5>
                <p class="card-text">ID: {{ $tipoAmbiente->id }}</p>
                <p class="card-text">Creado: {{ $tipoAmbiente->created_at }}</p>
                <p class="card-text">Actualizado: {{ $tipoAmbiente->updated_at }}</p>
            </div>
        </div>
        <a href="{{ route('tipo-ambientes.edit', $tipoAmbiente->id) }}" class="btn btn-primary mt-3">Editar</a>
        <a href="{{ route('tipo-ambientes.index') }}" class="btn btn-secondary mt-3">Volver</a>
    </div>
@endsection