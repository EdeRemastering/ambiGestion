
// Lógica para gestionar la selección de jornadas y las horas automáticas -->

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM completamente cargado y analizado.');

    const fichaSelect = document.getElementById('ficha');
    const horaInicio = document.getElementById('hora_inicio');
    const horaFin = document.getElementById('hora_fin');

    if (horaInicio == null || horaFin == null) {
        return console.log("no hay horas para restringir")
    }
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