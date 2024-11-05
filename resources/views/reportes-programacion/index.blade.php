{{-- resources/views/reportes-programacion/index.blade.php --}}
@extends('layouts.app')

@section('titulo', 'Reportes de programación')

@section('content')


    <div class="">
        {{-- Reporte Diario --}}
        <div class="">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Reporte Diario</h2>
            <p class="text-gray-600 mb-4">Visualiza la programación de un día específico.</p>
            
            <form action="{{ route('reportes-programacion.diario') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <input type="date" 
                           name="fecha" 
                           value="{{ $fechaHoy }}"
                           class="w-full border border-gray-300 rounded-md p-2">
                </div>

                @if($esAdmin)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ambiente</label>
                    <select name="ambiente_id" class="w-full border border-gray-300 rounded-md p-2">
                        <option value="">Todos los ambientes</option>
                        @foreach($ambientes as $ambiente)
                            <option value="{{ $ambiente->id }}">
                                {{ $ambiente->numero }} - {{ $ambiente->alias }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <button type="submit" class="btn btn-success">
                    Ver Reporte Diario
                </button>
            </form>
        </div>

        {{-- Reporte Semanal --}}
        <div class="">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Reporte Semanal</h2>
            <p class="text-gray-600 mb-4">Visualiza la programación de una semana completa.</p>
            
            <form action="{{ route('reportes-programacion.semanal') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semana del</label>
                    <input type="date" 
                           name="fecha_inicio" 
                           value="{{ $semanaPredeterminada }}"
                           class="w-full border border-gray-300 rounded-md p-2">
                </div>

                @if($esAdmin)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instructor</label>
                    <select name="instructor_id" class="w-full border border-gray-300 rounded-md p-2">
                        <option value="">Todos los instructores</option>
                        @foreach($instructores as $instructor)
                            <option value="{{ $instructor->id }}">
                                {{ $instructor->pnombre }} {{ $instructor->papellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <button type="submit" class="btn btn-success">
                    Ver Reporte Semanal
                </button>
            </form>
        </div>

        {{-- Reporte Mensual --}}
        <div class="">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Reporte Mensual</h2>
            <p class="text-gray-600 mb-4">Visualiza la programación de un mes completo.</p>
            
            <form action="{{ route('reportes-programacion.mensual') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mes</label>
                    <input type="month" 
                           name="mes" 
                           value="{{ $mesPredeterminado }}"
                           class="w-full border border-gray-300 rounded-md p-2">
                </div>

                @if($esAdmin)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filtros</label>
                    <div class="grid grid-cols-2 gap-2">
                        <select name="ambiente_id" class="border border-gray-300 rounded-md p-2">
                            <option value="">Ambiente</option>
                            @foreach($ambientes as $ambiente)
                                <option value="{{ $ambiente->id }}">
                                    {{ $ambiente->numero }}
                                </option>
                            @endforeach
                        </select>
                        <select name="instructor_id" class="border border-gray-300 rounded-md p-2">
                            <option value="">Instructor</option>
                            @foreach($instructores as $instructor)
                                <option value="{{ $instructor->id }}">
                                    {{ $instructor->pnombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                <button type="submit" class="btn btn-success">
                    Ver Reporte Mensual
                </button>
            </form>
        </div>
    </div>

@endsection