

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA - Innovación en Asignación de Ambientes</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <header>
        <h1>SENA</h1>
        <p>La solución innovadora para la asignación eficiente de ambientes a instructores.</p>
    </header>

    <div class="card-container">
        <div class="card">
            <h2>Asignación Inteligente</h2>
            <p>Con AmbiGestión, optimiza la asignación de ambientes según la disponibilidad, tipo de clase y perfil del instructor. Ahorra tiempo y evita conflictos en los horarios.</p>
        </div>

        <div class="card">
            <h2>Gestión en Tiempo Real</h2>
            <p>Visualiza la disponibilidad de los espacios en tiempo real. Cambia, organiza y ajusta las asignaciones con solo unos clics a través de un calendario dinámico e interactivo.</p>
        </div>

        <div class="card">
            <h2>Automatización Eficiente</h2>
            <p>Automatiza procesos repetitivos y recibe notificaciones instantáneas sobre cambios en la programación de ambientes. Mantén el control sin esfuerzo adicional.</p>
        </div>

        <div class="card">
            <h2>Optimización de Recursos</h2>
            <p>Asegura que cada ambiente sea utilizado de manera eficiente, basándote en la capacidad de los espacios, el tipo de clase y los requisitos técnicos de los cursos.</p>
        </div>

        <div class="card">
            <h2>Reportes y Análisis</h2>
            <p>Obtén reportes detallados del uso de los ambientes para la toma de decisiones estratégicas. Con AmbiGestión, mejora la administración de tus recursos educativos.</p>
        </div>

        <div class="card">
            <h2>Escalable y Personalizable</h2>
            <p>AmbiGestión es útil y adaptable para todos los SENAS e inlcuso otro tipo de instituciones si así se requiere.</p>
        </div>
    </div>

    <div class="action-buttons">
    <a href="{{ route('register') }}" class="register">Registrarse</a>
        <a href="{{ route('login') }}" class="login">Iniciar Sesión</a>
    </div>

</body>
</html>
