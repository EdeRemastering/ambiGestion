@extends('layouts.app')

@section('titulo', 'Crear Programación')

@section('contenido')

<form action="{{ route('programaciones.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="ficha">Ficha</label>
        <select name="ficha" id="ficha">
                @foreach ($fichas as $ficha)
                    <option value="{{ $ficha->id_ficha }}">{{ $ficha->nombre }}</option>
                @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="ambiente">Ambiente</label>
        <select name="ambiente" id="ambiente">
                @foreach ($ambientes as $ambiente)
                    <option value="{{ $ambiente->id }}">{{ $ambiente->alias }}</option>
                @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="hora_inicio">Hora Inicio</label>
        <input type="time" name="hora_inicio" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="hora_fin">Hora Fin</label>
        <input type="time" name="hora_fin" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="fecha_inicio">Fecha Inicio</label>
        <input type="date" name="fecha_inicio" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="fecha_fin">Fecha Fin</label>
        <input type="date" name="fecha_fin" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="estado">Estado</label>
        <select name="estado" class="form-control">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Crear</button>
</form>

@endsection
