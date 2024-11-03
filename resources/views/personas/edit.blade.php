@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Perfil</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('personas.update', $persona->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Información Personal
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" value="{{ old('documento', $persona->documento) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="pnombre" class="form-label">Primer Nombre</label>
                        <input type="text" class="form-control" id="pnombre" name="pnombre" value="{{ old('pnombre', $persona->pnombre) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="snombre" class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control" id="snombre" name="snombre" value="{{ old('snombre', $persona->snombre) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="papellido" class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control" id="papellido" name="papellido" value="{{ old('papellido', $persona->papellido) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sapellido" class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" id="sapellido" name="sapellido" value="{{ old('sapellido', $persona->sapellido) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono', $persona->telefono) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo', $persona->correo) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $persona->direccion) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Información Adicional
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="rol_id" class="form-label">Rol</label>
                        @if($canChangeRole)
                            <select name="rol_id" id="rol_id" class="form-select">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('rol_id', $persona->user->role_id) == $rol->id ? 'selected' : '' }}>
                                        {{ $rol->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ $persona->user->role->name }}" readonly>
                            <input type="hidden" name="rol_id" value="{{ $persona->user->role_id }}">
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tipo_sangre_id" class="form-label">Tipo de Sangre</label>
                        <select class="form-select" id="tipo_sangre_id" name="tipo_sangre_id" required>
                            <option value="">Seleccione un tipo de sangre</option>
                            @foreach($gruposSanguineos as $grupo)
                                <option value="{{ $grupo->id }}" {{ old('tipo_sangre_id', $persona->tipo_sangre_id) == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3" id="tipo_contrato_container" style="{{ $isAprendiz ? 'display: none;' : '' }}">
                        <label for="tipo_contrato_id" class="form-label">Tipo de Contrato</label>
                        <select name="tipo_contrato_id" id="tipo_contrato_id" class="form-select">
                            <option value="">Seleccione tipo de contrato</option>
                            @foreach($tiposContratos as $contrato)
                                <option value="{{ $contrato->id }}" {{ old('tipo_contrato_id', $persona->tipo_contrato_id) == $contrato->id ? 'selected' : '' }}>
                                    {{ $contrato->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                    <label for="codigo_ficha" class="form-label">Código de Ficha</label>
                    <select name="codigo_ficha" class="form-control" {{ !$isAprendiz ? 'disabled' : '' }}>
                        <option value="">Seleccione una ficha</option>
                        @foreach($fichas as $ficha)
                            <option value="{{ $ficha->codigo_ficha }}" 
                                 {{ $persona->codigo_ficha == $ficha->codigo_ficha ? 'selected' : '' }}>
                             {{ $ficha->codigo_ficha }}
                            </option>
                     @endforeach
                    </select>
                </div>

                    <div class="col-md-12 mb-3" id="redes_conocimiento_container" style="{{ $persona->user->role->name !== 'instructor' ? 'display: none;' : '' }}">
                        <label for="redes_conocimiento" class="form-label">Redes de Conocimiento (Ctrl + Click para selección múltiple)</label>
                        <select name="redes_conocimiento[]" id="redes_conocimiento" class="form-select" multiple style="height: 100px;">
                            @foreach($redesConocimiento as $red)
                                <option value="{{ $red->id }}" 
                                    {{ in_array($red->id, old('redes_conocimiento', $persona->redesConocimiento->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $red->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Cambio de Contraseña
            </div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="change_password" id="change_password">
                    <label class="form-check-label" for="change_password">
                        Cambiar contraseña
                    </label>
                </div>

                <div id="password_fields" style="display: none;">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" name="current_password" id="current_password">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('personas.index') }}" class="btn btn-secondary me-md-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo del cambio de contraseña
    const changePasswordCheckbox = document.getElementById('change_password');
    const passwordFields = document.getElementById('password_fields');

    changePasswordCheckbox.addEventListener('change', function() {
        passwordFields.style.display = this.checked ? 'block' : 'none';
    });

    // Manejo de cambio de rol
    const rolSelect = document.getElementById('rol_id');
    const tipoContratoContainer = document.getElementById('tipo_contrato_container');
    const fichaContainer = document.getElementById('ficha_container');
    const redesContainer = document.getElementById('redes_conocimiento_container');

    function toggleFields() {
        if (rolSelect) {
            const selectedRole = rolSelect.options[rolSelect.selectedIndex].text.toLowerCase();
            
            if (selectedRole === 'aprendiz') {
                tipoContratoContainer.style.display = 'none';
                redesContainer.style.display = 'none';
                fichaContainer.style.display = 'block';
            } else if (selectedRole === 'instructor') {
                tipoContratoContainer.style.display = 'block';
                redesContainer.style.display = 'block';
                fichaContainer.style.display = 'none';
            } else {
                tipoContratoContainer.style.display = 'block';
                redesContainer.style.display = 'none';
                fichaContainer.style.display = 'none';
            }
        }
    }

    if (rolSelect) {
        rolSelect.addEventListener('change', toggleFields);
    }
});
</script>

@endsection