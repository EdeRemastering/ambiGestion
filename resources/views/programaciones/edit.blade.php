@extends('layouts.app')

@section('titulo', 'Editar Programación')

@section('contenido')

<form action="{{ route('programaciones.update', $programacion->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="ficha">Ficha</label>
        <input type="text" name="ficha" class="form-control" value="{{ $programacion->ficha }}" required>
    </div>

    <div class="form-group">
        <label for="ambiente">Ambiente</label>
        <input type="text" name="ambiente" class="form-control" value="{{ $programacion->ambiente }}" required>
    </div>

    <div class="form-group">
        <label for="instructor_asignante">Instructor Asignante</label>
        <input type="text" name="instructor_asignante" class="form-control" value="{{ $programacion->instructor_asignante }}" required>
    </div>

    <div class="form-group">
        <label for="hora_inicio">Hora Inicio</label>
        <input type="time" name="hora_inicio" class="form-control" value="{{ $programacion->hora_inicio }}" required>
    </div>

    <div class="form-group">
        <label for="hora_fin">Hora Fin</label>
        <input type="time" name="hora_fin" class="form-control" value="{{ $programacion->hora_fin }}" required>
    </div>

    <div class="form-group">
        <label for="fecha_inicio">Fecha Inicio</label>
        <input type="date" name="fecha_inicio" class="form-control" value="{{ $programacion->fecha_inicio }}" required>
    </div>

    <div class="form-group">
        <label for="fecha_fin">Fecha Fin</label>
        <input type="date" name="fecha_fin" class="form-control" value="{{ $programacion->fecha_fin }}" required>
    </div>

    <div class="form-group">
        <label for="estado">Estado</label>
        <select name="estado" class="form-control">
            <option value="activo" {{ $programacion->estado == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ $programacion->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <button type="submit" class="btn btn-warning">Actualizar</button>
</form>

@endsection
