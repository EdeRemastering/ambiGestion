<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmbiGestión</title>

    <!-- Favicon básico -->
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

    @include('partials.estilos')
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
            <button class="dropdown-item" href="">Ajustes</button>
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
   
    <h2>
        <img class="icono-barra-lateral" src="{{asset('img/logosena.png')}}" style="width: 100px;" alt="">
    </h2>
    <a href="{{ route('home') }}" class="opcion-barra-navegacion {{ Request::is('home') ? 'active' : '' }}"><i class="bi bi-house"></i> <span class="texto-barra-lateral">Inicio</span></a>
    @if(Auth::user()->role->name == 'admin')
    <a href="{{ route('personas.index') }}" class="opcion-barra-navegacion {{ Request::is('personas*') ? 'active' : '' }}"><i class="bi bi-people"></i> <span class="texto-barra-lateral">Personas</span></a>
    @endif
    @if(Auth::user()->role->name == 'admin' || Auth::user()->role->name == 'instructor')
        <a href="{{ route('ambientes.index') }}" class="opcion-barra-navegacion {{ Request::is('admin/ambientes*') ? 'active' : '' }}"><i class="bi bi-building"></i> <span class="texto-barra-lateral">Ambientes</span></a>
        <a href="{{ route('recursos.index') }}" class="opcion-barra-navegacion {{ Request::is('admin/recursos*') ? 'active' : '' }}"><i class="bi bi-box"></i> <span class="texto-barra-lateral">Recursos</span></a>
        <a href="{{ route('novedades.index') }}" class="opcion-barra-navegacion {{ Request::is('admin/novedades*') ? 'active' : '' }}"><i class="bi bi-bell"></i> <span class="texto-barra-lateral">Novedades</span></a>
        <a href="{{ route('fichas.index') }}" class="opcion-barra-navegacion {{ Request::is('admin/fichas*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i> <span class="texto-barra-lateral">Fichas</span></a>
        <a href="{{ route('programas.index') }}" class="opcion-barra-navegacion {{ Request::is('admin/programas*') ? 'active' : '' }}"><i class="bi bi-journal-bookmark"></i> <span class="texto-barra-lateral">Programas</span></a>
    @endif
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

@include('partials.scripts')
<!-- Sección para incluir scripts adicionales en vistas específicas -->
@yield('scripts')

</body>
</html>
