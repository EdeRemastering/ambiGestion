document.addEventListener('DOMContentLoaded', function() {
    // Obtener la ruta actual y dividirla
    let partesRuta = window.location.pathname.split('/').filter(part => part);

    // Seleccionar la parte específica de la ruta
    let parteEspecifica = partesRuta.slice(partesRuta.length - 1).join('/');
    console.log('Parte específica:', parteEspecifica);

    // Generar el ID de la tabla dinámicamente basado en la ruta
    let tablaID = '#' + parteEspecifica + 'Table';
    console.log('Tabla ID:', tablaID);

    // Inicializar la tabla si no está ya inicializada
    let tabla;
    if (!$.fn.DataTable.isDataTable(tablaID)) {
        tabla = $(tablaID).DataTable({
            scrollX: true, 
            paging: true,
            searching: true,
            ordering: true,
            lengthChange: true,
            language: {
                "url": "https://cdn.datatables.net/plug-ins/2.1.7/i18n/es-MX.json"
            }
        });
    } else {
        tabla = $(tablaID).DataTable();
    }

    // Función para ajustar la tabla
    function ajustarTabla() {
        if (tabla) {
            setTimeout(() => {
                tabla.columns.adjust().draw();
            }, 300);
        }
    }

    // Manejar el cambio de estado del sidebar
    document.getElementById('alternarBarraLateral').addEventListener('click', function() {
        const barraLateral = document.getElementById('barraLateral');
        const contenido = document.getElementById('contenido');
        const barraNavegacion = document.querySelector('.barra-navegacion');
        
        barraLateral.classList.toggle('minimizada');
        contenido.classList.toggle('minimizado');
        barraNavegacion.classList.toggle('minimizada');

        if (barraLateral.classList.contains('minimizada')) {
            localStorage.setItem('barraMinimizada', 'true');
        } else {
            localStorage.setItem('barraMinimizada', 'false');
        }

        ajustarTabla();
    });

    // Ajustar la tabla cuando la ventana cambie de tamaño
    window.addEventListener('resize', ajustarTabla);

    // Comprobar el estado guardado al cargar la página
    window.addEventListener('load', function() {
        const barraLateral = document.getElementById('barraLateral');
        const contenido = document.getElementById('contenido');
        const barraNavegacion = document.querySelector('.barra-navegacion');
        
        const barraMinimizada = localStorage.getItem('barraMinimizada');
        if (barraMinimizada === 'true') {
            barraLateral.classList.add('minimizada');
            contenido.classList.add('minimizado');
            barraNavegacion.classList.add('minimizada');
        } else {
            barraLateral.classList.remove('minimizada');
            contenido.classList.remove('minimizado');
            barraNavegacion.classList.remove('minimizada');
        }

        ajustarTabla();
    });

    // Manejar los botones de estado
    let botonesEstados = document.querySelectorAll('.botonEstado');
    botonesEstados.forEach(function(boton) {
        boton.addEventListener('click', function() {
            let elementosPorEstado = this.textContent;
            let textoBotonSeparado = elementosPorEstado.split(':');
            let nombreEstado = textoBotonSeparado[0].trim();
            tabla.search(nombreEstado).draw();
        });
    });

    let botonesEstadoTotal = document.querySelectorAll('.botonEstadoTotal');
    botonesEstadoTotal.forEach((boton) => {
        boton.addEventListener('click', () => {
            tabla.search('').draw();
        });
    });
});