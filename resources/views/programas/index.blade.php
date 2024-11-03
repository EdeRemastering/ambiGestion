@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Programas de Formación</h1>
    <a href="{{ route('programas.create') }}" class="btn btn-primary mb-3">Crear Nuevo Programa</a>
    
    <table id="programasTable" class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Versión</th>
                <th>Duración (meses)</th>
                <th>Red de Conocimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programas as $programa)
            <tr>
                <td>{{ $programa->codigo }}</td>
                <td>{{ $programa->nombre }}</td>
                <td>{{ $programa->version }}</td>
                <td>{{ $programa->duracion_meses }}</td>
                <td>{{ $programa->redConocimiento->nombre }}</td>
                <td>
                    <a href="{{ route('programas.show', $programa->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('programas.edit', $programa->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('programas.destroy', $programa->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
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