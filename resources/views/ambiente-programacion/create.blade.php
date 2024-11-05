@extends('layouts.app')
@section('titulo', 'Crear programación')

@section('content')

        <form action="{{ route('ambiente-programacion.store') }}" method="POST" class="">
            @csrf
            
            <div class="overflow-x-auto">
                <div class="mb-4">
                    <p class="text-gray-700">Semana del: {{ $diasSemana[0]->format('d/m/Y') }} al {{ $diasSemana[6]->format('d/m/Y') }}</p>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr class="">
                            <th class="py-2 px-4 border font-bold">Día</th>
                            <th class="py-2 px-4 border font-bold">Ambiente</th>
                            <th class="py-2 px-4 border font-bold">Ficha</th>
                            <th class="py-2 px-4 border font-bold">Jornada</th>
                            <th class="py-2 px-4 border font-bold">Instructor</th>
                            <th class="py-2 px-4 border font-bold">Competencia y Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diasSemana as $index => $dia)
                        <tr data-index="{{ $index }}" class="{{ $dia->isWeekend() ? 'bg-gray-50' : '' }}">
                            <td class="py-2 px-4 border">
                                {{ strtr($dia->format('l'), [
                                    'Monday' => 'Lunes',
                                    'Tuesday' => 'Martes',
                                    'Wednesday' => 'Miércoles',
                                    'Thursday' => 'Jueves',
                                    'Friday' => 'Viernes',
                                    'Saturday' => 'Sábado',
                                    'Sunday' => 'Domingo'
                                ]) }}
                                <br>
                                <span class="text-sm text-gray-600">{{ $dia->format('d/m/Y') }}</span>
                                <input type="hidden" name="programaciones[{{$index}}][fecha]" value="{{ $dia->format('Y-m-d') }}">
                            </td>
                            <td class="py-2 px-4 border">
                                <select name="programaciones[{{$index}}][ambiente_id]" 
                                        class="w-full border border-gray-300 rounded p-2">
                                    <option value="">Seleccione el ambiente</option>
                                    @foreach($ambientes as $ambiente)
                                        <option value="{{ $ambiente->id }}">
                                            {{ $ambiente->numero }} - {{ $ambiente->alias }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 px-4 border">
                                <select name="programaciones[{{$index}}][ficha_id]" 
                                        class="w-full border border-gray-300 rounded p-2">
                                    <option value="">Seleccione la ficha</option>
                                    @foreach($fichas as $ficha)
                                        <option value="{{ $ficha->id }}">
                                            {{ $ficha->codigo_ficha }} - {{ $ficha->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 px-4 border">
                                <select name="programaciones[{{$index}}][jornada_id]" 
                                        class="w-full border border-gray-300 rounded p-2">
                                    <option value="">Seleccione la jornada</option>
                                    @foreach($jornadas as $jornada)
                                        <option value="{{ $jornada->id }}">
                                            {{ $jornada->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 px-4 border">
                                <select name="programaciones[{{$index}}][persona_id]" 
                                        class="w-full border border-gray-300 rounded p-2">
                                    <option value="">Seleccione el instructor</option>
                                    @foreach($instructores as $instructor)
                                        <option value="{{ $instructor->id }}">
                                            {{ $instructor->pnombre }} {{ $instructor->papellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 px-4 border">
                                <div class="space-y-2">
                                    <select name="programaciones[{{$index}}][competencia_id]" 
                                            class="w-full border border-gray-300 rounded p-2 competencia-select"
                                            onchange="cargarResultados(this, {{$index}})">
                                        <option value="">Seleccione la competencia</option>
                                        @foreach($competencias as $competencia)
                                            <option value="{{ $competencia->id }}">
                                                {{ $competencia->codigo }} - 
                                                {{ Str::limit($competencia->descripcion, 50) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <select name="programaciones[{{$index}}][resultado_aprendizaje_id]" 
                                            class="w-full border border-gray-300 rounded p-2 mt-2 resultado-select"
                                            disabled>
                                        <option value="">Primero seleccione una competencia</option>
                                    </select>

                                    <div class="text-xs text-gray-600 mt-1" id="horas-info-{{$index}}"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="display:inline-block;">
                <button type="button" 
                        class="copiar-anterior btn btn-success">
                    Copiar día anterior
                </button>
                <a href="{{ route('ambiente-programacion.index') }}" 
                   class="btn btn-secondary">
                    Cancelar
                </a>
          
            </div>
            <button type="submit" 
                        class="btn btn-success">
                    Guardar Programación
                </button>
        </form>


@push('scripts')
<script>
// Almacenar los resultados como variable global
const resultadosAprendizaje = @json($resultadosAprendizaje);

function cargarResultados(selectCompetencia, index) {
    const competenciaId = selectCompetencia.value;
    const resultadoSelect = document.querySelector(`select[name="programaciones[${index}][resultado_aprendizaje_id]"]`);
    const horasInfo = document.getElementById(`horas-info-${index}`);
    
    if (competenciaId) {
        // Filtrar resultados por competencia
        const resultadosCompetencia = resultadosAprendizaje.filter(
            r => r.competencia_id == competenciaId && r.horas_disponibles >= 6
        );

        resultadoSelect.innerHTML = '<option value="">Seleccione el resultado</option>';
        
        resultadosCompetencia.forEach(resultado => {
            resultadoSelect.innerHTML += `
                <option value="${resultado.id}">
                    ${resultado.codigo} - ${resultado.descripcion}
                    (${resultado.horas_disponibles} horas disponibles)
                </option>
            `;
        });

        if (resultadosCompetencia.length > 0) {
            resultadoSelect.disabled = false;
            horasInfo.textContent = '';
        } else {
            resultadoSelect.disabled = true;
            horasInfo.textContent = 'No hay resultados disponibles con suficientes horas';
            Swal.fire({
                title: 'Atención',
                text: 'No hay resultados disponibles con suficientes horas',
                icon: 'warning',
                timer: 3000,
                timerProgressBar: true
            });
        }
    } else {
        resultadoSelect.innerHTML = '<option value="">Primero seleccione una competencia</option>';
        resultadoSelect.disabled = true;
        horasInfo.textContent = '';
    }
}

async function verificarDisponibilidadInstructor(fecha, jornadaId, personaId, index) {
    const horasInfo = document.getElementById(`horas-info-${index}`);
    
    try {
        if (fecha && jornadaId && personaId) {
            horasInfo.textContent = 'Verificando disponibilidad del instructor...';
        }
    } catch (error) {
        console.error('Error al verificar disponibilidad:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al verificar disponibilidad del instructor',
            icon: 'error'
        });
    }
}

async function verificarDisponibilidadAmbiente(fecha, jornadaId, ambienteId, index) {
    const horasInfo = document.getElementById(`horas-info-${index}`);
    
    try {
        if (fecha && jornadaId && ambienteId) {
            horasInfo.textContent = 'Verificando disponibilidad del ambiente...';
        }
    } catch (error) {
        console.error('Error al verificar disponibilidad:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al verificar disponibilidad del ambiente',
            icon: 'error'
        });
    }
}

function copiarDiaAnterior(index) {
    if (index === 0) return;

    const filaAnterior = document.querySelector(`tr[data-index="${index - 1}"]`);
    const filaActual = document.querySelector(`tr[data-index="${index}"]`);

    if (!filaAnterior || !filaActual) return;

    const selectsAnterior = filaAnterior.querySelectorAll('select');
    const selectsActual = filaActual.querySelectorAll('select');

    selectsAnterior.forEach((select, i) => {
        if (select.value) {
            selectsActual[i].value = select.value;
            if (select.classList.contains('competencia-select')) {
                cargarResultados(selectsActual[i], index);
                
                setTimeout(() => {
                    const resultadoSelectActual = filaActual.querySelector('.resultado-select');
                    const resultadoSelectAnterior = filaAnterior.querySelector('.resultado-select');
                    if (resultadoSelectActual && resultadoSelectAnterior.value) {
                        resultadoSelectActual.value = resultadoSelectAnterior.value;
                    }
                }, 100);
            }
        }
    });
}

// Validación del formulario
function validarFormulario(form) {
    const errores = [];
    let hayProgramaciones = false;

    document.querySelectorAll('tbody tr').forEach((fila, index) => {
        const selects = fila.querySelectorAll('select');
        const valores = Array.from(selects).map(select => select.value);
        const fecha = fila.querySelector('input[type="hidden"]').value;
        const diaFormateado = new Date(fecha).toLocaleDateString();

        if (valores.some(value => value)) {
            if (valores.some(value => !value)) {
                errores.push(`Día ${diaFormateado}: Debe completar todos los campos o dejarlos todos vacíos.`);
            } else {
                hayProgramaciones = true;
            }
        }

        const resultadoSelect = fila.querySelector(`select[name="programaciones[${index}][resultado_aprendizaje_id]"]`);
        if (resultadoSelect && resultadoSelect.value) {
            const resultado = resultadosAprendizaje.find(r => r.id == resultadoSelect.value);
            if (resultado && resultado.horas_disponibles < 6) {
                errores.push(`Día ${diaFormateado}: El resultado de aprendizaje no tiene suficientes horas disponibles.`);
            }
        }
    });

    if (!hayProgramaciones) {
        Swal.fire({
            title: '¡Error!',
            text: 'Debe completar al menos una programación.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        return false;
    }

    if (errores.length > 0) {
        Swal.fire({
            title: '¡Error!',
            html: errores.join('<br>'),
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        return false;
    }

    return true;
}

// Event Listeners cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Botón de copiar programación anterior
    const copiarAnteriorBtn = document.querySelector('.copiar-anterior');
    if (copiarAnteriorBtn) {
        copiarAnteriorBtn.addEventListener('click', function() {
            const filas = document.querySelectorAll('tbody tr');
            for(let i = 1; i < filas.length; i++) {
                copiarDiaAnterior(i);
            }
            Swal.fire({
                icon: 'success',
                title: '¡Completado!',
                text: 'Se ha copiado la programación del día anterior',
                timer: 2000,
                showConfirmButton: false
            });
        });
    }

    // Event listeners para los selectores
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function() {
            const fila = this.closest('tr');
            const index = fila.dataset.index;

            if (this.classList.contains('competencia-select')) {
                cargarResultados(this, index);
            }

            const fecha = fila.querySelector('input[type="hidden"]').value;
            const jornadaId = fila.querySelector(`select[name="programaciones[${index}][jornada_id]"]`).value;
            const ambienteId = fila.querySelector(`select[name="programaciones[${index}][ambiente_id]"]`).value;
            const personaId = fila.querySelector(`select[name="programaciones[${index}][persona_id]"]`).value;

            if (this.name.includes('ambiente_id')) {
                verificarDisponibilidadAmbiente(fecha, jornadaId, ambienteId, index);
            }
            if (this.name.includes('persona_id')) {
                verificarDisponibilidadInstructor(fecha, jornadaId, personaId, index);
            }
        });
    });

    // Validación del formulario
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validarFormulario(this)) {
                return false;
            }

            // Si pasa la validación, mostrar confirmación
            Swal.fire({
                title: '¿Está seguro?',
                text: "¿Desea guardar esta programación?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Enviar el formulario
                }
            });
        });
    }

    // Mostrar mensajes de error del servidor si existen
    @if(Session::has('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ Session::get('error') }}",
            confirmButtonText: 'Aceptar'
        });
    @endif

    // Mostrar mensajes de éxito del servidor si existen
    @if(Session::has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: "{{ Session::get('success') }}",
            confirmButtonText: 'Aceptar'
        });
    @endif
});
</script>
@endpush
@endsection