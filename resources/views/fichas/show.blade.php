@extends('layouts.app')

@section('styles')
<style>
    .estado-badge {
        padding: 0.5em 1em;
        border-radius: 15px;
        font-weight: bold;
    }
    .por-iniciar { 
        background-color: #ffd700; 
        color: #000; 
    }
    .etapa-lectiva { 
        background-color: #28a745; 
        color: #fff; 
    }
    .etapa-practica { 
        background-color: #1e90ff; 
        color: #fff; 
    }
    .finalizada { 
        background-color: #dc3545; 
        color: #fff; 
    }
    .details-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .details-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-info text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">
                    <i class="fas fa-chalkboard-teacher"></i> 
                    Ficha #{{ $ficha->codigo_ficha }}
                </h1>
                <div>
                    <a href="{{ route('fichas.edit', $ficha) }}" class="btn btn-light me-2">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('fichas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <!-- Información Principal -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 details-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle"></i> Información Principal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Estado:</strong>
                                <span class="estado-badge {{ Str::slug($ficha->estado_actual) }} ms-2">
                                    {{ $ficha->estado_actual }}
                                </span>
                            </div>
                            <div class="mb-2">
                                <strong>Código:</strong>
                                <p class="mb-1">{{ $ficha->codigo_ficha }}</p>
                            </div>
                            <div class="mb-2">
                                <strong>Programa:</strong>
                                <p class="mb-1">{{ $ficha->programaFormacion->nombre }}</p>
                            </div>
                            <div class="mb-2">
                                <strong>Red de Conocimiento:</strong>
                                <p class="mb-1">{{ $ficha->redConocimiento->nombre }}</p>
                            </div>
                            <div class="mb-2">
                                <strong>Instructor Líder:</strong>
                                <p class="mb-1">
                                    {{ $ficha->instructor->pnombre }} 
                                    {{ $ficha->instructor->snombre }} 
                                    {{ $ficha->instructor->papellido }} 
                                    {{ $ficha->instructor->sapellido }}
                                    <br>
                                    <small class="text-muted">{{ $ficha->instructor->documento }}</small>
                                </p>
                            </div>
                            <div class="mb-2">
                                <strong>Número de Aprendices:</strong>
                                <p class="mb-1">{{ $ficha->numero_aprendices }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Horarios -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 details-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-clock"></i> Horarios
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <strong>Jornada:</strong>
                                <p class="mb-1">{{ $ficha->jornada->nombre }}</p>
                            </div>
                            <div class="mb-2">
                                <strong>Hora de Entrada:</strong>
                                <p class="mb-1">{{ \Carbon\Carbon::parse($ficha->hora_entrada)->format('h:i A') }}</p>
                            </div>
                            <div class="mb-2">
                                <strong>Hora de Salida:</strong>
                                <p class="mb-1">{{ \Carbon\Carbon::parse($ficha->hora_salida)->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fechas Importantes -->
                <div class="col-md-12 mb-4">
                    <div class="card h-100 details-card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-alt"></i> Fechas Importantes
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            <div class="mb-2">
    <strong>Fecha de Inicio:</strong>
    <p class="mb-1">{{ Carbon\Carbon::parse($ficha->fecha_inicio)->format('d/m/Y') }}</p>
</div>
<div class="mb-2">
    <strong>Fecha Fin Etapa Lectiva:</strong>
    <p class="mb-1">{{ Carbon\Carbon::parse($ficha->fecha_fin_lectiva)->format('d/m/Y') }}</p>
</div>
<div class="mb-2">
    <strong>Fecha Inicio Etapa Práctica:</strong>
    <p class="mb-1">{{ Carbon\Carbon::parse($ficha->fecha_inicio_practica)->format('d/m/Y') }}</p>
</div>
<div class="mb-2">
    <strong>Fecha de Finalización:</strong>
    <p class="mb-1">{{ Carbon\Carbon::parse($ficha->fecha_fin)->format('d/m/Y') }}</p>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-danger" onclick="confirmarEliminacion()">
                        <i class="fas fa-trash"></i> Eliminar Ficha
                    </button>
                    <a href="{{ route('fichas.imprimir-aprendices', $ficha) }}" 
                       class="btn btn-secondary" target="_blank">
                        <i class="fas fa-print"></i> Imprimir Lista de Aprendices
                    </a>
                </div>
            </div>

            <form id="eliminar-ficha" action="{{ route('fichas.destroy', $ficha) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmarEliminacion() {
        Swal.fire({
            title: '¿Está seguro?',
            text: 'Va a eliminar esta ficha. Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('eliminar-ficha').submit();
            }
        });
    }
</script>
@endpush