@extends('layouts.app')
@section('titulo', 'Reporte diario de programación')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado tipo planilla --}}
    <div class="text-center mb-8">
        @php
            setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');
            \Carbon\Carbon::setLocale('es');
            
            // Variables para estadísticas
            $totalProgramaciones = $programaciones->count();
            $programacionesPorEstado = $programaciones->groupBy('estado');
        @endphp
        <p class="text-sm mt-2">{{ Carbon\Carbon::parse($fecha)->isoFormat('dddd D [de] MMMM [de] YYYY') }}</p>
    </div>

    {{-- Filtros --}}
    <div class="bg-gray-50 p-4 border border-gray-300 mb-6">
        <form action="{{ route('reportes-programacion.diario') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Fecha:</label>
                <input type="date" 
                       name="fecha" 
                       value="{{ request('fecha', $fecha) }}"
                       class="border border-gray-300 px-2 py-1 text-sm rounded">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn btn-success btn-sm">
                    Filtrar
                </button>

                {{-- Botón para volver al calendario con todos los filtros --}}
                <a href="{{ route('reportes-programacion.mensual', [
                    'mes' => Carbon\Carbon::parse($fecha)->format('Y-m'),
                    'ambiente_id' => request('ambiente_id'),
                    'instructor_id' => request('instructor_id')
                ]) }}" 
                   class="btn btn-success boton-crear btn-sm">
                    <i class="fas fa-calendar me-1"></i> Volver al Calendario
                </a>

                <a href="{{ route('reportes-programacion.index') }}" 
                   class="btn btn-secondary btn-sm">
                    Volver
                </a>

               
            </div>
        </form>
    </div>

    {{-- Resumen estadístico compacto --}}
    <div class="mb-6 border border-gray-300 bg-white">
        <div class="grid grid-cols-4 divide-x divide-gray-300">
            <div class="p-4 text-center">
                <div class="text-sm font-medium text-gray-600">Total Programaciones</div>
                <div class="">{{ $totalProgramaciones }}</div>
            </div>
            <div class="p-4 text-center">
                <div class="text-sm font-medium text-gray-600">Programadas</div>
                <div class="">
                    {{ $programacionesPorEstado->get('programado', collect())->count() }}
                </div>
            </div>
            <div class="p-4 text-center">
                <div class="text-sm font-medium text-gray-600">En Curso</div>
                <div class="">
                    {{ $programacionesPorEstado->get('en_curso', collect())->count() }}
                </div>
            </div>
            <div class="p-4 text-center">
                <div class="text-sm font-medium text-gray-600">Completadas</div>
                <div class="">
                    {{ $programacionesPorEstado->get('completado', collect())->count() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla estilo planilla --}}
    <div class="border border-gray-800">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-800">
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium w-1/6">Hora</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium w-1/6">Ambiente</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium w-1/4">Ficha</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium w-1/6">Instructor</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium w-1/4">Resultado de Aprendizaje</th>
                <th class="px-4 py-2 text-left font-medium">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programaciones as $programacion)
                    <tr class="border-b border-gray-300">
                        <td class="border-r border-gray-300 px-4 py-2">
                            {{ Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                            {{ Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
                        </td>
                        <td class="border-r border-gray-300 px-4 py-2">
                            {{ $programacion->ambiente->numero }} - {{ $programacion->ambiente->alias }}
                        </td>
                        <td class="border-r border-gray-300 px-4 py-2">
                            {{ $programacion->ficha->codigo_ficha }} - {{ $programacion->ficha->nombre }}
                        </td>
                        <td class="border-r border-gray-300 px-4 py-2">
                            {{ $programacion->instructor->pnombre }} {{ $programacion->instructor->papellido }}
                        </td>
                        <td class="border-r border-gray-300 px-4 py-2">
                         {{ $programacion->resultadoAprendizaje->descripcion }}
                        </td>
                        <td class="px-4 py-2">
                            <span class="text-sm
                                @if($programacion->estado === 'programado') text-yellow-700
                                @elseif($programacion->estado === 'en_curso') text-blue-700
                                @elseif($programacion->estado === 'completado') text-green-700
                                @else text-gray-700 @endif">
                                {{ ucfirst($programacion->estado) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    @for($i = 0; $i < 5; $i++)
                        <tr class="border-b border-gray-300">
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="px-4 py-2">&nbsp;</td>
                        </tr>
                    @endfor
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pie de página --}}
    <div class="mt-8 text-sm">
        <div class="flex justify-between">
            <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
            <p>Página 1 de 1</p>
        </div>
    </div>
</div>
@endsection