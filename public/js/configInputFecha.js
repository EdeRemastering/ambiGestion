
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
