<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AmbiGestion') }}</title>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- SweetAlert2 CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
     <!-- ... otras etiquetas meta ... -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
   
   
</head>
<body>
    <div id="app">
    <nav class="navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/logosena.png') }}" alt="Logo" >
            </a>
            <h1 class="titulo">AMBIPROGRAMACIÓN</h1>

            <div class="ms-auto">
                @auth
                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-light">
                        Cerrar Sesión
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>
        <div class="main-container">
            <aside class="sidebar">
                <div class="logo-container">
                    
                </div>
    @auth
        @if(auth()->user()->hasRole('admin'))

            <a href="{{ route('home') }}"><span>Dashboard</span></a>
            <a href="{{ route('personas.index') }}"><span>Programacion</span></a>
            <a href="{{ route('programas.index') }}"><span>Programa de formacion</span></a>
            <a href="{{ route('resultados_aprendizaje.index') }}"><span>Resultado de Aprendizaje</span></a>
            <a href="{{ route('competencias.index') }}"><span>Competencias</span></a>
            <a href="{{ route('personas.index') }}"><span>Recursos</span></a>
            <a href="{{ route('personas.index') }}"><span>Novedad</span></a>
            <a href="{{ route('personas.index') }}"><span>Ambientes</span></a>
            <a href="{{ route('personas.index') }}"><span>Persona</span></a>
       
            @elseif(auth()->user()->hasRole('instructor'))
            <a href="{{ route('home') }}"><span>Dashboard</span></a>            
            <a href="#"><span>Programacion</span></a>
            <a href="{{ route('personas.index') }}"><span>Persona</span></a>
        
        @elseif(auth()->user()->hasRole('aprendiz'))
        <a href="{{ route('home') }}"><span>Dashboard</span></a>            
            <a href="#"><span>Programacion</span></a>
            <a href="{{ route('personas.index') }}"><span>Persona</span></a>
        @endif
    @endauth
</aside>

            <main class="content-area">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.querySelector('.sidebar');
            var sidebarCollapse = document.querySelector('#sidebarCollapse');

            sidebarCollapse.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        });

        
    </script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    
    @yield('scripts')
</body>
</html>