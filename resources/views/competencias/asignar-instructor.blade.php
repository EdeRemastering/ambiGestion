@extends('layouts.app')
@section('titulo', 'Asignar instructor a una competencia')

@section('content')

<div class="contenedor-principal">
    <div class="contenedor-secundario">

   
            <form action="{{ route('competencias.instructor.guardar', $competencia) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <h5><strong>Información de la Competencia</strong></h5>
                    <p><strong>Código:</strong> {{ $competencia->codigo }}</p>
                    <p><strong>Descripción:</strong> {{ $competencia->descripcion }}</p>
                    <p><strong>Red de Conocimiento:</strong> {{ $competencia->programaFormacion->redConocimiento->nombre }}</p>
                </div>

                <div class="mb-3">
                    <label for="instructor_id" class="form-label">Instructor</label>
                    <select class="form-select" name="instructor_id" required>
                        <option value="">Seleccione un instructor</option>
                        @foreach($instructores as $instructor)
                            <option value="{{ $instructor->id }}">
                                {{ $instructor->pnombre }} {{ $instructor->papellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" name="fecha_fin" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="horas_asignadas" class="form-label">Horas a Asignar</label>
                    <input type="number" class="form-control" name="horas_asignadas" 
                           min="1" max="{{ $competencia->duracion_horas }}" required>
                </div>

                <div id="horario-container">
                    <h5 class="mb-3">Horario</h5>
                    <div class="horario-dia mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-select" name="horario[0][dia]" required>
                                    <option value="">Seleccione día</option>
                                    <option value="lunes">Lunes</option>
                                    <option value="martes">Martes</option>
                                    <option value="miercoles">Miércoles</option>
                                    <option value="jueves">Jueves</option>
                                    <option value="viernes">Viernes</option>
                                    <option value="sabado">Sábado</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="time" class="form-control" 
                                       name="horario[0][hora_inicio]" required>
                            </div>
                            <div class="col-md-3">
                                <input type="time" class="form-control" 
                                       name="horario[0][hora_fin]" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success add-horario">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <a href="{{ route('competencias.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">Asignar Instructor</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let horarioCount = 1;
    
    document.querySelector('.add-horario').addEventListener('click', function() {
        const container = document.getElementById('horario-container');
        const template = document.querySelector('.horario-dia').cloneNode(true);
        
        template.querySelectorAll('select, input').forEach(input => {
            input.name = input.name.replace('[0]', `[${horarioCount}]`);
            input.value = '';
        });
        
        const btnContainer = template.querySelector('.col-md-2');
        btnContainer.innerHTML = '<button type="button" class="btn btn-danger remove-horario">-</button>';
        
        container.appendChild(template);
        horarioCount++;
        
        template.querySelector('.remove-horario').addEventListener('click', function() {
            template.remove();
        });
    });
});
</script>
@endpush

@endsection