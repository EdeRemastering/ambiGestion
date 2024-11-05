@extends('layouts.app')
@section('titulo', 'Reporte semanal de programación')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado tipo planilla --}}
    <div class="text-center mb-8">
        <p class="text-sm mt-2">
            Semana del {{ \Carbon\Carbon::parse($fechaInicio)->isoFormat('LL') }} 
            al {{ \Carbon\Carbon::parse($fechaInicio)->addDays(6)->isoFormat('LL') }}
        </p>
    </div>

    {{-- Filtros --}}
    <div class="bg-gray-50 p-4 border border-gray-300 mb-6">
        <form action="{{ route('reportes-programacion.semanal') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Semana del:</label>
                <input type="date" 
                       name="fecha_inicio" 
                       value="{{ request('fecha_inicio', $fechaInicio) }}"
                       class="border border-gray-300 px-2 py-1 text-sm rounded">
            </div>

            @if($esAdmin)
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium">Instructor:</label>
                    <select name="instructor_id" class="border border-gray-300 px-2 py-1 text-sm rounded">
                        <option value="">Todos los instructores</option>
                        @foreach($instructores as $instructor)
                            <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->pnombre }} {{ $instructor->papellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button type="submit" class="btn btn-success btn-sm">
                Filtrar
            </button>

            <a href="{{ route('reportes-programacion.index') }}" class="btn btn-secondary btn-sm">
                Volver
            </a>
        </form>
    </div>

    @php
        setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');
        \Carbon\Carbon::setLocale('es');
        
        $programacionesPorDia = $programaciones->groupBy(function($programacion) {
            return \Carbon\Carbon::parse($programacion->fecha)->format('Y-m-d');
        });
    @endphp

    {{-- Tabla estilo planilla --}}
    <div class="border border-gray-800">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-800">
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Día y Fecha</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Hora</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Ambiente</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Ficha</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Instructor</th>
                <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Resultado de Aprendizaje</th>
                <th class="px-4 py-2 text-left font-medium">Estado</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $fechaActual = \Carbon\Carbon::parse($fechaInicio);
                    $hayProgramaciones = false;
                @endphp

                @for($i = 0; $i < 7; $i++)
                    @php
                        $fechaDia = $fechaActual->copy()->addDays($i);
                        $fechaDiaStr = $fechaDia->format('Y-m-d');
                        $programacionesDia = $programacionesPorDia->get($fechaDiaStr, collect());
                    @endphp

                    @forelse($programacionesDia as $programacion)
                        @php $hayProgramaciones = true; @endphp
                        <tr class="border-b border-gray-300">
                            <td class="border-r border-gray-300 px-4 py-2">
                                {{ ucfirst($fechaDia->isoFormat('dddd D [de] MMMM')) }}
                            </td>
                            <td class="border-r border-gray-300 px-4 py-2">
                                {{ \Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
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
                        <tr class="border-b border-gray-300">
                            <td class="border-r border-gray-300 px-4 py-2">
                                {{ ucfirst($fechaDia->isoFormat('dddd D [de] MMMM')) }}
                            </td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="px-4 py-2">&nbsp;</td>
                        </tr>
                    @endforelse
                @endfor

                @if(!$hayProgramaciones)
                    @for($i = 0; $i < 3; $i++)
                        <tr class="border-b border-gray-300">
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="border-r border-gray-300 px-4 py-2">&nbsp;</td>
                            <td class="px-4 py-2">&nbsp;</td>
                        </tr>
                    @endfor
                @endif
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