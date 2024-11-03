@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Crear Nueva Competencia</h4>
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

                    <form action="{{ route('competencias.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo" class="form-label">Código:</label>
                                    <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                           id="codigo" name="codigo" value="{{ old('codigo') }}" required>
                                    @error('codigo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duracion_horas" class="form-label">Duración (horas):</label>
                                    <input type="number" class="form-control @error('duracion_horas') is-invalid @enderror" 
                                           id="duracion_horas" name="duracion_horas" value="{{ old('duracion_horas') }}" 
                                           required min="1">
                                    @error('duracion_horas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="programa_formacion_id" class="form-label">Programa de Formación:</label>
                            <select class="form-select @error('programa_formacion_id') is-invalid @enderror" 
                                    id="programa_formacion_id" name="programa_formacion_id" required>
                                <option value="">Seleccione un programa</option>
                                @foreach($programasFormacion as $programa)
                                    <option value="{{ $programa->id }}" 
                                            data-red="{{ $programa->redConocimiento->nombre }}"
                                            {{ old('programa_formacion_id') == $programa->id ? 'selected' : '' }}>
                                        {{ $programa->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('programa_formacion_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Red de Conocimiento:</label>
                            <input type="text" class="form-control" id="red_conocimiento" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('competencias.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Crear Competencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const programaSelect = document.getElementById('programa_formacion_id');
    const redConocimientoInput = document.getElementById('red_conocimiento');

    function actualizarRedConocimiento() {
        const selectedOption = programaSelect.options[programaSelect.selectedIndex];
        redConocimientoInput.value = selectedOption.dataset.red || '';
    }

    programaSelect.addEventListener('change', actualizarRedConocimiento);
    actualizarRedConocimiento(); // Para establecer el valor inicial
});
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.card-header {
    border-bottom: none;
    padding: 1.5rem;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    padding: 0.75rem;
}

textarea.form-control {
    resize: vertical;
}

.btn {
    padding: 0.75rem 1.5rem;
}

.invalid-feedback {
    font-size: 0.875rem;
}
</style>
@endpush

@endsection