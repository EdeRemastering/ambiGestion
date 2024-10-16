@extends('layouts.app')

@section('titulo', 'Ambientes')

@section('contenido')
  <!-- Formulario de creación de programas -->
  <form action="{{ route('programas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
        </div>

        <div class="form-group">
            <label for="version">Versión:</label>
            <input type="number" name="version" id="version" class="form-control" value="{{ old('version') }}">
        </div>

        <div class="form-group">
            <label for="duracion_meses">Duración (meses):</label>
            <input type="number" name="duracion_meses" id="duracion_meses" class="form-control" value="{{ old('duracion_meses') }}">
        </div>

        <div class="form-group">
            <label for="requisitos_ingreso">Requisitos de Ingreso:</label>
            <textarea name="requisitos_ingreso" id="requisitos_ingreso" class="form-control">{{ old('requisitos_ingreso') }}</textarea>
        </div>

        <div class="form-group">
            <label for="requisitos_formacion">Requisitos de Formación:</label>
            <textarea name="requisitos_formacion" id="requisitos_formacion" class="form-control">{{ old('requisitos_formacion') }}</textarea>
        </div>

        <div class="form-group">
            <label for="red_conocimiento">Red de Conocimiento:</label>
            <br>
            <select name="red_conocimiento" id="red_conocimiento" class="ancho-btn">
                <option value="1" {{ old('red_conocimiento') == '1' ? 'selected' : '' }}>Red de Tecnología</option>
                <option value="2" {{ old('red_conocimiento') == '2' ? 'selected' : '' }}>Red de Ciencias</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Programa</button>
    </form>
@endsection