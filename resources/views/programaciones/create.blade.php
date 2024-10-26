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
                        <option value="">Seleccione una ficha</option>
                    @foreach ($fichas as $ficha)
                        <option value="{{ $ficha->id_ficha }}" data-jornada="{{ strtolower($ficha->jornada_nombre) }}">
                            {{ $ficha->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ambiente">Ambiente:</label>
                <select name="ambiente" id="ambiente" class="form-control">
                        <option value="">Seleccione un ambiente</option>
                    @foreach ($ambientes as $ambiente)
                        <option value="{{ $ambiente->id }}">{{ $ambiente->alias }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group two-columns">
                <label for="dias">Día/s e Instructores:</label><br>
                @foreach ($dias as $dia)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" id="dia_{{ $dia->id }}" value="{{ $dia->id }}">
                        <label class="form-check-label" for="dia_{{ $dia->id }}">{{ $dia->nombre }}</label>

                        <select name="instructor_dia[{{ $dia->id }}]" class="form-control">
                            <option value="">Seleccione un instructor</option>
                            @foreach ($instructores as $instructor)
                                <option value="{{ $instructor->id }}">
                                    {{ $instructor->pnombre }} {{ $instructor->snombre }} {{ $instructor->papellido }} {{ $instructor->sapellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label for="hora_inicio">Hora de Inicio:</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="hora_fin">Hora de Fin:</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
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
