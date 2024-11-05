@extends('layouts.app')
@section('titulo', 'Editar programación')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>

            </div>
            <a href="{{ route('ambiente-programacion.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver al Listado
            </a>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">¡Atención!</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('ambiente-programacion.update', $programacion->id) }}" 
              method="POST" 
              class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ambiente -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Ambiente *
                    </label>
                    <select name="ambiente_id" required 
                            class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Seleccione el ambiente</option>
                        @foreach($ambientes as $ambiente)
                            <option value="{{ $ambiente->id }}" 
                                    {{ $programacion->ambiente_id == $ambiente->id ? 'selected' : '' }}>
                                {{ $ambiente->numero }} - {{ $ambiente->alias }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Ficha -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Ficha *
                    </label>
                    <select name="ficha_id" required 
                            class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Seleccione la ficha</option>
                        @foreach($fichas as $ficha)
                            <option value="{{ $ficha->id }}" 
                                    {{ $programacion->ficha_id == $ficha->id ? 'selected' : '' }}>
                                {{ $ficha->codigo_ficha }} - {{ $ficha->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jornada -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Jornada *
                    </label>
                    <select name="jornada_id" required 
                            class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Seleccione la jornada</option>
                        @foreach($jornadas as $jornada)
                            <option value="{{ $jornada->id }}" 
                                    {{ $programacion->jornada_id == $jornada->id ? 'selected' : '' }}>
                                {{ $jornada->nombre }}
                                ({{ substr($jornada->hora_inicio, 0, 5) }} - {{ substr($jornada->hora_fin, 0, 5) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Instructor -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Instructor *
                    </label>
                    <select name="persona_id" required 
                            class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Seleccione el instructor</option>
                        @foreach($instructores as $instructor)
                            <option value="{{ $instructor->id }}" 
                                    {{ $programacion->persona_id == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->pnombre }} {{ $instructor->papellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fecha -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Fecha *
                    </label>
                    <input type="date" name="fecha" required 
                           value="{{ $programacion->fecha }}"
                           class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Competencia -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Competencia *
                    </label>
                    <select name="competencia_id" required 
                            class="w-full border border-gray-300 rounded p-2 competencia-select focus:outline-none focus:ring-2 focus:ring-blue-400"
                            onchange="cargarResultados(this)">
                        <option value="">Seleccione la competencia</option>
                        @foreach($competencias as $competencia)
                            <option value="{{ $competencia->id }}" 
                                    {{ $programacion->competencia_id == $competencia->id ? 'selected' : '' }}>
                                {{ $competencia->codigo }} - 
                                {{ Str::limit($competencia->descripcion, 50) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Resultado de Aprendizaje -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Resultado de Aprendizaje *
                    </label>
                    <select name="resultado_aprendizaje_id" required 
                            class="w-full border border-gray-300 rounded p-2 resultado-select focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">Primero seleccione una competencia</option>
                        @if($resultados)
                            @foreach($resultados as $resultado)
                                <option value="{{ $resultado->id }}" 
                                        {{ $programacion->resultado_aprendizaje_id == $resultado->id ? 'selected' : '' }}>
                                    {{ $resultado->codigo }} - {{ $resultado->descripcion }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <div class="text-xs text-gray-600 mt-1" id="horas-info"></div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6 gap-4">
                <a href="{{ route('ambiente-programacion.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Cancelar
                </a>
                <button type="submit" 
                        class="btn btn-success boton-crear">
                    Actualizar Programación
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
async function cargarResultados(competenciaSelect) {
    const resultadoSelect = document.querySelector('.resultado-select');
    const horasInfo = document.getElementById('horas-info');
    const valorActual = '{{ $programacion->resultado_aprendizaje_id }}';
    
    if (competenciaSelect.value) {
        try {
            const response = await fetch(`/api/competencias/${competenciaSelect.value}/resultados`);
            const resultados = await response.json();
            
            resultadoSelect.innerHTML = '<option value="">Seleccione el resultado</option>';
            resultados.forEach(resultado => {
                if (resultado.horas_disponibles >= 6 || resultado.id == valorActual) {
                    resultadoSelect.innerHTML += `
                        <option value="${resultado.id}" ${resultado.id == valorActual ? 'selected' : ''}>
                            ${resultado.codigo} - ${resultado.descripcion}
                            (${resultado.horas_disponibles} horas disponibles)
                        </option>
                    `;
                }
            });
            resultadoSelect.disabled = false;
        } catch (error) {
            console.error('Error al cargar resultados:', error);
            horasInfo.textContent = 'Error al cargar los resultados';
        }
    } else {
        resultadoSelect.innerHTML = '<option value="">Primero seleccione una competencia</option>';
        resultadoSelect.disabled = true;
        horasInfo.textContent = '';
    }
}

// Cargar resultados iniciales si hay una competencia seleccionada
document.addEventListener('DOMContentLoaded', function() {
    const competenciaSelect = document.querySelector('.competencia-select');
    if (competenciaSelect.value) {
        cargarResultados(competenciaSelect);
    }
});
</script>
@endpush
@endsection