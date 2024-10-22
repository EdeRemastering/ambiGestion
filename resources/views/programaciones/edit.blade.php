@extends('layouts.app')

@section('titulo', 'Editar Programación')

@section('contenido')
<div class="contenedor-principal">
    <div class="contenedor-secundario">
        <!-- Formulario de edición de programación -->
        <form action="{{ route('programaciones.update', $programacion->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="ficha">Ficha:</label>
                <select name="ficha" id="ficha" class="form-control">
                    @foreach ($fichas as $ficha)
                        <option value="{{ $ficha->id_ficha }}" {{ $programacion->ficha == $ficha->id_ficha ? 'selected' : '' }}>{{ $ficha->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ambiente">Ambiente:</label>
                <select name="ambiente" id="ambiente" class="form-control">
                    @foreach ($ambientes as $ambiente)
                        <option value="{{ $ambiente->id }}" {{ $programacion->ambiente == $ambiente->id ? 'selected' : '' }}>{{ $ambiente->alias }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="hora_inicio">Hora de Inicio:</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ old('hora_inicio', $programacion->hora_inicio) }}" required>
            </div>

            <div class="form-group">
                <label for="hora_fin">Hora de Fin:</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ old('hora_fin', $programacion->hora_fin) }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $programacion->fecha_inicio) }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin', $programacion->fecha_fin) }}" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="activo" {{ $programacion->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $programacion->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Actualizar Programación</button>
        </form>
    </div>
</div>
@endsection
