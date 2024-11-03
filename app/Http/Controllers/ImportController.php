<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function showImportForm()
    {
        try {
            // Obtener estadísticas
            $totalInstructores = DB::table('cedulas_autorizadas')
                ->where('tipo', 'instructor')
                ->count();
                
            $totalAprendices = DB::table('cedulas_autorizadas')
                ->where('tipo', 'aprendiz')
                ->count();

            // Obtener los últimos documentos importados
            $documentosRecientes = DB::table('cedulas_autorizadas')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return view('admin.import', compact('totalInstructores', 'totalAprendices', 'documentosRecientes'));
        } catch (\Exception $e) {
            Log::error('Error mostrando formulario de importación: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar el formulario de importación.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        try {
            DB::beginTransaction();

            $archivo = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();
            
            if ($extension === 'csv') {
                // Procesar CSV
                $csv = Reader::createFromPath($archivo->getRealPath());
                $csv->setHeaderOffset(0);
                $records = $csv->getRecords();

                foreach ($records as $record) {
                    if (empty($record['documento']) || empty($record['tipo'])) {
                        continue;
                    }

                    DB::table('cedulas_autorizadas')->updateOrInsert(
                        ['documento' => trim($record['documento'])],
                        [
                            'tipo' => strtolower(trim($record['tipo'])),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );
                }
            } else {
                // Procesar TXT
                $contenido = file_get_contents($archivo->getRealPath());
                $lineas = explode("\n", $contenido);
                
                // Omitir la primera línea si contiene encabezados
                $primera_linea = true;
                
                foreach ($lineas as $linea) {
                    if ($primera_linea) {
                        $primera_linea = false;
                        continue;
                    }
                    
                    if (empty(trim($linea))) continue;
                    
                    $datos = explode(',', trim($linea));
                    if (count($datos) !== 2) continue;
                    
                    list($documento, $tipo) = $datos;
                    
                    if (empty(trim($documento)) || empty(trim($tipo))) continue;

                    DB::table('cedulas_autorizadas')->updateOrInsert(
                        ['documento' => trim($documento)],
                        [
                            'tipo' => strtolower(trim($tipo)),
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );
                }
            }

            DB::commit();
            return back()->with('success', 'Documentos importados correctamente.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error importando documentos: ' . $e->getMessage());
            return back()->with('error', 'Error al importar los documentos: ' . $e->getMessage());
        }
    }

    public function eliminarTodo()
    {
        try {
            DB::beginTransaction();
            
            DB::table('cedulas_autorizadas')->truncate();
            
            DB::commit();
            return back()->with('success', 'Todos los registros han sido eliminados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error eliminando registros: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar los registros.');
        }
    }
}