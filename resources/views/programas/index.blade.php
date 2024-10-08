@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Programas de Formación</h1>
    <a href="{{ route('programas.create') }}" class="btn btn-primary mb-3">Crear Nuevo Programa</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Código</th>
                <th>Versión</th>
                <th>Duración (meses)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programas as $programa)
            <tr>
                <td>{{ $programa->nombre }}</td>
                <td>{{ $programa->codigo }}</td>
                <td>{{ $programa->version }}</td>
                <td>{{ $programa->duracion_meses }}</td>
                <td>
                    <a href="{{ route('programas.show', $programa->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('programas.edit', $programa->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('programas.destroy', $programa->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="confirmarEliminacion()" class="btn btn-danger">Eliminar</button>

                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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