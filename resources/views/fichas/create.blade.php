@extends('layouts.app')

@section('titulo', 'Crear Ficha')

@section('contenido')
<div class="contenedor-principal">
    <div class="contenedor-secundario">
        <!-- Formulario de creación de fichas -->
        <form action="{{ route('fichas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="id_ficha">Código de Ficha:</label>
                <input type="number" name="id_ficha" id="id_ficha" class="form-control" value="{{ old('id_ficha') }}" required>
            </div>
            <div class="form-group">
                <label for="id_programa_formacion">Programa de formación:</label>
                <select name="id_programa_formacion" id="id_programa_formacion" class="form-control" required>
                    <option value="">Seleccione un programa de formación</option>
                    @foreach ($programas as $programa)
                        <option value="{{ $programa->id }}" {{ old('id_programa_formacion') == $programa->id ? 'selected' : '' }}>
                            {{ $programa->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>
           
            <div class="form-group">
                <label for="jornada">Jornada:</label>
                <select name="jornada" id="jornada" class="form-control" required>
                    @foreach ($jornadas as $jornada)
                        <option value="{{ $jornada->id }}">{{ $jornada->nombre }}</option>
                    @endforeach     
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Ficha</button>
        </form>
    </div>
</div>
@endsection
