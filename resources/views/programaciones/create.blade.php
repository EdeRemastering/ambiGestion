@extends('layouts.app')

@section('titulo', 'Crear Programación')

@section('contenido')
<div class="contenedor-principal">
    <div class="contenedor-secundario">
        <!-- Formulario de creación de programación -->
        <form action="{{ route('programaciones.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="ficha">Ficha:</label>
                <select name="ficha" id="ficha" class="form-control">
                    @foreach ($fichas as $ficha)
                        <option value="{{ $ficha->id_ficha }}">{{ $ficha->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ambiente">Ambiente:</label>
                <select name="ambiente" id="ambiente" class="form-control">
                    @foreach ($ambientes as $ambiente)
                        <option value="{{ $ambiente->id }}">{{ $ambiente->alias }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="hora_inicio">Hora de Inicio:</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ old('hora_inicio') }}" required>
            </div>

            <div class="form-group">
                <label for="hora_fin">Hora de Fin:</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ old('hora_fin') }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Crear Programación</button>
        </form>
    </div>
</div>
@endsection
