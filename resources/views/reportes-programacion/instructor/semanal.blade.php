@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado --}}
    <div class="text-center mb-8">
        <h1 class="text-xl font-bold uppercase">Servicio Nacional de Aprendizaje SENA</h1>
        <h2 class="text-lg">Centro de Servicios y Gestión Empresarial</h2>
        <h3 class="text-lg font-bold mt-4">Reporte Semanal de Programación - Instructor</h3>
        
        {{-- Información del Instructor --}}
        <div class="mt-4 bg-gray-50 p-4 border border-gray-300 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-left">
                    <p class="text-sm"><span class="font-medium">Instructor:</span> 
                        {{ Auth::user()->persona->pnombre }} {{ Auth::user()->persona->papellido }}
                    </p>
                    <p class="text-sm"><span class="font-medium">Documento:</span> 
                        {{ Auth::user()->persona->numero_documento }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm">
                        Semana del {{ \Carbon\Carbon::parse($fechaInicio)->isoFormat('LL') }}
                        al {{ \Carbon\Carbon::parse($fechaInicio)->addDays(6)->isoFormat('LL') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-gray-50 p-4 border border-gray-300 mb-6">
        <form action="{{ route('reportes-programacion.instructor.semanal') }}" method="GET" 
              class="flex flex-wrap gap-4 items-center">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Semana del:</label>
                <input type="date" 
                       name="fecha_inicio" 
                       value="{{ request('fecha_inicio', $fechaInicio) }}"
                       class="border border-gray-300 px-2 py-1 text-sm rounded">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="bg-[#39A900] text-white px-4 py-1 text-sm rounded hover:bg-[#2d8600]">
                    <i class="fas fa-search me-2"></i>Consultar
                </button>

                <a href="{{ request()->fullUrlWithQuery(['pdf' => true]) }}" 
                   class="bg-red-600 text-white px-4 py-1 text-sm rounded hover:bg-red-700">
                    <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                </a>
            </div>
        </form>
    </div>

    {{-- Tabla de programación --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Día</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Hora</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Ambiente</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Ficha</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Resultado de Aprendizaje</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Estado</th>
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

                    @if($programacionesDia->isNotEmpty())
                        @php $hayProgramaciones = true; @endphp
                        @foreach($programacionesDia as $programacion)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2 font-medium">
                                    {{ ucfirst($fechaDia->isoFormat('dddd D [de] MMMM')) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ \Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $programacion->ambiente->numero }} - 
                                    {{ $programacion->ambiente->alias }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $programacion->ficha->codigo_ficha }}
                                    <br>
                                    <span class="text-sm text-gray-600">
                                        {{ Str::limit($programacion->ficha->nombre, 30) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $programacion->resultadoAprendizaje->codigo }}
                                 <br>
                                    <span class="text-sm text-gray-600">
                                     {{ Str::limit($programacion->resultadoAprendizaje->descripcion, 50) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <span class="px-2 py-1 text-sm rounded-full
                                        @if($programacion->estado === 'programado') bg-yellow-100 text-yellow-800
                                        @elseif($programacion->estado === 'en_curso') bg-blue-100 text-blue-800
                                        @elseif($programacion->estado === 'completado') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($programacion->estado) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 font-medium">
                                {{ ucfirst($fechaDia->isoFormat('dddd D [de] MMMM')) }}
                            </td>
                            <td colspan="5" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                No hay programaciones para este día
                            </td>
                        </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>

    {{-- Resumen semanal --}}
    <div class="mt-8 bg-gray-50 p-4 border border-gray-300 rounded-lg">
        <h4 class="font-medium mb-4">Resumen de la Semana</h4>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-3 rounded border border-gray-200">
                <p class="text-sm text-gray-600">Total Programaciones</p>
                <p class="text-2xl font-bold">{{ $programaciones->count() }}</p>
            </div>
            <div class="bg-white p-3 rounded border border-gray-200">
                <p class="text-sm text-gray-600">Fichas Diferentes</p>
                <p class="text-2xl font-bold">{{ $programaciones->unique('ficha_id')->count() }}</p>
            </div>
            <div class="bg-white p-3 rounded border border-gray-200">
                <p class="text-sm text-gray-600">Ambientes Utilizados</p>
                <p class="text-2xl font-bold">{{ $programaciones->unique('ambiente_id')->count() }}</p>
            </div>
            <div class="bg-white p-3 rounded border border-gray-200">
                <p class="text-sm text-gray-600">Horas Programadas</p>
                <p class="text-2xl font-bold">
                    {{ $programaciones->sum(function($prog) {
                        return Carbon\Carbon::parse($prog->hora_fin)->diffInHours(Carbon\Carbon::parse($prog->hora_inicio));
                    }) }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection