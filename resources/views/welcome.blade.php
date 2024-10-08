@extends('layouts.app')

@section('content')
<div class="content-container flex">
    <h1 class="text-center mb-4">Bienvenidos al   {{ config('#', 'Complejo') }}</h1>
    <p class="text-center">
        Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel, we recommend reading all of the documentation from beginning to end.
    </p>
    <img src="{{ asset('/img/fondos1.jpg') }}" alt="" with="600px" height="870px">
    
    <!-- Aquí puedes agregar más contenido específico de la página de bienvenida -->
</div>

@endsection