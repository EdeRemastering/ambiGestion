@extends('layouts.app')
@section('titulo', 'Programación Semanal de Ambientes')
@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Reemplaza el div del encabezado existente con este nuevo --}}
<div class="mb-6">
    {{-- Encabezado con títulos y navegación --}}
    <div class="flex flex-col space-y-4 mb-6">
   

        {{-- Navegación de Semanas --}}
        <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow">
            {{-- Información de la semana actual --}}
            <div class="text-center flex-grow">
                <h4 class="text-lg font-semibold text-gray-700">
                    Semana del: {{ $diasSemana[0]->format('d/m/Y') }} al {{ $diasSemana[6]->format('d/m/Y') }}
                </h4>
            </div>
            
            {{-- Botones de navegación --}}
            <div class="flex space-x-4">
                <a href="{{ route('ambiente-programacion.create', ['fecha_inicio' => $semanaAnterior]) }}" 
                   class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Semana Anterior
                </a>

                <a href="{{ route('ambiente-programacion.create', ['fecha_inicio' => $semanaSiguiente]) }}" 
                   class="btn btn-success">
                    Semana Siguiente
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
               
                <a href="{{ route('ambiente-programacion.index') }}" 
                   class="flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Volver al Listado
                </a>
            </div>
        </div>
    </div>

        {{-- Mensajes de Error --}}
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Formulario Principal --}}
        <form action="{{ route('ambiente-programacion.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            
            <div class="overflow-x-auto">
                {{-- Información de la Semana --}}
                <div class="mb-4 text-center">
                    <p class="text-lg font-semibold text-gray-700">
                        Semana del: {{ $diasSemana[0]->format('d/m/Y') }} al {{ $diasSemana[6]->format('d/m/Y') }}
                    </p>
                </div>

                {{-- Tabla de Programación --}}
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
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

            {{-- Botones de Acción --}}
            <div class="flex items-center justify-end mt-6 gap-4">
                
                <a href="{{ route('ambiente-programacion.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Cancelar
                </a>
                <button type="submit" 
                        class="btn btn-success boton-crear">
                    Guardar Programación
                </button>
            </div>
        </form>
    </div>
</div>

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
            const response = await fetch(`/verificar-disponibilidad-instructor?fecha=${fecha}&jornada_id=${jornadaId}&persona_id=${personaId}`);
            const data = await response.json();
            
            if (!data.disponible) {
                horasInfo.textContent = 'El instructor no está disponible en este horario';
                Swal.fire({
                    title: 'Atención',
                    text: 'El instructor ya tiene una programación en este horario',
                    icon: 'warning'
                });
            }
        }
    } catch (error) {
        console.error('Error al verificar disponibilidad:', error);
    }
}

async function verificarDisponibilidadAmbiente(fecha, jornadaId, ambienteId, index) {
    const horasInfo = document.getElementById(`horas-info-${index}`);
    
    try {
        if (fecha && jornadaId && ambienteId) {
            const response = await fetch(`/verificar-disponibilidad-ambiente?fecha=${fecha}&jornada_id=${jornadaId}&ambiente_id=${ambienteId}`);
            const data = await response.json();
            
            if (!data.disponible) {
                horasInfo.textContent = 'El ambiente no está disponible en este horario';
                Swal.fire({
                    title: 'Atención',
                    text: 'El ambiente ya está ocupado en este horario',
                    icon: 'warning'
                });
            }
        }
    } catch (error) {
        console.error('Error al verificar disponibilidad:', error);
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

async function cargarProgramacionSemanaAnterior() {
    try {
        // Mostrar loading
        Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo programación de la semana anterior',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Obtener la fecha actual de la vista
        const primeraFecha = document.querySelector('input[type="hidden"][name="programaciones[0][fecha]"]').value;
        
        // Obtener programaciones de la semana anterior
        const response = await fetch(`/ambiente-programacion/semana-anterior/${primeraFecha}`);
        const data = await response.json();

        if (!data.success) {
            throw new Error(data.message || 'Error al obtener la programación');
        }

        if (data.programaciones.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Sin programaciones',
                text: 'No hay programaciones en la semana anterior para copiar.'
            });
            return;
        }

        // Iterar sobre las filas de la tabla actual
        document.querySelectorAll('tbody tr').forEach((fila, index) => {
            const fechaActual = fila.querySelector('input[type="hidden"]').value;
            
            // Buscar programación correspondiente por día de la semana
            const diaActual = new Date(fechaActual).getDay();
            const programacion = data.programaciones.find(p => 
                new Date(p.fecha).getDay() === diaActual
            );

            if (programacion) {
                // Actualizar campos básicos
                const selects = {
                    ambiente: fila.querySelector(`select[name="programaciones[${index}][ambiente_id]"]`),
                    ficha: fila.querySelector(`select[name="programaciones[${index}][ficha_id]"]`),
                    jornada: fila.querySelector(`select[name="programaciones[${index}][jornada_id]"]`),
                    persona: fila.querySelector(`select[name="programaciones[${index}][persona_id]"]`),
                    competencia: fila.querySelector(`select[name="programaciones[${index}][competencia_id]"]`)
                };

                // Actualizar cada select si existe
                if (selects.ambiente) selects.ambiente.value = programacion.ambiente_id;
                if (selects.ficha) selects.ficha.value = programacion.ficha_id;
                if (selects.jornada) selects.jornada.value = programacion.jornada_id;
                if (selects.persona) selects.persona.value = programacion.persona_id;
                
                // Actualizar competencia y disparar evento para cargar resultados
                if (selects.competencia) {
                    selects.competencia.value = programacion.competencia_id;
                    selects.competencia.dispatchEvent(new Event('change'));

                    // Esperar a que se carguen los resultados y seleccionar el correcto
                    setTimeout(() => {
                        const resultadoSelect = fila.querySelector(`select[name="programaciones[${index}][resultado_aprendizaje_id]"]`);
                        if (resultadoSelect && !resultadoSelect.disabled) {
                            resultadoSelect.value = programacion.resultado_aprendizaje_id;
                        }
                    }, 500);
                }
            }
        });

        Swal.fire({
            icon: 'success',
            title: '¡Completado!',
            text: 'Se ha copiado la programación de la semana anterior',
            timer: 2000,
            showConfirmButton: false
        });

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al copiar la programación'
        });
    }
}

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

    // Botón para copiar semana anterior
    const btnCopiarSemanaAnterior = document.getElementById('copiarSemanaAnterior');
    if (btnCopiarSemanaAnterior) {
        btnCopiarSemanaAnterior.addEventListener('click', cargarProgramacionSemanaAnterior);
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
                    this.submit();
                }
            });
        });
    }

    // Mostrar mensajes de error del servidor
    @if(Session::has('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ Session::get('error') }}",
            confirmButtonText: 'Aceptar'
        });
    @endif

    // Mostrar mensajes de éxito del servidor
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