<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
     <style>
       
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                
                    
            
            <div class="card-header">
                <div class="card-body ">
                <br>
                    <img src="img/logosena.png" alt="Imagen SENA" class="img-fluid w-15"  >               
                    <h2>Iniciar sesión</h2>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            
                            
                            <label for="email" class="col-form-label"><i class="fa-solid fa-envelope fa-xl" style="color: #ff9500;"></i> Correo electrónico </label>
                             

                            <div class="col-md-8 offset-md-2">
                                <input id="email" type="email"    class="form-control    @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Estas credenciales no coinciden con nuestros registros.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-form-label"><i class="fa-sharp fa-solid fa-unlock fa-xl" style="color: #ff8800;"></i> Contraseña </label>

                            <div class="col-md-8 offset-md-2">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12 offset"><br>
                                <div class="form-check">
                                    <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">                                       
                                        Mantener sesión iniciada
                                    </label>
                                </div>
                            </div><br>
                        </div>

                        <div class="form-group row mb-2">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-success">
                                    Iniciar sesión
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-3">
                        <a href="{{ route('register') }}" class="btn btn-link">Crear nueva cuenta</a><br>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn btn-link">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
