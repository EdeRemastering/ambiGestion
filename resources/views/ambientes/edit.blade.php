@extends('layouts.app')

@section('titulo', 'Editar Ambiente')

@section('contenido')

<div class="contenedor-principal">
    <section class="contenedor-secundario">
  
        <form action="{{ route('ambientes.update', $ambiente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="numero">Número:</label>
            <input type="text" name="numero" id="numero" value="{{ old('numero', $ambiente->numero) }}" required>

            <label for="alias">Alias:</label>
            <input type="text" name="alias" id="alias" value="{{ old('alias', $ambiente->alias) }}" required>

            <label for="capacidad">Capacidad:</label>
            <input type="number" name="capacidad" id="capacidad" value="{{ old('capacidad', $ambiente->capacidad) }}" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required>{{ old('descripcion', $ambiente->descripcion) }}</textarea>

            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id }}" {{ old('nombre', $tipo->nombre) }}>{{ $tipo->nombre }}</option>
                @endforeach
            </select>

            <label for="estado">Estado:</label>
            <select name="estado" id="estado">
                @foreach ($estados as $estado)
                <option value="{{ $estado->id }}" {{ old('nombre', $estado->nombre) }}>{{ $estado->nombre }}</option>
                @endforeach
            </select>

            <label for="red_de_conocimiento">Red de Conocimiento:</label>
            <select name="red_de_conocimiento" id="red_de_conocimiento">
            @foreach ($redes_de_conocimiento as $red_de_conocimiento)
                <option value="{{ $red_de_conocimiento->id_area_formacion}}" {{ old('nombre', $red_de_conocimiento->nombre)}}>{{ $red_de_conocimiento->nombre }}</option>
            @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Actualizar Ambiente</button>
        </form>
    </section>
</div>
@endsection