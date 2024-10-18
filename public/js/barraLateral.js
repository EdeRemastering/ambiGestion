
document.getElementById('alternarBarraLateral').addEventListener('click', function() {
    const barraLateral = document.getElementById('barraLateral');
    const contenido = document.getElementById('contenido');
    const barraNavegacion = document.querySelector('.barra-navegacion');
    
    // Alternar clases minimizadas
    barraLateral.classList.toggle('minimizada');
    contenido.classList.toggle('minimizado');
    barraNavegacion.classList.toggle('minimizada');

    // Guardar el estado en localStorage
    if (barraLateral.classList.contains('minimizada')) {
        localStorage.setItem('barraMinimizada', 'true');
    } else {
        localStorage.setItem('barraMinimizada', 'false');
    }
});

// Al cargar la página, comprobar el estado guardado
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

   
});


