@extends('layouts.app')
@section('titulo', 'Mi clase de hoy')


@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado tipo planilla --}}
    <div class="text-center mb-8">
        <h1 class="text-xl font-bold uppercase">Servicio Nacional de Aprendizaje SENA</h1>
        <h2 class="text-lg">Centro de Servicios y Gestión Empresarial</h2>
        <h3 class="text-lg font-bold mt-4">Reporte Diario de Programación</h3>
        
        {{-- Información de la Ficha --}}
        <div class="mt-4 bg-gray-50 p-4 border border-gray-300 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-left">
                    <p class="text-sm"><span class="font-medium">Código:</span> {{ Auth::user()->persona->ficha->codigo_ficha }}</p>
                    <p class="text-sm"><span class="font-medium">Programa:</span> {{ Auth::user()->persona->ficha->nombre }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm"><span class="font-medium">Jornada:</span> {{ Auth::user()->persona->ficha->jornada?->descripcion }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-gray-50 p-4 border border-gray-300 mb-6">
        <form action="{{ route('reportes-programacion.aprendiz.diario') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Fecha:</label>
                <input type="date" 
                       name="fecha" 
                       value="{{ request('fecha', $fecha) }}"
                       class="border border-gray-300 px-2 py-1 text-sm rounded">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="bg-[#39A900] text-white px-4 py-1 text-sm rounded hover:bg-[#2d8600]">
                    <i class="fas fa-search me-2"></i>Consultar
                </button>
            </div>
        </form>
    </div>

    {{-- Tabla estilo planilla --}}
    <div class="border border-gray-800">
        <div class="bg-gray-100 p-3 border-b border-gray-800">
            <h2 class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($fecha)->isoFormat('dddd D [de] MMMM [de] YYYY') }}
            </h2>
        </div>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-800">
                    <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Hora</th>
                    <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Ambiente</th>
                    <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Instructor</th>
                    <th class="border-r border-gray-800 px-4 py-2 text-left font-medium">Competencia</th>
                    <th class="px-4 py-2 text-left font-medium">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programaciones as $programacion)
                    <tr class="border-b border-gray-300">
                        <td class="border-r border-gray-300 px-4 py-2">
                            {{ \Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
                        </td>
                        <td class="border-r border-gray-300 px-4 py-2">
                            {{ $programacion->ambiente->numero }} - {{ $programacion->ambiente->alias }}
                        </td>
                        <td class="border-r border-gray-300 px-4 py-2">
                            {{ $programacion->instructor->pnombre }} {{ $programacion->instructor->papellido }}
                        </td>
                        <td class="border-r border-gray-300 px-4 py-2">
                            {{ $programacion->competencia->codigo }} - {{ $programacion->competencia->descripcion }}
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
                            <td class="px-4 py-2">&nbsp;</td>
                        </tr>
                    @endfor
                @endforelse
            </tbody>
        </table>
    </div>
    <a href="{{ request()->fullUrlWithQuery(['pdf' => true]) }}" 
   class="bg-red-600 text-white px-4 py-1 text-sm rounded hover:bg-red-700">
    <i class="fas fa-file-pdf me-2"></i>Descargar PDF
</a>

    {{-- Pie de página --}}
    <div class="mt-8 text-sm">
        <div class="flex justify-between">
            <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
            <p>Página 1 de 1</p>
        </div>
    </div>
</div>
@endsection