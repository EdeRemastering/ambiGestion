@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-success mb-4">Editar Jornada</h1>

    <form action="{{ route('jornadas.update', $jornada) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $jornada->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="hora_inicio">Hora de Inicio:</label>
            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="{{ $jornada->hora_inicio }}" required>
        </div>
        <div class="form-group">
            <label for="hora_fin">Hora de Fin:</label>
            <input type="time" class="form-control" id="hora_fin" name="hora_fin" value="{{ $jornada->hora_fin }}" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar Jornada</button>
    </form>
</div>
@endsection