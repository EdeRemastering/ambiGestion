<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmbiGestión</title>

    <!-- Favicon básico -->
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <!-- Íconos de Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alertas.js') }}"></script>

    <script src="{{asset('js/storageTema.js')}}"></script>

</head>

<body>

    <div class="contenedor-login">

        <header>
            <h1>Iniciar Sesion</h1>
        </header>

        @if(session('success'))
        <script>
            mensajeDeExito("{{session('success')}}");
        </script>
        @endif

        @if(session('error'))
        <script>
            mensajeDeError("{{ session('error') }}");
        </script>
        @endif

        @if(session('warning'))
        <script>
            mensajeDeAdvertencia("{{ session('warning') }}");
        </script>
        @endif


        <form action="{{ route('login') }}" method="POST">
            @csrf

            <i class="bi bi-person">

            </i><input type="email" name="email" placeholder="Correo electrónico" required>


            <i class="bi bi-key"></i>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <button type="button" id="togglePassword" style="width:fit-content; position: absolute; top: 49.2%; left: 83%;">
                <i class="bi bi-eye"></i>
            </button>


            <button type="submit">Iniciar Sesión</button>
        </form>


        <div class="">
            <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>

        </div>

    </div>


    <script src="{{ asset('js/campoContrasena.js') }}"></script>

</body>

</html>