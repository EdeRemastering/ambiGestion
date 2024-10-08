@extends('layouts.app')

@section('titulo', 'Crear Ambiente')

@section('contenido')

<!-- Usar la clase "contenedor-principal" y "contenedor-secundario" -->
<div class="contenedor-principal">
    <div class="contenedor-secundario">
        <!-- Muestra errores de validación si existen -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de creación de ambientes -->
        <form action="{{ route('ambientes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" name="numero" id="numero" class="form-control" value="{{ old('numero') }}">
            </div>

            <div class="form-group">
                <label for="alias">Alias:</label>
                <input type="text" name="alias" id="alias" class="form-control" value="{{ old('alias') }}">
            </div>

            <div class="form-group">
                <label for="capacidad">Capacidad:</label>
                <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ old('capacidad') }}">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
            </div>

            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select name="tipo" id="tipo">
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <select name="estado" id="estado">
                    @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="red_de_conocimiento">Red de Conocimiento:</label>
                <select name="red_de_conocimiento" id="red_de_conocimiento">
                    @foreach ($redes_de_conocimiento as $red_de_conocimiento)
                        <option value="{{ $red_de_conocimiento->id_area_formacion}}">{{ $red_de_conocimiento->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Crear Ambiente</button>
        </form>
    </div>
</div>
@endsection