@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col">
            <h1 class="text-success">Listado de Competencias</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('competencias.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Crear Nueva Competencia
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="competenciasTable" class="table table-striped table-hover">
                    <thead class="table-green-header">
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Programa de Formación</th>
                            <th>Red de Conocimiento</th>
                            <th>Duración (horas)</th>
                            <th>Horas Disponibles</th>
                            <th>Instructores</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($competencias as $competencia)
                        <tr>
                            <td>{{ $competencia->codigo }}</td>
                            <td>{{ Str::limit($competencia->descripcion, 50) }}</td>
                            <td>{{ $competencia->programaFormacion->nombre }}</td>
                            <td>{{ $competencia->programaFormacion->redConocimiento->nombre }}</td>
                            <td class="text-center">{{ $competencia->duracion_horas }}</td>
                            <td class="text-center">
                                @php
                                    $horasDisponibles = $competencia->horasDisponibles();
                                @endphp
                                @if(is_numeric($horasDisponibles))
                                    {{ $horasDisponibles }}
                                @else
                                    <span class="text-danger">Error: {{ $horasDisponibles }}</span>
                                @endif
                            </td>
                            <td>
                                @if($competencia->instructores->count() > 0)
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" 
                                            data-bs-target="#instructoresModal{{ $competencia->id }}">
                                        <i class="bi bi-eye"></i> 
                                         ({{ $competencia->instructores->count() }})
                                    </button>

                                    <!-- Modal Instructores -->
                                    <div class="modal fade" id="instructoresModal{{ $competencia->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-users me-2"></i>
                                                        Instructores Asignados - {{ $competencia->codigo }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-striped">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Instructor</th>
                                                                    <th>Horas</th>
                                                                    <th>Período</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($competencia->instructores as $instructor)
                                                                <tr>
                                                                    <td>{{ $instructor->pnombre }} {{ $instructor->papellido }}</td>
                                                                    <td class="text-center">{{ $instructor->pivot->horas_asignadas }}</td>
                                                                    <td>
                                                                        {{ \Carbon\Carbon::parse($instructor->pivot->fecha_inicio)->format('d/m/Y') }}
                                                                        -
                                                                        {{ \Carbon\Carbon::parse($instructor->pivot->fecha_fin)->format('d/m/Y') }}
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge bg-{{ $instructor->pivot->estado === 'activo' ? 'success' : 'secondary' }}">
                                                                            {{ ucfirst($instructor->pivot->estado) }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-secondary">Sin instructores</span>
                                @endif
                                <a href="{{ route('competencias.instructor.asignar', $competencia->id) }}" 
                                       class="btn btn-success btn-sm" title="Asignar instructor">
                                        <i class="bi bi-plus-circle"></i> 
                                    </a>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('competencias.show', $competencia) }}" 
                                       class="btn btn-success btn-sm" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('competencias.edit', $competencia) }}" 
                                       class="btn btn-success btn-sm" title="Editar">
                                        <i class="bi bi-pencil"></i> 
                                    </a>
                      
                                    <form action="{{ route('competencias.destroy', $competencia) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"onclick="mensajeDeEliminacion(event, '{{ $competencia->id }}', '{{ $competencia->nombre }}', 'competencias')"><i class="bi bi-trash"></i></button>

                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-green-header {
        background-color: #198754;
        color: white;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.75rem;
        margin-right: 3px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        min-width: 90px;
        justify-content: center;
    }
    
    .btn-group .btn i {
        font-size: 0.875rem;
    }
    
    .modal-body table {
        font-size: 0.9rem;
    }

    .table td {
        vertical-align: middle;
    }

    .badge {
        font-size: 0.875rem;
    }

    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
    }

    /* Mejoras para dispositivos móviles */
    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .btn-group .btn {
            width: 100%;
            margin-right: 0;
        }

        .table-responsive {
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-cerrar las alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush

@endsection