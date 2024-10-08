@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Campos adicionales para la persona -->
                        <div class="form-group row">
                            <label for="documento" class="col-md-4 col-form-label text-md-right">{{ __('Documento') }}</label>
                            <div class="col-md-6">
                                <input id="documento" type="text" class="form-control @error('documento') is-invalid @enderror" name="documento" value="{{ old('documento') }}" required>
                                @error('documento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pnombre" class="col-md-4 col-form-label text-md-right">{{ __('Primer Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="pnombre" type="text" class="form-control @error('pnombre') is-invalid @enderror" name="pnombre" value="{{ old('pnombre') }}" required>
                                @error('pnombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="snombre" class="col-md-4 col-form-label text-md-right">{{ __('Segundo Nombre') }}</label>
                            <div class="col-md-6">
                                <input id="snombre" type="text" class="form-control @error('snombre') is-invalid @enderror" name="snombre" value="{{ old('snombre') }}">
                                @error('snombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="papellido" class="col-md-4 col-form-label text-md-right">{{ __('Primer Apellido') }}</label>
                            <div class="col-md-6">
                                <input id="papellido" type="text" class="form-control @error('papellido') is-invalid @enderror" name="papellido" value="{{ old('papellido') }}" required>
                                @error('papellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sapellido" class="col-md-4 col-form-label text-md-right">{{ __('Segundo Apellido') }}</label>
                            <div class="col-md-6">
                                <input id="sapellido" type="text" class="form-control @error('sapellido') is-invalid @enderror" name="sapellido" value="{{ old('sapellido') }}">
                                @error('sapellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono') }}</label>
                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required>
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>
                            <div class="col-md-6">
                                <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion') }}" required>
                                @error('direccion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_sangre_id" class="col-md-4 col-form-label text-md-right">{{ __('Grupo Sanguíneo') }}</label>
                            <div class="col-md-6">
                                <select id="tipo_sangre_id" class="form-control @error('tipo_sangre_id') is-invalid @enderror" name="tipo_sangre_id" required>
                                    <option value="">Seleccione un grupo sanguíneo</option>
                                    @foreach($gruposSanguineos as $grupoSanguineo)
                                        <option value="{{ $grupoSanguineo->id }}">{{ $grupoSanguineo->descripcion }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_sangre_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                       

                        <div class="form-group row">
    <label for="rol_id" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>
    <div class="col-md-6">
        <select id="rol_id" class="form-control @error('rol_id') is-invalid @enderror" name="rol_id" required>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
        @error('rol_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div id="tipo_contrato_container" class="form-group row">
    <label for="tipo_contrato_id" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Contrato') }}</label>
    <div class="col-md-6">
        <select id="tipo_contrato_id" class="form-control @error('tipo_contrato_id') is-invalid @enderror" name="tipo_contrato_id">
            @foreach($tiposContratos as $contrato)
                <option value="{{ $contrato->id }}">{{ $contrato->descripcion }}</option>
            @endforeach
        </select>
        @error('tipo_contrato_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
            tipoContratoContainer.style.display = 'flex';
            tipoContratoSelect.required = true;
        }
    }

    rolSelect.addEventListener('change', toggleTipoContrato);
    toggleTipoContrato(); // Llamada inicial para establecer el estado correcto
});
</script>
@endsection