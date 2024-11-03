@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">SERVICIO NACIONAL DE APRENDIZAJE SENA</h1>
                <h2 class="text-xl">Centro de Servicios y Gestión Empresarial</h2>
                <h3 class="text-lg font-bold mt-2">Programación Semanal de Ambientes</h3>
            </div>
            <a href="{{ route('ambiente-programacion.create') }}" 
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Nueva Programación
            </a>
        </div>

        <!-- Filtros -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form action="{{ route('ambiente-programacion.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Semana del:</label>
                    <input type="date" name="fecha_inicio" 
                           value="{{ request('fecha_inicio', $fechaInicio->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ambiente:</label>
                    <select name="ambiente_id" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos los ambientes</option>
                        @foreach($ambientes as $ambiente)
                            <option value="{{ $ambiente->id }}" {{ request('ambiente_id') == $ambiente->id ? 'selected' : '' }}>
                                {{ $ambiente->numero }} - {{ $ambiente->alias }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Instructor:</label>
                    <select name="instructor_id" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos los instructores</option>
                        @foreach($instructores as $instructor)
                            <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->pnombre }} {{ $instructor->papellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de programaciones -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 border-b">
                <h4 class="font-semibold">Total Programaciones: {{ collect($programacionesPorDia)->flatten()->count() }}</h4>
            </div>
            
            <div class="overflow-x-auto">
                <table id="" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Día y Fecha
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hora
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ambiente
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ficha
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Instructor
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Resultado de Aprendizaje
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($diasSemana as $dia)
                            @php
                                $programacionesDia = $programacionesPorDia[$dia->format('Y-m-d')] ?? collect([]);
                            @endphp

                            @if($programacionesDia->count() > 0)
                                @foreach($programacionesDia as $prog)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">
                                                {{ strtr($dia->format('l'), [
                                                    'Monday' => 'Lunes',
                                                    'Tuesday' => 'Martes',
                                                    'Wednesday' => 'Miércoles',
                                                    'Thursday' => 'Jueves',
                                                    'Friday' => 'Viernes',
                                                    'Saturday' => 'Sábado',
                                                    'Sunday' => 'Domingo'
                                                ]) }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $dia->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ Carbon\Carbon::parse($prog->hora_inicio)->format('H:i') }} - 
                                            {{ Carbon\Carbon::parse($prog->hora_fin)->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $prog->ambiente->numero }} - {{ $prog->ambiente->alias }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $prog->ficha->codigo_ficha }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $prog->instructor->pnombre }} {{ $prog->instructor->papellido }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $prog->resultadoAprendizaje->descripcion }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('ambiente-programacion.show', $prog->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900">Ver</a>
                                                <a href="{{ route('ambiente-programacion.edit', $prog->id) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900">Editar</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ strtr($dia->format('l'), [
                                                'Monday' => 'Lunes',
                                                'Tuesday' => 'Martes',
                                                'Wednesday' => 'Miércoles',
                                                'Thursday' => 'Jueves',
                                                'Friday' => 'Viernes',
                                                'Saturday' => 'Sábado',
                                                'Sunday' => 'Domingo'
                                            ]) }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $dia->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        No hay programaciones para este día
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection