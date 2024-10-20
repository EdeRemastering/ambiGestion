<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{asset('js/storageTema.js')}}"></script>
</head>

<body>

    <div class="contenedor-login">

        <header>
            <h1>Iniciar Sesion</h1>
        </header>
        @if ($errors->any())
        <div class="error-message">
            Las credenciales no coinciden.
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>

       
        <div class="">
        <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="btn btn-link">
                ¿Olvidaste tu contraseña?
            </a>
            @endif
        </div>

    </div>


</body>

</html>