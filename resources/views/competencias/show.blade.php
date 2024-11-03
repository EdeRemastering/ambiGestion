@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $competencia->codigo }} - {{ $competencia->descripcion }}</h1>
    <p>Duración total: {{ $competencia->duracion_horas }} horas</p>
    <p>Horas disponibles: {{ $competencia->horasDisponibles() }} horas</p>

    <h2>Resultados de Aprendizaje</h2>
    <a href="{{ route('competencias.distribuir-horas', $competencia) }}" class="btn btn-primary">Distribuir Horas Automáticamente</a>

    <form action="{{ route('resultados-aprendizaje.update-horas', $competencia) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Horas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($competencia->resultadosAprendizaje as $resultado)
                <tr>
                    <td>{{ $resultado->descripcion }}</td>
                    <td>
                    <input type="number" name="horas[{{ $resultado->id }}]" value="{{ $resultado->duracion_horas }}" min="0" max="{{ $competencia->duracion_horas }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-success">Actualizar Horas</button>
    </form>
</div>
@endsection