@extends('layouts.app')

@section('titulo', 'Mi cuenta')

@section('contenido')
<div class="contenedor-principal">
    <div class="contenedor-secundario">
    <form action="{{ route('personas.updateSettings', $persona->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="documento" class="form-label">Documento</label>
            <input type="number" class="form-control" id="documento" name="documento" value="{{ $persona->documento }}" required readonly>
        </div>
        <div class="form-group">
            <label for="pnombre" class="form-label">Primer Nombre</label>
            <input type="text" class="form-control" id="pnombre" name="pnombre" value="{{ $persona->pnombre }}" required readonly>
        </div>
        <div class="form-group">
            <label for="snombre" class="form-label">Segundo Nombre</label>
            <input type="text" class="form-control" id="snombre" name="snombre" value="{{ $persona->snombre }}" required readonly>
        </div>
        <div class="form-group">
            <label for="papellido" class="form-label">Primer Apellido</label>
            <input type="text" class="form-control" id="papellido" name="papellido" value="{{ $persona->papellido }}" required readonly>
        </div>
        <div class="form-group">
            <label for="sapellido" class="form-label">Segundo Apellido</label>
            <input type="text" class="form-control" id="sapellido" name="sapellido" value="{{ $persona->sapellido }}" readonly>
        </div>
        <div class="form-group">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="number" class="form-control" id="telefono" name="telefono" value="{{ $persona->telefono }}" required>
        </div>
        <div class="form-group">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ $persona->correo }}" required>
        </div>
        <div class="form-group">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $persona->direccion }}" required>
        </div>


        <div class="form-group  ">
                        <label for="rol_id" class="form-label">Rol</label>
                        @if($canChangeRole)
                            <select name="rol_id" id="rol_id" class="form-select">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ ($persona->user->role_id == $rol->id) ? 'selected' : '' }}>
                                        {{ $rol->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ $persona->user->role->name }}" readonly>
                            <input type="hidden" name="rol_id" value="{{ $persona->user->role_id }}">
                        @endif
                    </div>
                    <div class="form-group  ">
                        <label for="tipo_sangre_id" class="form-label">Tipo de Sangre</label>
                        <select class="form-select" id="tipo_sangre_id" name="tipo_sangre_id" required>
                            <option value="">Seleccione un tipo de sangre</option>
                            @foreach($gruposSanguineos as $grupo)
                                <option value="{{ $grupo->id }}" {{ $persona->tipo_sangre_id == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if(!$isAprendiz)
                        <div class="form-group">
                            <label for="tipo_contrato_id">Tipo de Contrato</label>
                            <select name="tipo_contrato_id" id="tipo_contrato_id" class="form-control" {{ $isAprendiz ? 'disabled' : '' }}>
                                @foreach($tiposContratos as $contrato)
                                    <option value="{{ $contrato->id }}" {{ $persona->tipo_contrato_id == $contrato->id ? 'selected' : '' }}>
                                        {{ $contrato->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-group">
                <div class="form-check  ">
                    <label class="form-check-label" for="change_password"> Cambiar contraseña</label>
                    <input class="form-check-input mt-3" type="checkbox" name="change_password" id="change_password">
                </div>
                </div>
                <div class="form-group ">
                <div id="password_fields" style="display: none;">
                    <div class="form-group ">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" name="current_password" id="current_password">
                    </div>
                    <div class="form-group ">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group ">
                        <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    </div>
                </div> 
                </div>
                <div class="col-md-12 center">
                <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('change_password').addEventListener('change', function() {
        document.getElementById('password_fields').style.display = this.checked ? 'block' : 'none';
    });
</script>

@endsection
