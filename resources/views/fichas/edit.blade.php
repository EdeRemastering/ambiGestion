@extends('layouts.app')

@section('titulo', 'Editar Ficha')

@section('contenido')
<div class="contenedor-principal">
    <section class="contenedor-secundario">
        <!-- Formulario de edición de ficha -->
        <form action="{{ route('fichas.update', $ficha->id_ficha) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_ficha">Código de Ficha:</label>
                <input type="number" name="id_ficha" id="id_ficha" class="form-control" value="{{ old('id_ficha', $ficha->id_ficha) }}" required readonly>
                @if ($errors->has('id_ficha'))
                    <span style="color: red;">{{ $errors->first('id_ficha') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="id_programa_formacion">Programa de Formación:</label>
                <select name="id_programa_formacion" id="id_programa_formacion" class="form-control" required>
                    <option value="">Seleccione un programa de formación</option>
                    @foreach ($programas as $programa)
                        <option value="{{ $programa->id }}" {{ old('id_programa_formacion', $ficha->id_programa_formacion) == $programa->id ? 'selected' : '' }}>
                            {{ $programa->nombre }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('id_programa_formacion'))
                    <span style="color: red;">{{ $errors->first('id_programa_formacion') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $ficha->nombre) }}" required>
                @if ($errors->has('nombre'))
                    <span style="color: red;">{{ $errors->first('nombre') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="jornada">Jornada:</label>
                <select name="jornada" id="jornada" class="form-control" required>
                    @foreach ($jornadas as $jornada)
                        <option value="{{ $jornada->id }}" {{ old('jornada', $ficha->jornada) == $jornada->id ? 'selected' : '' }}>
                            {{ $jornada->nombre }}
                        </option>
                    @endforeach   
                </select>
                @if ($errors->has('jornada'))
                    <span style="color: red;">{{ $errors->first('jornada') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $ficha->fecha_inicio) }}" required>
                @if ($errors->has('fecha_inicio'))
                    <span style="color: red;">{{ $errors->first('fecha_inicio') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin', $ficha->fecha_fin) }}" required>
                @if ($errors->has('fecha_fin'))
                    <span style="color: red;">{{ $errors->first('fecha_fin') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Ficha</button>
        </form>
    </section>
</div>
@endsection
