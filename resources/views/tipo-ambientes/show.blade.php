@extends('layouts.app')
@section('titulo', 'Ver tipo de ambiente')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $tipoAmbiente->nombre }}</h5>
                <p class="card-text">ID: {{ $tipoAmbiente->id }}</p>
                <p class="card-text">Creado: {{ $tipoAmbiente->created_at }}</p>
                <p class="card-text">Actualizado: {{ $tipoAmbiente->updated_at }}</p>
            </div>
        </div>
        <a href="{{ route('tipo-ambientes.edit', $tipoAmbiente->id) }}" class="btn btn-success mt-3"><i class="bi bi-pencil"></i></a>
        <a href="{{ route('tipo-ambientes.index') }}" class="btn btn-secondary mt-3">Volver</a>
    </div>
@endsection