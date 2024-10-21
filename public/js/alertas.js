function getSwalTheme() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        return {
            background: '#333333', // Fondo oscuro
            color: '#ffffff', // Texto blanco
            confirmButtonColor: '#007832', // Color del botón y el ícono en modo oscuro
        };
    }
    return {
        background: '#ffffff', // Fondo claro
        color: '#000000', // Texto negro
        confirmButtonColor: '#39A900', // Color del botón y el ícono en modo claro
    };
}

function mensajeDeExito(mensaje) {
    const theme = getSwalTheme(); // Obtener tema
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: mensaje,
        confirmButtonColor: theme.confirmButtonColor, // Color del botón
        confirmButtonText: 'Aceptar',
        background: theme.background, // Aplicar fondo según el tema
        color: theme.color, // Aplicar color del texto
        iconColor: theme.confirmButtonColor, // Hacer el ícono del mismo color que el botón
    });
}

function mensajeDeError(mensaje) {
    const theme = getSwalTheme(); 
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje,
        confirmButtonColor: theme.confirmButtonColor, // Color del botón
        confirmButtonText: 'Aceptar',
        background: theme.background,
        color: theme.color,
        iconColor: theme.confirmButtonColor, // Hacer el ícono del mismo color que el botón
    });
}

function mensajeDeAdvertencia(mensaje) {
    const theme = getSwalTheme();
    Swal.fire({
        icon: 'warning',
        title: 'Advertencia',
        text: mensaje,
        confirmButtonColor: theme.confirmButtonColor, // Color del botón
        confirmButtonText: 'Aceptar',
        background: theme.background,
        color: theme.color,
        iconColor: theme.confirmButtonColor, // Hacer el ícono del mismo color que el botón
    });
}

function mensajeDeEliminacion(event, idElemento, nombreElemento, seccionElemento) {
    event.preventDefault(); // Evita el envío inmediato del formulario
    const theme = getSwalTheme();
    let mensaje = `¿Seguro que desea eliminar el elemento: ${nombreElemento}, con id: ${idElemento}, de la sección de: ${seccionElemento}?`;

    Swal.fire({
        icon: 'question',
        title: 'Advertencia',
        text: mensaje,
        showCancelButton: true,
        confirmButtonColor: theme.confirmButtonColor, // Color del botón
        confirmButtonText: 'Aceptar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        background: theme.background,
        color: theme.color,
        iconColor: theme.confirmButtonColor, // Hacer el ícono del mismo color que el botón
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`formularioEliminar-${idElemento}`).submit();
        }
    });
}

function mensajeDetalleError(errores) {
    const theme = getSwalTheme();
    let errorMessage = "";

    errores.forEach(error => {
        errorMessage += error + "\n";
    });

    Swal.fire({
        icon: 'error',
        title: 'Por favor corrija los siguientes errores:',
        text: errorMessage,
        confirmButtonColor: theme.confirmButtonColor, // Color del botón
        confirmButtonText: 'Aceptar',
        background: theme.background,
        color: theme.color,
        iconColor: theme.confirmButtonColor, // Hacer el ícono del mismo color que el botón
    });
}
