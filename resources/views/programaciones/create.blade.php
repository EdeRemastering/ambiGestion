@extends('layouts.app')

@section('titulo', 'Crear Programación')

@section('contenido')
<div class="contenedor-principal">
    <div class="contenedor-secundario">
        <!-- Formulario de creación de programación -->
        <form action="{{ route('programaciones.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="ficha">Ficha:</label>
                <select name="ficha" id="ficha" class="form-control">
                        <option value="">Seleccione una ficha</option>
                    @foreach ($fichas as $ficha)
                        <option value="{{ $ficha->id_ficha }}" data-jornada="{{ strtolower($ficha->jornada_nombre) }}">
                            {{ $ficha->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ambiente">Ambiente:</label>
                <select name="ambiente" id="ambiente" class="form-control">
                        <option value="">Seleccione un ambiente</option>
                    @foreach ($ambientes as $ambiente)
                        <option value="{{ $ambiente->id }}">{{ $ambiente->alias }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group two-columns">
                <label for="dias">Día/s e Instructores:</label><br>
                @foreach ($dias as $dia)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" id="dia_{{ $dia->id }}" value="{{ $dia->id }}">
                        <label class="form-check-label" for="dia_{{ $dia->id }}">{{ $dia->nombre }}</label>

                        <select name="instructor_dia[{{ $dia->id }}]" class="form-control">
                            <option value="">Seleccione un instructor</option>
                            @foreach ($instructores as $instructor)
                                <option value="{{ $instructor->id }}">
                                    {{ $instructor->pnombre }} {{ $instructor->snombre }} {{ $instructor->papellido }} {{ $instructor->sapellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <label for="hora_inicio">Hora de Inicio:</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="hora_fin">Hora de Fin:</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
            </div>

            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Crear Programación</button>
        </form>
    </div>
</div>

<!-- Lógica para gestionar la selección de jornadas y las horas automáticas -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM completamente cargado y analizado.');

        const fichaSelect = document.getElementById('ficha');
        const horaInicio = document.getElementById('hora_inicio');
        const horaFin = document.getElementById('hora_fin');

        // Al cambiar la ficha, se ajustan las horas según la jornada
        fichaSelect.addEventListener('change', function () {
            console.log('Cambio detectado en la ficha.');
            const selectedFicha = fichaSelect.options[fichaSelect.selectedIndex];
            const jornada = selectedFicha.getAttribute('data-jornada');
            console.log(`Ficha seleccionada: ${selectedFicha.text}, Jornada: ${jornada}`);

            if (jornada) {
                ajustarHorasPorJornada(jornada);
            } else {
                console.log('No se encontró una jornada para la ficha seleccionada.');
            }
        });

        // Función para ajustar las horas según la jornada
        function ajustarHorasPorJornada(jornada) {
            console.log(`Ajustando horas para la jornada: ${jornada}`);
            if (jornada === 'mañana') {
                setHoras('07:00', '13:00');
            } else if (jornada === 'tarde') {
                setHoras('13:00', '19:00');
            } else if (jornada === 'diurna') {
                setHoras('19:00', '22:00');
            } else {
                console.log('Jornada desconocida, no se ajustarán las horas.');
            }
        }

        // Función para establecer las horas en los inputs de tipo time
        function setHoras(horaInicioValor, horaFinValor) {
            console.log(`Estableciendo horas: Inicio - ${horaInicioValor}, Fin - ${horaFinValor}`);
            horaInicio.value = horaInicioValor;
            horaFin.value = horaFinValor;
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');


        // Escuchar el cambio en el campo de fecha de inicio
        fechaInicio.addEventListener('change', function () {
            const fechaSeleccionada = new Date(fechaInicio.value);

            // Formatear la fecha seleccionada como YYYY-MM-DD para usarla en el input "fecha_fin"
            const year = fechaSeleccionada.getFullYear();
            const month = String(fechaSeleccionada.getMonth() + 1).padStart(2, '0'); // Mes de 0 a 11, por eso +1
            const day = String(fechaSeleccionada.getDate() + 2).padStart(2, '0');

            // Establecer la fecha mínima en el campo de fecha fin
            fechaFin.min = `${year}-${month}-${day}`;
        });
    });
</script>   

@endsection
