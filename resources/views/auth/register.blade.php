<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmbiGestión</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <script src="{{ asset('js/alertas.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{asset('js/storageTema.js')}}"></script>
</head>
<body>
    
        @if(session('success'))
            <script>mensajeDeExito("{{session('success')}}");</script>
        @endif
        
        @if(session('error'))
            <script>mensajeDeError("{{ session('error') }}");</script>
        @endif

        @if(session('warning'))
            <script>mensajeDeAdvertencia("{{ session('warning') }}");</script>
        @endif 


    <div class="contenedor-registro">
        <h1>Registro</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Usuario</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="password-confirm">Confirmar Contraseña</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="pnombre">Primer Nombre</label>
                    <input id="pnombre" type="text" name="pnombre" value="{{ old('pnombre') }}" required>
                </div>
                <div class="form-group">
                    <label for="snombre">Segundo Nombre</label>
                    <input id="snombre" type="text" name="snombre" value="{{ old('snombre') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="papellido">Primer Apellido</label>
                    <input id="papellido" type="text" name="papellido" value="{{ old('papellido') }}" required>
                </div>
                <div class="form-group">
                    <label for="sapellido">Segundo Apellido</label>
                    <input id="sapellido" type="text" name="sapellido" value="{{ old('sapellido') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="documento">Documento</label>
                    <input id="documento" type="text" name="documento" value="{{ old('documento') }}" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input id="direccion" type="text" name="direccion" value="{{ old('direccion') }}" required>
                </div>
                <div class="form-group">
                    <label for="tipo_sangre_id">Grupo Sanguíneo</label>
                    <select id="tipo_sangre_id" name="tipo_sangre_id" required>
                        <option value="">Seleccione un grupo sanguíneo</option>
                        @foreach($gruposSanguineos as $grupoSanguineo) 
                            <option value="{{ $grupoSanguineo->id }}"> {{ $grupoSanguineo->descripcion }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="rol_id">Rol</label>
                    <select id="rol_id" name="rol_id" required>
                    <option value="">Seleccione un rol</option>
                        @foreach($roles as $rol) 
                            <option value="{{ $rol->id }}"> {{ $rol->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" id="tipo_contrato_container">
                    <label for="tipo_contrato_id">Tipo de Contrato</label>
                    <select id="tipo_contrato_id" name="tipo_contrato_id">
                    <option value="">Seleccione un tipo de contrato</option>
                        @foreach($tiposContratos as $tipoContrato) 
                            <option value="{{ $tipoContrato->id }}"> {{ $tipoContrato->descripcion }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit">Registrarse</button>
            <div class="">
        <p>¿Tienes una cuenta? <a href="{{ route('login') }}">Inicia Sesion</a></p>
           
        </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rolSelect = document.getElementById('rol_id');
            const tipoContratoContainer = document.getElementById('tipo_contrato_container');
            const tipoContratoSelect = document.getElementById('tipo_contrato_id');

            function toggleTipoContrato() {
                const selectedRole = rolSelect.options[rolSelect.selectedIndex].text.toLowerCase();
                if (selectedRole === 'aprendiz') {
                    tipoContratoContainer.style.display = 'none';
                    tipoContratoSelect.value = '';
                    tipoContratoSelect.required = false;
                } else {
                    tipoContratoContainer.style.display = 'block';
                    tipoContratoSelect.required = true;
                }
            }

            rolSelect.addEventListener('change', toggleTipoContrato);
            toggleTipoContrato(); // Llamada inicial para establecer el estado correcto
        });
    </script>

   
</body>
</html>
