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
        <button class="dropdown-item">
        @php
use App\Models\Personas; // Asegúrate de que el namespace sea correcto

// Obtener el usuario autenticado
$user = Auth::user();

// Consultar la tabla personas según el user_id del usuario actual
$persona = Personas::where('user_id', $user->id)->first();
@endphp

            <a href="{{ route('personas.settings', $persona->id ) }}" style="text-decoration: none; color: inherit;">Ajustes</a>
        </button>
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
    <a href="{{ route('dashboard') }}" class="opcion-barra-navegacion {{ Request::is('dashboard') ? 'active' : '' }}"><i class="bi bi-house"></i> <span class="texto-barra-lateral">Inicio</span></a>
    @if(Auth::user()->role->name == 'admin')
    <a href="{{ route('personas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/personas*') ? 'active' : '' }}"><i class="bi bi-people"></i> <span class="texto-barra-lateral">Personas</span></a>
    @endif
    @if(Auth::user()->role->name == 'admin' || Auth::user()->role->name == 'instructor_lider')
    <a href="{{ route('ambientes.index') }}" class="opcion-barra-navegacion {{ Request::is('*/ambientes*') ? 'active' : '' }}"><i class="bi bi-building"></i> <span class="texto-barra-lateral">Ambientes</span></a>
    <a href="{{ route('recursos.index') }}" class="opcion-barra-navegacion {{ Request::is('*/recursos*') ? 'active' : '' }}"><i class="bi bi-box"></i> <span class="texto-barra-lateral">Recursos</span></a>
    <a href="{{ route('novedades.index') }}" class="opcion-barra-navegacion {{ Request::is('*/novedades*') ? 'active' : '' }}"><i class="bi bi-bell"></i> <span class="texto-barra-lateral">Novedades</span></a>
    <a href="{{ route('fichas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/fichas*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i> <span class="texto-barra-lateral">Fichas</span></a>
    <a href="{{ route('programas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/programas*') ? 'active' : '' }}"><i class="bi bi-journal-bookmark"></i> <span class="texto-barra-lateral">Programas</span></a>
    <a href="{{ route('programaciones.index') }}" class="opcion-barra-navegacion {{ Request::is('*/programacion*') ? 'active' : '' }}"><i class="bi bi-calendar"></i> <span class="texto-barra-lateral">Programaciones</span></a>
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
