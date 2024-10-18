document.addEventListener('DOMContentLoaded', function() {
    // Capturar todos los enlaces de la barra de navegación
    document.querySelectorAll('.opcion-barra-navegacion').forEach(function(enlace) {
        enlace.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del enlace
            const url = this.getAttribute('href');
            
            // Seleccionar todos los elementos de texto dentro del contenido principal
            const textos = document.querySelectorAll('h1, h2, h3, p, span, div, a');
            
            // Aplicar la clase de animación de salida a todos los textos
            textos.forEach(function(texto) {
                texto.classList.add('fade-out-text');
            });

            // Esperar a que termine la animación antes de navegar a la nueva vista
            setTimeout(function() {
                window.location.href = url;
            }, 300); // 500 ms coincide con la duración de la transición CSS
        });
    });
});
