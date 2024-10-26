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
                    <option value="">Seleccione una ficha</option>
                    @foreach ($fichas as $ficha)
                        <option value="{{ $ficha->id_ficha }}" 
                                data-jornada="{{ strtolower($ficha->jornada_nombre) }}"
                                {{ $programacion->ficha == $ficha->id_ficha ? 'selected' : '' }}>
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
                        <option value="{{ $ambiente->id }}" {{ $programacion->ambiente == $ambiente->id ? 'selected' : '' }}>
                            {{ $ambiente->alias }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group two-columns">
    <label for="dias">Día/s e Instructores:</label><br>
    @foreach($dias as $dia)
        <div class="form-check">
            <!-- Checkbox para seleccionar el día -->
            <input class="form-check-input" 
                   type="checkbox" 
                   name="dias[]" 
                   id="dia_{{ $dia->id }}" 
                   value="{{ $dia->id }}" 
                   {{ isset($asignacionesDiarias[$dia->id]) ? 'checked' : '' }}>
            <label class="form-check-label" for="dia_{{ $dia->id }}">{{ $dia->nombre }}</label>

            <!-- Selección de instructor para el día -->
            <select name="instructor_dia[{{ $dia->id }}]" class="form-control">
                <option value="">Seleccione un instructor</option>
                @foreach($instructores as $instructor)
                    <option value="{{ $instructor->id }}" 
                        {{ (isset($asignacionesDiarias[$dia->id]) && $asignacionesDiarias[$dia->id] == $instructor->id) ? 'selected' : '' }}>
                        {{ $instructor->pnombre }} {{ $instructor->snombre }} {{ $instructor->papellido }} {{ $instructor->sapellido }}
                    </option>
                @endforeach
            </select>
        </div>
    @endforeach
</div>

<div class="form-group">
<label for="hora_inicio">Hora Inicio</label>
    <input type="time" name="hora_inicio" value="{{ old('hora_inicio', $programacion->hora_inicio) }}" required>
    </div>

    <div class="form-group">
    <label for="hora_fin">Hora Fin</label>
    <input type="time" name="hora_fin" value="{{ old('hora_fin', $programacion->hora_fin) }}" required>
</div>

    <div class="form-group">
    <label for="fecha_inicio">Fecha Inicio</label>
    <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $programacion->fecha_inicio) }}" required>
    </div>

    <div class="form-group">
    <label for="fecha_fin">Fecha Fin</label>
    <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $programacion->fecha_fin) }}" required>
</div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="activo" {{ $programacion->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $programacion->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Programación</button>
        </form>
    </div>
</div>
@endsection
