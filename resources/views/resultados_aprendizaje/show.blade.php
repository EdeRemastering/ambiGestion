@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Resultado de Aprendizaje</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Código: {{ $resultado->codigo }}</h5>
            <p class="card-text"><strong>Descripción:</strong> {{ $resultado->descripcion }}</p>
            <p class="card-text"><strong>Intensidad Horaria:</strong> {{ $resultado->intensidad_horaria }} horas</p>
            <p class="card-text"><strong>Competencia:</strong> {{ $resultado->competencia->codigo }} - {{ $resultado->competencia->descripcion }}</p>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('resultados_aprendizaje.edit', $resultado->id) }}" class="btn btn-warning">Editar</a>
        <button onclick="confirmarEliminacion()" class="btn btn-danger">Eliminar</button>
        <a href="{{ route('resultados_aprendizaje.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>

    <form id="form-eliminar" action="{{ route('resultados_aprendizaje.destroy', $resultado->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('scripts')
<script>
function confirmarEliminacion() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-eliminar').submit();
        }
    });
}
</script>
@endpush