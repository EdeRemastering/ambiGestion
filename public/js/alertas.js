function mensajeDeExito(mensaje) {
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: mensaje,
        confirmButtonColor: '#39A900',
        confirmButtonText: 'Aceptar',
    });
}

function mensajeDeError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje,
        confirmButtonColor: '#39A900',
        confirmButtonText: 'Aceptar',
    });
}

function mensajeDeAdvertencia(mensaje) {
    Swal.fire({
        icon: 'warning',
        title: 'Advertencia',
        text: mensaje,
        confirmButtonColor: '#39A900',
        confirmButtonText: 'Aceptar',
    });
}


function mensajeDeEliminacion(event, idElemento, nombreElemento, seccionElemento) {
    event.preventDefault(); // Evita el envío inmediato del formulario
    
    let mensaje = `¿Seguro que desea eliminar el elemento: ${nombreElemento}, con id: ${idElemento}, de la sección de: ${seccionElemento}?`;
   
    Swal.fire({
        icon: 'question',
        title: 'Advertencia',
        text: mensaje,
        showCancelButton: true, // Muestra el botón de cancelar
        confirmButtonColor: '#39A900',
        confirmButtonText: 'Aceptar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if(result.isConfirmed) {
            // Si el usuario confirma, se envía el formulario
            document.getElementById(`formularioEliminar-${idElemento}`).submit();
        }
    });
}

function mensajeDetalleError(errores) {
    let errorMessage = "";

    // Iterar sobre el array de errores en JavaScript
    errores.forEach(error => {
        errorMessage += error + "\n";
    });

    // Mostrar la alerta con los errores
    Swal.fire({
        icon: 'error',
        title: 'Por favor corrija los siguientes errores:',
        text: errorMessage,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
    });
}