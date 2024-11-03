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
            <button id="modoOscuroToggle" class="dropdown-item">Cambiar Tema</button>
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

    @auth
    @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('reportes-programacion.index') }}" class="opcion-barra-navegacion {{ Request::is('*/reportes-programacion*') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span class="texto-barra-lateral">Dashboard</span>
        </a>
        <a href="{{ route('ambiente-programacion.index') }}" class="opcion-barra-navegacion {{ Request::is('*/ambiente-programacion*') ? 'active' : '' }}">
            <i class="bi bi-calendar4-event"></i> <span class="texto-barra-lateral">Programación</span>
        </a>
        <a href="{{ route('red_conocimiento.index') }}" class="opcion-barra-navegacion {{ Request::is('*/red_conocimiento*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> <span class="texto-barra-lateral">Red de Conocimiento</span>
        </a>
        <a href="{{ route('programas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/programas*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> <span class="texto-barra-lateral">Programa de Formación</span>
        </a>
        <a href="{{ route('fichas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/fichas*') ? 'active' : '' }}">
            <i class="bi bi-card-list"></i> <span class="texto-barra-lateral">Fichas</span>
        </a>
        <a href="{{ route('jornadas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/jornadas*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> <span class="texto-barra-lateral">Jornadas</span>
        </a>
        <a href="{{ route('competencias.index') }}" class="opcion-barra-navegacion {{ Request::is('*/competencias*') ? 'active' : '' }}">
            <i class="bi bi-award"></i> <span class="texto-barra-lateral">Competencias</span>
        </a>
        <a href="{{ route('resultados_aprendizaje.index') }}" class="opcion-barra-navegacion {{ Request::is('*/resultados_aprendizaje*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i> <span class="texto-barra-lateral">Resultado de Aprendizaje</span>
        </a>
        <a href="{{ route('recursos.index') }}" class="opcion-barra-navegacion {{ Request::is('*/recursos*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> <span class="texto-barra-lateral">Recursos</span>
        </a>
        <a href="{{ route('novedades.index') }}" class="opcion-barra-navegacion {{ Request::is('*/novedades*') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> <span class="texto-barra-lateral">Novedades</span>
        </a>
        <a href="{{ route('ambientes.index') }}" class="opcion-barra-navegacion {{ Request::is('*/ambientes*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> <span class="texto-barra-lateral">Ambientes</span>
        </a>
        <a href="{{ route('tipo-ambientes.index') }}" class="opcion-barra-navegacion {{ Request::is('*/tipo-ambientes*') ? 'active' : '' }}">
            <i class="bi bi-geo-alt"></i> <span class="texto-barra-lateral">Tipo Ambientes</span>
        </a>
        <a href="{{ route('estado-ambientes.index') }}" class="opcion-barra-navegacion {{ Request::is('*/estado-ambientes*') ? 'active' : '' }}">
            <i class="bi bi-lightbulb"></i> <span class="texto-barra-lateral">Estado Ambientes</span>
        </a>
        <a href="{{ route('personas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/personas*') ? 'active' : '' }}">
            <i class="bi bi-person"></i> <span class="texto-barra-lateral">Persona</span>
        </a>

    @elseif(auth()->user()->hasRole('instructor'))
        <a href="{{ route('reportes-programacion.instructor.diario') }}" class="opcion-barra-navegacion {{ Request::is('*/instructor/diario*') ? 'active' : '' }}">
            <i class="bi bi-calendar-day"></i> <span class="texto-barra-lateral">Reporte Diario</span>
        </a>
        <a href="{{ route('reportes-programacion.instructor.semanal') }}" class="opcion-barra-navegacion {{ Request::is('*/instructor/semanal*') ? 'active' : '' }}">
            <i class="bi bi-calendar-week"></i> <span class="texto-barra-lateral">Reporte Semanal</span>
        </a>
        <a href="{{ route('reportes-programacion.instructor.mensual') }}" class="opcion-barra-navegacion {{ Request::is('*/instructor/mensual*') ? 'active' : '' }}">
            <i class="bi bi-calendar-month"></i> <span class="texto-barra-lateral">Reporte Mensual</span>
        </a>
        <a href="{{ route('personas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/personas*') ? 'active' : '' }}">
            <i class="bi bi-person"></i> <span class="texto-barra-lateral">Persona</span>
        </a>

    @elseif(auth()->user()->hasRole('aprendiz'))
        <a href="{{ route('reportes-programacion.aprendiz.diario') }}" class="opcion-barra-navegacion {{ Request::is('*/aprendiz/diario*') ? 'active' : '' }}">
            <i class="bi bi-calendar-day"></i> <span class="texto-barra-lateral">Reporte Diario</span>
        </a>
        <a href="{{ route('reportes-programacion.aprendiz.semanal') }}" class="opcion-barra-navegacion {{ Request::is('*/aprendiz/semanal*') ? 'active' : '' }}">
            <i class="bi bi-calendar-week"></i> <span class="texto-barra-lateral">Reporte Semanal</span>
        </a>
        <a href="{{ route('reportes-programacion.aprendiz.mensual') }}" class="opcion-barra-navegacion {{ Request::is('*/aprendiz/mensual*') ? 'active' : '' }}">
            <i class="bi bi-calendar-month"></i> <span class="texto-barra-lateral">Reporte Mensual</span>
        </a>
        <a href="{{ route('personas.index') }}" class="opcion-barra-navegacion {{ Request::is('*/personas*') ? 'active' : '' }}">
            <i class="bi bi-person"></i> <span class="texto-barra-lateral">Persona</span>
        </a>
    @endif
@endauth


</div>


<!-- Contenido principal -->
<section class="contenido" id="contenido">
    <div class="contenido-principal">

    <div class="seccionEstatus">
        @yield('estados')
   </div>
       @yield('content')

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
