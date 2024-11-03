@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Detalles de la Programación</h1>
            <a href="{{ route('ambiente-programacion.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ambiente:</label>
                    <p class="text-gray-900">{{ $programacion->ambiente->numero }} - {{ $programacion->ambiente->alias }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ficha:</label>
                    <p class="text-gray-900">{{ $programacion->ficha->codigo_ficha }} - {{ $programacion->ficha->nombre }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Instructor:</label>
                    <p class="text-gray-900">{{ $programacion->instructor->pnombre }} {{ $programacion->instructor->papellido }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Fecha:</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($programacion->fecha)->format('d/m/Y') }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Horario:</label>
                    <p class="text-gray-900">{{ substr($programacion->hora_inicio, 0, 5) }} - {{ substr($programacion->hora_fin, 0, 5) }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jornada:</label>
                    <p class="text-gray-900">{{ $programacion->jornada->nombre }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Competencia:</label>
                    <p class="text-gray-900">{{ $programacion->competencia->codigo }} - {{ $programacion->competencia->descripcion }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Resultado de Aprendizaje:</label>
                    <p class="text-gray-900">{{ $programacion->resultadoAprendizaje->codigo }} - {{ $programacion->resultadoAprendizaje->descripcion }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Horas Asignadas:</label>
                    <p class="text-gray-900">{{ $programacion->horas_asignadas }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
                    <p class="text-gray-900">{{ $programacion->estado }}</p>
                </div>
            </div>

            <div class="flex justify-end mt-6 gap-4">
                <a href="{{ route('ambiente-programacion.edit', $programacion->id) }}" 
                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <form action="{{ route('ambiente-programacion.destroy', $programacion->id) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('¿Está seguro que desea eliminar esta programación?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection