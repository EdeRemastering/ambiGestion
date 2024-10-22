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
                <input type="number" name="id_ficha" id="id_ficha" class="form-control" value="{{ old('id_ficha') }}">
            </div>
            <div class="form-group">
                <label for="id_programa_formacion">Código de Programa de Formación:</label>
                <input type="number" name="id_programa_formacion" id="id_programa_formacion" class="form-control" value="{{ old('id_programa_formacion') }}">
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
            </div>
            <div class="form-group">
                <label for="hora_entrada">Hora de Entrada:</label>
                <input type="time" name="hora_entrada" id="hora_entrada" class="form-control" value="{{ old('hora_entrada') }}">
            </div>
            <div class="form-group">
                <label for="hora_salida">Hora de Salida:</label>
                <input type="time" name="hora_salida" id="hora_salida" class="form-control" value="{{ old('hora_salida') }}">
            </div>
            
           
            <div class="form-group">
                <label for="jornada">Jornada:</label>
                <select name="jornada" id="jornada" class="form-control">
                    <option value="" {{ old('jornada') == '' ? 'selected' : '' }}>Seleccione</option>
                    <option value="1" {{ old('jornada') == '1' ? 'selected' : '' }}>Mañana</option>
                    <option value="2" {{ old('jornada') == '2' ? 'selected' : '' }}>Tarde</option>
                    <option value="3" {{ old('jornada') == '3' ? 'selected' : '' }}>Noche</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}">
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
            </div>
            <button type="submit" class="btn btn-primary">Crear Ficha</button>
        </form>
        </div>
        </div>
@endsection