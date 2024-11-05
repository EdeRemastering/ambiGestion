@extends('layouts.app')
@section('titulo', 'Calendario mensual de programaciones')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado tipo planilla --}}
    <div class="text-center mb-8">
        
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
        
        <p class="text-sm mt-2">{{ $mesActual }}</p>
    </div>

    {{-- Filtros --}}
    <div class="bg-gray-50 p-4 border border-gray-300 mb-6">
        <form action="{{ route('reportes-programacion.mensual') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium">Mes:</label>
                <input type="month" 
                       name="mes" 
                       value="{{ request('mes', $mes) }}"
                       class="border border-gray-300 px-2 py-1 text-sm rounded">
            </div>
            @if($esAdmin)
                <div class="flex items-center gap-2">
                    <label class="text-sm font-medium">Ambiente:</label>
                    <select name="ambiente_id" class="border border-gray-300 px-2 py-1 text-sm rounded">
                        <option value="">Todos los ambientes</option>
                        @foreach($ambientes as $ambiente)
                            <option value="{{ $ambiente->id }}" {{ request('ambiente_id') == $ambiente->id ? 'selected' : '' }}>
                                {{ $ambiente->numero }} - {{ $ambiente->alias }}
                            </option>
                        @endforeach
                    </select>
                </div>
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
</div>

@push('scripts')
<script>
function irAReporteDiario(fecha) {
    // Obtener los filtros actuales
    const urlParams = new URLSearchParams(window.location.search);
    const ambiente_id = urlParams.get('ambiente_id') || '';
    const instructor_id = urlParams.get('instructor_id') || '';
    
    // Construir la URL con los filtros
    let url = `{{ route('reportes-programacion.diario') }}?fecha=${fecha}`;
    if(ambiente_id) url += `&ambiente_id=${ambiente_id}`;
    if(instructor_id) url += `&instructor_id=${instructor_id}`;
    
    // Redirigir manteniendo los filtros
    window.location.href = url;
}
</script>
@endpush
@endsection