@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Redes de Conocimiento</h1>
    <a href="{{ route('red_conocimiento.create') }}" class="btn btn-primary mb-3">Crear Nueva Red de Conocimiento</a>

    <table id="red-conocimientoTable" class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($redesConocimiento as $red)
            <tr>
                <td>{{ $red->codigo }}</td>
                <td>{{ $red->nombre }}</td>
                <td>
                    <a href="{{ route('red_conocimiento.show', $red) }}" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('red_conocimiento.edit', $red) }}" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('red_conocimiento.destroy', $red) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"onclick="mensajeDeEliminacion(event, '{{ $red->id }}', '{{ $red->nombre }}', 'redes de conocimiento')"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection