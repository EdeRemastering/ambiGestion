@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Resultado de Aprendizaje</h1>
    
    @if($resultado)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Código: {{ $resultado->codigo ?? 'N/A' }}</h5>
                <p class="card-text"><strong>Descripción:</strong> {{ $resultado->descripcion ?? 'N/A' }}</p>
                <p class="card-text"><strong>Intensidad Horaria:</strong> {{ $resultado->intensidad_horaria ?? 'N/A' }} horas</p>
                @if($resultado->competencia)
                    <p class="card-text"><strong>Competencia:</strong> {{ $resultado->competencia->codigo }} - {{ $resultado->competencia->descripcion }}</p>
                @else
                    <p class="card-text"><strong>Competencia:</strong> No asignada</p>
                @endif
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('resultados_aprendizaje.edit', ['resultadoAprendizaje' => $resultado->id]) }}" class="btn btn-warning">Editar</a>
            <button onclick="confirmarEliminacion()" class="btn btn-danger">Eliminar</button>
            <a href="{{ route('resultados_aprendizaje.index') }}" class="btn btn-secondary">Volver al listado</a>
        </div>
        
        <form id="form-eliminar" action="{{ route('resultados_aprendizaje.destroy', ['resultadoAprendizaje' => $resultado->id]) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @else
        <div class="alert alert-danger">
            Resultado de aprendizaje no encontrado.
        </div>
        <a href="{{ route('resultados_aprendizaje.index') }}" class="btn btn-secondary">Volver al listado</a>
    @endif
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