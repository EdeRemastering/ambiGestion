@extends('layouts.app')
@section('titulo', 'Distribuir horas - competencia')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Distribución de Horas - Competencia</h4>
                    <span class="badge bg-light text-dark">Total Horas: {{ $competencia->duracion_horas }}</span>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>Información de la Competencia</h5>
                        <p><strong>Código:</strong> {{ $competencia->codigo }}</p>
                        <p><strong>Descripción:</strong> {{ $competencia->descripcion }}</p>
                        <p><strong>Programa:</strong> {{ $competencia->programaFormacion->nombre }}</p>
                    </div>

                    @if($competencia->resultadosAprendizaje->count() > 0)
                        <form action="{{ route('resultados-aprendizaje.update-horas', $competencia) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Resultado de Aprendizaje</th>
                                            <th width="150">Horas Actuales</th>
                                            <th width="150">Horas Asignadas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($competencia->resultadosAprendizaje as $resultado)
                                            <tr>
                                                <td>{{ $resultado->descripcion }}</td>
                                                <td class="text-center">{{ $resultado->intensidad_horaria }}</td>
                                                <td>
                                                    <input type="number" 
                                                           name="horas[{{ $resultado->id }}]" 
                                                           class="form-control text-center" 
                                                           value="{{ $resultado->intensidad_horaria }}"
                                                           min="1" 
                                                           max="{{ $competencia->duracion_horas }}"
                                                           required>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-light">
                                            <td><strong>Total</strong></td>
                                            <td class="text-center">
                                                <strong>{{ $competencia->resultadosAprendizaje->sum('intensidad_horaria') }}</strong>
                                            </td>
                                            <td>
                                                <span id="total-horas" class="badge bg-primary">0</span>
                                                <span class="text-muted">/{{ $competencia->duracion_horas }}</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" 
                                        class="btn btn-success" 
                                        onclick="distribuirHorasUniformemente()">
                                    <i class="fas fa-balance-scale"></i> Distribuir Uniformemente
                                </button>

                                <div>
                                    <a href="{{ route('competencias.show', $competencia) }}" 
                                       class="btn btn-secondary me-2">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="btn-guardar">
                                        <i class="fas fa-save"></i> Guardar Distribución
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            No hay resultados de aprendizaje registrados para esta competencia.
                            <a href="{{ route('resultados_aprendizaje.create') }}" class="alert-link">
                                Agregar resultados de aprendizaje
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[name^="horas"]');
    const totalSpan = document.getElementById('total-horas');
    const btnGuardar = document.getElementById('btn-guardar');
    const totalHorasDisponibles = {{ $competencia->duracion_horas }};

    function actualizarTotal() {
        let total = 0;
        inputs.forEach(input => total += parseInt(input.value) || 0);
        totalSpan.textContent = total;
        
        if (total !== totalHorasDisponibles) {
            totalSpan.classList.remove('bg-primary');
            totalSpan.classList.add('bg-danger');
            btnGuardar.disabled = true;
        } else {
            totalSpan.classList.remove('bg-danger');
            totalSpan.classList.add('bg-primary');
            btnGuardar.disabled = false;
        }
    }

    inputs.forEach(input => {
        input.addEventListener('input', actualizarTotal);
    });

    actualizarTotal();
});

function distribuirHorasUniformemente() {
    const inputs = document.querySelectorAll('input[name^="horas"]');
    const totalHoras = {{ $competencia->duracion_horas }};
    const cantidadResultados = inputs.length;
    
    if (cantidadResultados === 0) return;

    const horasPorResultado = Math.floor(totalHoras / cantidadResultados);
    let horasRestantes = totalHoras % cantidadResultados;

    inputs.forEach((input, index) => {
        let horas = horasPorResultado;
        if (horasRestantes > 0) {
            horas++;
            horasRestantes--;
        }
        input.value = horas;
        input.dispatchEvent(new Event('input'));
    });
}
</script>
@endpush

@push('styles')
<style>
    .table input[type="number"] {
        min-width: 80px;
    }
    
    .badge {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@endsection