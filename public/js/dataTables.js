// Aquí una función que se encarga de buscar el estado del elemento que se clickea
document.addEventListener('DOMContentLoaded', function() {
    // Obtener la ruta actual y dividirla
    let partesRuta = window.location.pathname.split('/').filter(part => part);

    // Seleccionar la parte específica de la ruta (asumiendo que la tabla se llama 'ambientesTable')
    let parteEspecifica = partesRuta.slice(partesRuta.length - 1).join('/');
    console.log('Parte específica:', parteEspecifica);

    // Generar el ID de la tabla dinámicamente basado en la ruta
    let tablaID = '#' + parteEspecifica + 'Table';
    console.log('Tabla ID:', tablaID);

    // Inicializar la tabla si no está ya inicializada
    let tabla;
    if (!$.fn.DataTable.isDataTable(tablaID)) {
        // Si no está inicializada, inicialízala
        tabla = $(tablaID).DataTable({
            scrollX: true, 
            paging: true,
            searching: true,
            ordering: true,
            lengthChange: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.1.7/i18n/es-MX.json'
            }
        });
    } else {
        // Si ya está inicializada, obtener la instancia existente
        tabla = $(tablaID).DataTable();
    }

    // Seleccionar los botones
    let botonesEstados = document.querySelectorAll('.botonEstado');
    // Añadir un evento a cada botón
    botonesEstados.forEach(function(boton) {
        boton.addEventListener('click', function() {
            console.log('Comenzó la función');
            // Obtener el texto del botón
            let elementosPorEstado = this.textContent;
            console.log('Texto del botón:', elementosPorEstado);

            // Separar el texto del botón en dos partes (nombre y valor)
            let textoBotonSeparado = elementosPorEstado.split(':');
            console.log('Texto separado:', textoBotonSeparado);

            // Obtener solo el nombre del estado (la primera parte)
            let nombreEstado = textoBotonSeparado[0].trim();
            console.log('Nombre del estado:', nombreEstado);

            // Ejecutar la búsqueda en la tabla con el estado seleccionado
            tabla.search(nombreEstado).draw();
        });
    });

    let botonesEstadoTotal = this.querySelectorAll('.botonEstadoTotal');
    console.log(botonesEstadoTotal);
    
    botonesEstadoTotal.forEach( (boton) => {
        boton.addEventListener('click', () => {
            console.log('Comenzó la segunda función');
            tabla.search('').draw();
        });
    });
});
 