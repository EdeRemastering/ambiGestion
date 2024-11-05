<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="contenedor-registro">
    <h1>Registro</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf
        
        <!-- Usuario y Correo -->
        <div class="form-row">
        <div class="form-group">
                <label for="documento">Documento</label>
                <input id="documento" type="text" name="documento" value="{{ old('documento') }}" required>
                <div class="invalid-feedback">
                    Por favor, ingrese un documento válido.
                </div>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
        </div>

        <!-- Contraseñas -->
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

        <!-- Nombres -->
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

        <!-- Apellidos -->
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

        <!-- Documento y Teléfono -->
        <div class="form-row">
            
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input id="direccion" type="text" name="direccion" value="{{ old('direccion') }}" required>
            </div>
        </div>

        

        <!-- Rol y Grupo Sanguíneo -->
        <div class="form-row">
            <div class="form-group">
                <label for="rol_id">Rol</label>
                <select id="rol_id" name="rol_id" required readonly>
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('rol_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tipo_sangre_id">Grupo Sanguíneo</label>
                <select id="tipo_sangre_id" name="tipo_sangre_id" required>
                    <option value="">Seleccione un grupo sanguíneo</option>
                    @foreach($gruposSanguineos as $grupoSanguineo)
                        <option value="{{ $grupoSanguineo->id }}" {{ old('tipo_sangre_id') == $grupoSanguineo->id ? 'selected' : '' }}>
                            {{ $grupoSanguineo->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Campos condicionales -->
        <div class="form-row">
            <!-- Tipo de Contrato (para instructores) -->
            <div class="form-group" id="tipo_contrato_container" style="display: none;">
                <label for="tipo_contrato_id">Tipo de Contrato</label>
                <select id="tipo_contrato_id" name="tipo_contrato_id">
                    <option value="">Seleccione tipo de contrato</option>
                    @foreach($tiposContratos as $contrato)
                        <option value="{{ $contrato->id }}" {{ old('tipo_contrato_id') == $contrato->id ? 'selected' : '' }}>
                            {{ $contrato->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Código de Ficha (para aprendices) -->
            <div class="form-group" id="ficha_container" style="display: none;">
                <label for="codigo_ficha">Código de Ficha</label>
                <select id="codigo_ficha" name="codigo_ficha">
                    <option value="">Seleccione código de ficha</option>
                    @foreach($fichas as $ficha)
                        <option value="{{ $ficha->codigo_ficha }}" {{ old('codigo_ficha') == $ficha->codigo_ficha ? 'selected' : '' }}>
                            {{ $ficha->codigo_ficha }} - {{ $ficha->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Redes de Conocimiento (para instructores) -->
            <div class="form-group" id="redes_conocimiento_container" style="display: none;">
                <label for="redes_conocimiento">Redes de Conocimiento</label>
                <select id="redes_conocimiento" name="redes_conocimiento[]" multiple>
                    @foreach($redesConocimiento as $red)
                        <option value="{{ $red->id }}" {{ (is_array(old('redes_conocimiento')) && in_array($red->id, old('redes_conocimiento'))) ? 'selected' : '' }}>
                            {{ $red->nombre }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Mantén presionada la tecla Ctrl para seleccionar múltiples opciones</small>
            </div>
        </div>

        <button type="submit" id="submitButton" disabled>Registrarse</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const documentoInput = document.getElementById('documento');
    const rolSelect = document.getElementById('rol_id');
    const submitButton = document.getElementById('submitButton');
    const form = document.getElementById('registerForm');
    let timeoutId;
    let documentoValidado = false;
    let tipoDocumentoVerificado = '';

    function mostrarCamposSegunRol(tipo) {
        const tipoContratoContainer = document.getElementById('tipo_contrato_container');
        const redesConocimientoContainer = document.getElementById('redes_conocimiento_container');
        const fichaContainer = document.getElementById('ficha_container');

        // Ocultar todos primero
        [tipoContratoContainer, redesConocimientoContainer, fichaContainer].forEach(container => {
            if (container) container.style.display = 'none';
        });

        // Mostrar según tipo
        if (tipo === 'aprendiz') {
            if (fichaContainer) fichaContainer.style.display = 'block';
        } else if (tipo === 'instructor') {
            if (tipoContratoContainer) tipoContratoContainer.style.display = 'block';
            if (redesConocimientoContainer) redesConocimientoContainer.style.display = 'block';
        }
    }

    async function verificarDocumento() {
        const documento = documentoInput.value.trim();
        if (documento.length < 5) return;

        Swal.fire({
            title: 'Verificando documento...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const response = await fetch(`/verificar-documento/${documento}`);
            const data = await response.json();

            if (data.valido) {
                documentoValidado = true;
                tipoDocumentoVerificado = data.tipo;
                
                // Mensaje específico según el tipo
                let mensaje = '';
                if (data.tipo === 'aprendiz') {
                    mensaje = 'Su documento está registrado como APRENDIZ. Por favor, seleccione su ficha para continuar con el registro.';
                } else {
                    mensaje = 'Su documento está registrado como INSTRUCTOR. Por favor, seleccione su tipo de contrato y red de conocimiento para continuar.';
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Documento Verificado',
                    text: mensaje,
                    confirmButtonText: 'Entendido'
                });

                documentoInput.classList.remove('is-invalid');
                documentoInput.classList.add('is-valid');
                submitButton.disabled = false;

                // Establecer y mostrar campos según el rol
                if (rolSelect) {
                    rolSelect.value = data.rol_id;
                }
                mostrarCamposSegunRol(data.tipo);
                
            } else {
                documentoValidado = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Documento No Autorizado',
                    text: 'Este documento no está autorizado para registro. Por favor, contacte al administrador.',
                    confirmButtonText: 'Entendido'
                });

                documentoInput.classList.remove('is-valid');
                documentoInput.classList.add('is-invalid');
                submitButton.disabled = true;
                limpiarCampos();
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al verificar el documento. Por favor, intente nuevamente.',
                confirmButtonText: 'Entendido'
            });
            documentoValidado = false;
            submitButton.disabled = true;
        }
    }

    function limpiarCampos() {
        const selects = [
            document.getElementById('tipo_contrato_id'),
            document.getElementById('codigo_ficha'),
            document.getElementById('redes_conocimiento')
        ];

        selects.forEach(select => {
            if (select) {
                select.value = '';
                if (select.multiple) {
                    Array.from(select.options).forEach(option => option.selected = false);
                }
            }
        });

        mostrarCamposSegunRol(null);
    }

    // Evento para verificar documento
    documentoInput.addEventListener('input', function() {
        documentoValidado = false;
        clearTimeout(timeoutId);
        submitButton.disabled = true;
        
        documentoInput.classList.remove('is-valid', 'is-invalid');
        limpiarCampos();
        
        if (this.value.trim().length >= 5) {
            timeoutId = setTimeout(verificarDocumento, 500);
        }
    });

    // Manejo del rol
    rolSelect?.addEventListener('change', function() {
        if (documentoValidado) {
            if (this.value) {
                const rolSeleccionado = this.options[this.selectedIndex].text.toLowerCase();
                if (rolSeleccionado !== tipoDocumentoVerificado) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Rol Incorrecto',
                        text: `Su documento está registrado como ${tipoDocumentoVerificado.toUpperCase()}. Por favor, seleccione el rol correcto.`,
                        confirmButtonText: 'Entendido'
                    });
                    this.value = '';
                    limpiarCampos();
                } else {
                    mostrarCamposSegunRol(tipoDocumentoVerificado);
                }
            } else {
                limpiarCampos();
            }
        }
    });

    // Manejo del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!documentoValidado) {
            Swal.fire({
                icon: 'warning',
                title: 'Verificación Requerida',
                text: 'Por favor, verifique el documento antes de continuar',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        // Verificar campos requeridos según el rol
        const camposRequeridos = tipoDocumentoVerificado === 'aprendiz' 
            ? ['codigo_ficha']
            : ['tipo_contrato_id', 'redes_conocimiento[]'];

        const faltanCampos = camposRequeridos.some(campo => {
            const elemento = document.getElementsByName(campo)[0];
            return !elemento || !elemento.value;
        });

        if (faltanCampos) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos Requeridos',
                text: tipoDocumentoVerificado === 'aprendiz' 
                    ? 'Por favor, seleccione una ficha para continuar.'
                    : 'Por favor, complete el tipo de contrato y red de conocimiento.',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        Swal.fire({
            title: 'Procesando registro...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        form.submit();
    });

    // Verificación inicial si hay un documento
    if (documentoInput.value.trim().length >= 5) {
        verificarDocumento();
    }
});
</script>
<style>
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .is-invalid {
        border-color: #dc3545 !important;
        background-color: #fff8f8 !important;
    }

    .is-valid {
        border-color: #198754 !important;
        background-color: #f8fff9 !important;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
    }

    .alert-success {
        color: #0f5132;
        background-color: #d1e7dd;
        border-color: #badbcc;
    }

    .alert-danger {
        color: #842029;
        background-color: #f8d7da;
        border-color: #f5c2c7;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    #submitButton:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    select[multiple] {
        height: 100px;
    }
</style>
</body>
</html>