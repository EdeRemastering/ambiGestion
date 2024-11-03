@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
        padding-left: 12px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6c757d;
    }
    .form-label.required:after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Editar Ficha #{{ $ficha->codigo_ficha }}</h1>
                <a href="{{ route('fichas.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('fichas.update', $ficha) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="codigo_ficha" class="form-label required">Código de Ficha:</label>
                        <input type="text" class="form-control @error('codigo_ficha') is-invalid @enderror" 
                               id="codigo_ficha" name="codigo_ficha" 
                               value="{{ old('codigo_ficha', $ficha->codigo_ficha) }}" required>
                        @error('codigo_ficha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="numero_aprendices" class="form-label required">Número de Aprendices:</label>
                        <input type="number" class="form-control @error('numero_aprendices') is-invalid @enderror" 
                               id="numero_aprendices" name="numero_aprendices" 
                               value="{{ old('numero_aprendices', $ficha->numero_aprendices) }}" min="1" required>
                        @error('numero_aprendices')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="programa_formacion_id" class="form-label required">Programa de Formación:</label>
                        <select class="form-control select2-basic @error('programa_formacion_id') is-invalid @enderror" 
                                id="programa_formacion_id" name="programa_formacion_id" required>
                            <option value="">Seleccione un programa</option>
                            @foreach($programasFormacion as $programa)
                                <option value="{{ $programa->id }}" 
                                        data-red-id="{{ $programa->red_conocimiento_id }}"
                                        data-red-nombre="{{ $programa->redConocimiento->nombre }}"
                                        {{ old('programa_formacion_id', $ficha->programa_formacion_id) == $programa->id ? 'selected' : '' }}>
                                    {{ $programa->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('programa_formacion_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="red_conocimiento_display" class="form-label">Red de Conocimiento:</label>
                        <input type="text" class="form-control" id="red_conocimiento_display" 
                               value="{{ $ficha->redConocimiento->nombre }}" readonly>
                        <input type="hidden" name="red_conocimiento_id" id="red_conocimiento_id" 
                               value="{{ old('red_conocimiento_id', $ficha->red_conocimiento_id) }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="instructor_lider" class="form-label required">Instructor Líder:</label>
                        <select class="form-control select2-basic @error('instructor_lider') is-invalid @enderror" 
                                id="instructor_lider" name="instructor_lider" required>
                            <option value="">Seleccione un instructor</option>
                            @if($ficha->instructor)
                                <option value="{{ $ficha->instructor->id }}" selected>
                                    {{ $ficha->instructor->pnombre }} 
                                    {{ $ficha->instructor->snombre }} 
                                    {{ $ficha->instructor->papellido }} 
                                    {{ $ficha->instructor->sapellido }} 
                                    - {{ $ficha->instructor->documento }}
                                </option>
                            @endif
                        </select>
                        @error('instructor_lider')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="fecha_inicio" class="form-label required">Fecha de Inicio:</label>
                        <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
       id="fecha_inicio" name="fecha_inicio" 
       value="{{ Carbon\Carbon::parse($ficha->fecha_inicio)->format('Y-m-d') }}" required>
                        @error('fecha_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="jornada_id" class="form-label required">Jornada:</label>
                        <select class="form-control select2-basic @error('jornada_id') is-invalid @enderror" 
                                id="jornada_id" name="jornada_id" required>
                            <option value="">Seleccione una jornada</option>
                            @foreach($jornadas as $jornada)
                                <option value="{{ $jornada->id }}" 
                                        {{ old('jornada_id', $ficha->jornada_id) == $jornada->id ? 'selected' : '' }}>
                                    {{ $jornada->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('jornada_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="hora_entrada" class="form-label required">Hora Entrada:</label>
                        <input type="time" class="form-control @error('hora_entrada') is-invalid @enderror" 
                               id="hora_entrada" name="hora_entrada" 
                               value="{{ old('hora_entrada', $ficha->hora_entrada) }}" required readonly>
                        @error('hora_entrada')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="hora_salida" class="form-label required">Hora Salida:</label>
                        <input type="time" class="form-control @error('hora_salida') is-invalid @enderror" 
                               id="hora_salida" name="hora_salida" 
                               value="{{ old('hora_salida', $ficha->hora_salida) }}" required readonly>
                        @error('hora_salida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Ficha
                        </button>
                        <a href="{{ route('fichas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-basic').select2({
        placeholder: 'Seleccione una opción',
        allowClear: true,
        width: '100%'
    });

    $('#programa_formacion_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        const redId = selectedOption.data('red-id');
        const redNombre = selectedOption.data('red-nombre');
        
        $('#red_conocimiento_id').val(redId);
        $('#red_conocimiento_display').val(redNombre);

        if (redId) {
            $.get(`/api/instructores-por-red/${redId}`, function(instructores) {
                const instructorSelect = $('#instructor_lider');
                instructorSelect.empty().append('<option value="">Seleccione un instructor</option>');
                
                instructores.forEach(function(instructor) {
                    instructorSelect.append(new Option(instructor.texto, instructor.id));
                });

                instructorSelect.trigger('change');
            });
        }
    });

    $('#jornada_id').change(function() {
        const jornadas = @json($jornadas);
        const jornadaId = $(this).val();
        
        if (jornadaId) {
            const selectedJornada = jornadas.find(j => j.id == jornadaId);
            if (selectedJornada) {
                $('#hora_entrada').val(selectedJornada.hora_inicio);
                $('#hora_salida').val(selectedJornada.hora_fin);
            }
        }
    });

    if ($('#programa_formacion_id').val()) {
        $('#programa_formacion_id').trigger('change');
    }
    if ($('#jornada_id').val()) {
        $('#jornada_id').trigger('change');
    }
});
</script>
@endpush