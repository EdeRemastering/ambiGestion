@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Importar Documentos Autorizados</h2>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-800">Total Instructores</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalInstructores }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-green-800">Total Aprendices</h3>
                <p class="text-3xl font-bold text-green-600">{{ $totalAprendices }}</p>
            </div>
        </div>

        <!-- Formulario de importación -->
        <div class="bg-gray-50 p-6 rounded-lg mb-6">
            <h3 class="text-lg font-semibold mb-4">Importar Archivo</h3>
            
            <form action="{{ route('import.documentos') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex flex-col space-y-2">
                    <label for="archivo" class="text-sm font-medium text-gray-700">
                        Seleccionar Archivo (CSV o TXT)
                    </label>
                    <input type="file" 
                           id="archivo" 
                           name="archivo" 
                           accept=".csv,.txt"
                           class="border border-gray-300 rounded-md p-2">
                    @error('archivo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Importar Documentos
                    </button>
                    
                    <a href="{{ route('import.eliminar') }}" 
                       class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition"
                       onclick="return confirm('¿Estás seguro de querer eliminar todos los registros?')">
                        Eliminar Todo
                    </a>
                </div>
            </form>
        </div>

        <!-- Instrucciones -->
        <div class="bg-yellow-50 p-6 rounded-lg mb-6">
            <h3 class="text-lg font-semibold mb-2">Instrucciones</h3>
            <ul class="list-disc list-inside space-y-2 text-sm">
                <li>El archivo debe estar en formato CSV o TXT</li>
                <li>El formato debe ser: documento,tipo</li>
                <li>El tipo debe ser "instructor" o "aprendiz"</li>
                <li>Ejemplo de contenido:
                    <pre class="bg-gray-800 text-white p-2 rounded-md mt-2">
documento,tipo
1234567,instructor
7654321,aprendiz</pre>
                </li>
            </ul>
        </div>

        <!-- Documentos Recientes -->
        <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Últimos Documentos Importados</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($documentosRecientes as $documento)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $documento->documento }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $documento->tipo === 'instructor' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($documento->tipo) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $documento->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div id="success-alert" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="error-alert" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
@endif

<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');
        
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
</script>
@endsection