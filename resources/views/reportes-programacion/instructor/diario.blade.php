@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado --}}
    <div class="text-center mb-8">
        <h1 class="text-xl font-bold uppercase">Servicio Nacional de Aprendizaje SENA</h1>
        <h2 class="text-lg">Centro de Servicios y Gestión Empresarial</h2>
        <h3 class="text-lg font-bold mt-4">Reporte Diario de Programación - Instructor</h3>
        
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
                        <span class="font-medium">Fecha:</span> 
                        {{ \Carbon\Carbon::parse($fecha)->isoFormat('LL') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-gray-50 p-4 border border-gray-300 mb-6">
        <form action="{{ route('reportes-programacion.instructor.diario') }}" method="GET" class="flex flex-wrap gap-4 items-center">
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
                <th class="border border-gray-300 px-4 py-2 text-left">Hora</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Ambiente</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Ficha</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Programa</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Resultado de Aprendizaje</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programaciones as $programacion)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">
                            {{ \Carbon\Carbon::parse($programacion->hora_inicio)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($programacion->hora_fin)->format('H:i') }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $programacion->ambiente->numero }} - {{ $programacion->ambiente->alias }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $programacion->ficha->codigo_ficha }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $programacion->ficha->nombre }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                         {{ $programacion->resultadoAprendizaje->descripcion }}
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
                @empty
                    <tr>
                        <td colspan="6" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                            No hay programaciones para este día
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection