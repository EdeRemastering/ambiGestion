@extends('layouts.app')

@section('titulo', 'Editar Ficha')

@section('contenido')
<div class="contenedor-principal">
    <section class="contenedor-secundario">
  
<form action="{{ route('fichas.update', $ficha->id_ficha) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $ficha->nombre) }}" required>
                @if ($errors->has('nombre'))
                <span style="color: red;">{{ $errors->first('nombre') }}</span>
                @endif
            </div>

            <div>
                <label for="id_programa_formacion">Programa de Formación:</label>
                <input type="number" name="id_programa_formacion" id="id_programa_formacion" value="{{ old('id_programa_formacion', $ficha->id_programa_formacion) }}" required>
                @if ($errors->has('id_programa_formacion'))
                <span style="color: red;">{{ $errors->first('id_programa_formacion') }}</span>
                @endif
            </div>

            <div>
                <label for="jornada">Jornada:</label>
                <input type="text" name="jornada" id="jornada" value="{{ old('jornada', $ficha->jornada) }}" required>
                @foreach ($jornadas as $jornada)
                        <option value="{{ $jornada->id }}">{{ $jornada->nombre }}</option>
                    @endforeach     
                    
                @if ($errors->has('jornada'))
                <span style="color: red;">{{ $errors->first('jornada') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Ficha</button>
        </form>
        </section>
        </div>
@endsection