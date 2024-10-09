<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'SENA')</title>

 
    <!-- Fuentes de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS de Bootstrap y archivos personalizados -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Íconos de Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formularios.css') }}">

    <!-- Estilos para SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/alertas.js') }}"></script>
    
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('modo-oscuro');
            }
        })();
    </script>

    <!-- Sección para incluir estilos adicionales en vistas específicas -->
    @yield('estilos')
</head>
<body>

<header class="barra-navegacion">
    <div>
        <!-- Botón para alternar la barra lateral -->
        <button id="alternarBarraLateral" class="btn btn-light">☰</button>

        <!-- Botón para volver atrás -->
        <button class="btn btn-light" onclick="goBack()" aria-label="Volver atrás">
            <i class="bi bi-arrow-left"></i> <!-- Flecha hacia atrás de Bootstrap Icons -->
        </button>
    </div>
  

    <!-- Título dinámico -->
    <div><h2>@yield('titulo', 'Mi título')</h2></div>
    
    <!-- Menú de perfil -->
    <div class="dropdown" style="position: relative;">
        <button class="btn btn-light dropdown-toggle" type="button" id="menuPerfil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menuPerfil">
            <a class="dropdown-item" href="">Ajustes</a>
            <div class="dropdown-divider"></div>
            <button id="modoOscuroToggle" class="dropdown-item">Cambiar Modo</button>
            <div class="dropdown-divider"></div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="dropdown-item">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</header>


<!-- Barra lateral -->
<div class="barra-lateral" id="barraLateral">
    <h2><a href="{{ route('home') }}" class="texto-barra-lateral">SENA</a></h2>
    <a href="{{ route('home') }}" class="opcion-barra-navegacion {{ Request::is('home') ? 'active' : '' }}"><i class="bi bi-house"></i> <span class="texto-barra-lateral">Inicio</span></a>
    <a href="{{ route('personas.index') }}" class="opcion-barra-navegacion {{ Request::is('personas*') ? 'active' : '' }}"><i class="bi bi-people"></i> <span class="texto-barra-lateral">Personas</span></a>
    <a href="{{ route('ambientes.index') }}" class="opcion-barra-navegacion {{ Request::is('ambientes*') ? 'active' : '' }}"><i class="bi bi-building"></i> <span class="texto-barra-lateral">Ambientes</span></a>
    <a href="{{ route('recursos.index') }}" class="opcion-barra-navegacion {{ Request::is('recursos*') ? 'active' : '' }}"><i class="bi bi-box"></i> <span class="texto-barra-lateral">Recursos</span></a>
    <a href="{{ route('novedades.index') }}" class="opcion-barra-navegacion {{ Request::is('novedades*') ? 'active' : '' }}"><i class="bi bi-bell"></i> <span class="texto-barra-lateral">Novedades</span></a>
</div>

<!-- Contenido principal -->
<section class="contenido" id="contenido">
    <div class="contenido-principal">

    <div class="seccionEstatus">
        @yield('estados')
   </div>
       @yield('contenido')

       @if(session('success'))
            <script>mensajeDeExito("{{session('success')}}");</script>
        @endif
        
        @if(session('error'))
            <script>mensajeDeError("{{ session('error') }}");</script>
        @endif

        @if(session('warning'))
            <script>mensajeDeAdvertencia("{{ session('warning') }}");</script>
        @endif 


    </div>
</section>

<!-- Scripts comunes -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- JS de DataTables -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<!-- Script para minimizar la barra lateral -->
<script>
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

    function goBack() {
        window.history.back();
    }
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('modoOscuroToggle').addEventListener('click', function() {
                document.documentElement.classList.toggle('modo-oscuro');
                const theme = document.documentElement.classList.contains('modo-oscuro') ? 'dark' : 'light';
                localStorage.setItem('theme', theme);
            });
        });
</script>


<script src="{{ asset('js/app.js') }}"></script>


<!-- Sección para incluir scripts adicionales en vistas específicas -->
@yield('scripts')

</body>
</html>
