@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado tipo planilla --}}
    <div class="text-center mb-8">
        <h1 class="text-xl font-bold uppercase">Servicio Nacional de Aprendizaje SENA</h1>
        <h2 class="text-lg">Centro de Servicios y Gestión Empresarial</h2>
        <h3 class="text-lg font-bold mt-4">Calendario Mensual de Programación</h3>
        
        @php
            setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain.1252');
            \Carbon\Carbon::setLocale('es');
            $mesActual = ucfirst(\Carbon\Carbon::parse($mes)->isoFormat('MMMM [de] YYYY'));
            
            // Variables para el calendario
            $fechaInicio = \Carbon\Carbon::parse($mes)->startOfMonth();
            $diasEnMes = $fechaInicio->daysInMonth;
            $diaSemanaInicio = $fechaInicio->dayOfWeek;
            
            // Agrupar programaciones por día
            $programacionesPorDia = $programaciones->groupBy(function($prog) {
                return Carbon\Carbon::parse($prog->fecha)->format('Y-m-d');
            });
        @endphp

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
                    <p class="text-sm font-medium">{{ $mesActual }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-gray-50 p-4 border border-gray-300 mb-6">
        <form action="{{ route('reportes-programacion.instructor.mensual') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Mes:</label>
                <input type="month" 
                       name="mes" 
                       value="{{ request('mes', $mes) }}"
                       class="border border-gray-300 px-2 py-1 text-sm rounded">
            </div>

            <button type="submit" class="bg-[#39A900] text-white px-4 py-1 text-sm rounded hover:bg-[#2d8600]">
                Consultar
            </button>
        </form>
    </div>

    {{-- Calendario --}}
    <div class="border border-gray-800 bg-white">
        {{-- Días de la semana --}}
        <div class="grid grid-cols-7 bg-gray-100 border-b border-gray-800">
            @foreach(['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                <div class="px-2 py-3 text-center font-medium border-r border-gray-800 last:border-r-0">
                    {{ $dia }}
                </div>
            @endforeach
        </div>

        {{-- Días del mes --}}
        <div class="grid grid-cols-7">
            {{-- Espacios vacíos antes del primer día --}}
            @for($i = 0; $i < $diaSemanaInicio; $i++)
                <div class="aspect-square border-r border-b border-gray-300 bg-gray-50"></div>
            @endfor

            {{-- Días del mes --}}
            @for($dia = 1; $dia <= $diasEnMes; $dia++)
                @php
                    $fecha = $fechaInicio->copy()->addDays($dia - 1)->format('Y-m-d');
                    $tieneProgramacion = $programacionesPorDia->has($fecha);
                    $programacionesDia = $programacionesPorDia->get($fecha, collect());
                @endphp
                
                <div class="aspect-square border-r border-b border-gray-300 relative group">
                    <button type="button" 
                            onclick="irAReporteDiario('{{ $fecha }}')"
                            class="w-full h-full p-2 text-left {{ $tieneProgramacion ? 'hover:bg-green-50' : '' }}">
                        {{-- Número del día --}}
                        <span class="text-lg font-medium {{ $tieneProgramacion ? 'text-[#39A900]' : '' }}">
                            {{ $dia }}
                        </span>
                        
                        @if($tieneProgramacion)
                            {{-- Indicador de programaciones --}}
                            <div class="mt-1 space-y-1">
                                <div class="text-xs text-gray-600">
                                    {{ $programacionesDia->count() }} programación(es)
                                </div>
                            </div>
                        @endif
                    </button>
                </div>
            @endfor

            {{-- Espacios vacíos después del último día --}}
            @php
                $ultimoDiaSemana = ($diaSemanaInicio + $diasEnMes - 1) % 7;
                $espaciosFinal = 6 - $ultimoDiaSemana;
            @endphp
            @for($i = 0; $i <= $espaciosFinal; $i++)
                <div class="aspect-square border-r border-b border-gray-300 bg-gray-50"></div>
            @endfor
        </div>
    </div>

    <div class="mt-4 flex justify-end">
        <a href="{{ route('reportes-programacion.instructor.mensual', ['mes' => request('mes', $mes), 'pdf' => true]) }}" 
           class="bg-red-600 text-white px-4 py-1 text-sm rounded hover:bg-red-700">
            <i class="fas fa-file-pdf me-2"></i>Descargar PDF
        </a>
    </div>
</div>

@push('scripts')
<script>
function irAReporteDiario(fecha) {
    window.location.href = `{{ route('reportes-programacion.instructor.diario') }}?fecha=${fecha}`;
}
</script>
@endpush
@endsection