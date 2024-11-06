<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\ProgramaFormacionController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\ResultadoAprendizajeController;
use App\Http\Controllers\RedConocimientoController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TipoAmbienteController;
use App\Http\Controllers\EstadoAmbienteController;
use App\Http\Controllers\AmbienteProgramacionController;
use App\Http\Controllers\ReporteProgramacionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckPersonaRegistration;

Route::get('/', function () {
    return view('home');
});


Route::middleware([CheckPersonaRegistration::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Otras rutas protegidas
});


Route::get('/verificar-documento/{documento}', [App\Http\Controllers\Auth\RegisterController::class, 'verificarDocumento'])
    ->name('verificar.documento');

Route::get('/api/instructores-por-red/{redId}', [FichaController::class, 'getInstructoresPorRed'])->name('api.instructores.por.red');

Route::get('/api/competencias/{competencia}/resultados', [AmbienteProgramacionController::class, 'getResultados'])
    ->name('competencias.resultados')
    ->middleware('api.access');

 Route::post('/api/validar-disponibilidad', [AmbienteProgramacionController::class, 'validarDisponibilidad'])
    ->name('api.validar-disponibilidad');
Route::get('/api/competencias/{competencia}/resultados', [AmbienteProgramacionController::class, 'getResultados'])
    ->name('api.competencias.resultados');

Auth::routes();




Route::prefix('personas')->group(function () {
    Route::get('/buscar', [PersonasController::class, 'buscar'])->name('personas.buscar');

    Route::middleware(['auth'])->group(function () {
        Route::get('/', [PersonasController::class, 'index'])->name('personas.index');
        Route::get('/create', [PersonasController::class, 'create'])->name('personas.create');
        Route::post('/', [PersonasController::class, 'store'])->name('personas.store');
        Route::get('/{persona}', [PersonasController::class, 'show'])->name('personas.show');
        Route::get('/{persona}/edit', [PersonasController::class, 'edit'])->name('personas.edit');
        Route::put('/{persona}', [PersonasController::class, 'update'])->name('personas.update');
        Route::delete('/{persona}', [PersonasController::class, 'destroy'])->name('personas.destroy');

        Route::get('/settings/{persona}/edit', [PersonasController::class, 'settings'])->name('personas.settings');
        Route::put('/settings/{persona}', [PersonasController::class, 'updateSettings'])->name('personas.updateSettings');
    });
    

});



// Rutas para ProgramaFormacion
Route::prefix('programas')->middleware(['auth'])->group(function () {
    Route::get('/', [ProgramaFormacionController::class, 'index'])->name('programas.index');
    Route::get('/create', [ProgramaFormacionController::class, 'create'])->name('programas.create');
    Route::post('/', [ProgramaFormacionController::class, 'store'])->name('programas.store');
    Route::post('/', [ProgramaFormacionController::class, 'store'])->name('programas.store');
    Route::get('/{programa}', [ProgramaFormacionController::class, 'show'])->name('programas.show');
    Route::get('/{programa}/edit', [ProgramaFormacionController::class, 'edit'])->name('programas.edit');
    Route::put('/{programa}', [ProgramaFormacionController::class, 'update'])->name('programas.update');
    Route::delete('/{programa}', [ProgramaFormacionController::class, 'destroy'])->name('programas.destroy');
    Route::get('/get-programas/{redConocimiento}', [ProgramaFormacionController::class, 'getProgramasPorRed'])->name('get.programas');
});
Route::prefix('competencias')->middleware(['auth'])->group(function () {
    // Rutas base CRUD
    Route::get('/', [CompetenciaController::class, 'index'])->name('competencias.index');
    Route::get('/create', [CompetenciaController::class, 'create'])->name('competencias.create');
    Route::post('/', [CompetenciaController::class, 'store'])->name('competencias.store');
    Route::get('/{competencia}', [CompetenciaController::class, 'show'])->name('competencias.show');
    Route::get('/{competencia}/edit', [CompetenciaController::class, 'edit'])->name('competencias.edit');
    Route::put('/{competencia}', [CompetenciaController::class, 'update'])->name('competencias.update');
    Route::delete('/{competencia}', [CompetenciaController::class, 'destroy'])->name('competencias.destroy');

    // Rutas para distribución de horas
    Route::get('/{competencia}/distribuir-horas', [CompetenciaController::class, 'distribuirHoras'])
        ->name('competencias.distribuir-horas');
    Route::put('/{competencia}/resultados-aprendizaje/horas', [ResultadoAprendizajeController::class, 'updateHoras'])
        ->name('resultados-aprendizaje.update-horas');

   // Rutas para asignación de instructores
   Route::get('/{competencia}/asignar-instructor', [CompetenciaController::class, 'asignarInstructor'])
   ->name('competencias.instructor.asignar');
Route::post('/{competencia}/asignar-instructor', [CompetenciaController::class, 'guardarAsignacionInstructor'])
   ->name('competencias.instructor.guardar');
});

Route::prefix('resultados_aprendizaje')->middleware(['auth'])->group(function () {
    Route::get('/', [ResultadoAprendizajeController::class, 'index'])->name('resultados_aprendizaje.index');
    Route::get('/create', [ResultadoAprendizajeController::class, 'create'])->name('resultados_aprendizaje.create');
    Route::post('/', [ResultadoAprendizajeController::class, 'store'])->name('resultados_aprendizaje.store');
    Route::get('/{resultadoAprendizaje}', [ResultadoAprendizajeController::class, 'show'])->name('resultados_aprendizaje.show');
    Route::get('/{resultadoAprendizaje}/edit', [ResultadoAprendizajeController::class, 'edit'])->name('resultados_aprendizaje.edit');
    Route::put('/{resultadoAprendizaje}', [ResultadoAprendizajeController::class, 'update'])->name('resultados_aprendizaje.update');
    Route::delete('/{resultadoAprendizaje}', [ResultadoAprendizajeController::class, 'destroy'])->name('resultados_aprendizaje.destroy');
});

Route::prefix('red-conocimiento')->middleware(['auth'])->group(function () {
    Route::get('/', [RedConocimientoController::class, 'index'])->name('red_conocimiento.index');
    Route::get('/create', [RedConocimientoController::class, 'create'])->name('red_conocimiento.create');
    Route::post('/', [RedConocimientoController::class, 'store'])->name('red_conocimiento.store');
    Route::get('/{redConocimiento}', [RedConocimientoController::class, 'show'])->name('red_conocimiento.show');
    Route::get('/{redConocimiento}/edit', [RedConocimientoController::class, 'edit'])->name('red_conocimiento.edit');
    Route::put('/{redConocimiento}', [RedConocimientoController::class, 'update'])->name('red_conocimiento.update');
    Route::delete('/{redConocimiento}', [RedConocimientoController::class, 'destroy'])->name('red_conocimiento.destroy');
});
Route::prefix('fichas')->middleware(['auth'])->group(function () {
    Route::get('/', [FichaController::class, 'index'])->name('fichas.index');
    Route::get('/create', [FichaController::class, 'create'])->name('fichas.create');
    Route::post('/', [FichaController::class, 'store'])->name('fichas.store');
    Route::get('/{ficha}', [FichaController::class, 'show'])->name('fichas.show');
    Route::get('/{ficha}/edit', [FichaController::class, 'edit'])->name('fichas.edit');
    Route::put('/{ficha}', [FichaController::class, 'update'])->name('fichas.update');
    Route::delete('/{ficha}', [FichaController::class, 'destroy'])->name('fichas.destroy');
    Route::get('/fichas/{ficha}/imprimir-aprendices', [FichaController::class, 'imprimirAprendices'])->name('fichas.imprimir-aprendices');
});
Route::prefix('jornadas')->middleware(['auth'])->group(function () {
    Route::get('/', [JornadaController::class, 'index'])->name('jornadas.index');
    Route::get('/create', [JornadaController::class, 'create'])->name('jornadas.create');
    Route::post('/', [JornadaController::class, 'store'])->name('jornadas.store');
    Route::get('/{jornada}', [JornadaController::class, 'show'])->name('jornadas.show');
    Route::get('/{jornada}/edit', [JornadaController::class, 'edit'])->name('jornadas.edit');
    Route::put('/{jornada}', [JornadaController::class, 'update'])->name('jornadas.update');
    Route::delete('/{jornada}', [JornadaController::class, 'destroy'])->name('jornadas.destroy');
});
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Ambientes
    Route::get('/ambientes', [AmbienteController::class, 'index'])->name('ambientes.index');
    Route::get('/ambientes/create', [AmbienteController::class, 'create'])->name('ambientes.create');
    Route::post('/ambientes', [AmbienteController::class, 'store'])->name('ambientes.store');
    Route::get('/ambientes/{id}', [AmbienteController::class, 'show'])->name('ambientes.show');
    Route::get('/ambientes/{id}/edit', [AmbienteController::class, 'edit'])->name('ambientes.edit');
    Route::put('/ambientes/{id}', [AmbienteController::class, 'update'])->name('ambientes.update');
    Route::delete('/ambientes/{id}', [AmbienteController::class, 'destroy'])->name('ambientes.destroy');
    
    // Recursos
    Route::get('/recursos/pdf', [RecursoController::class, 'generarPDF'])->name('recursos.pdf'); // Asegúrate de que esta línea esté aquí.
    Route::get('/recursos', [RecursoController::class, 'index'])->name('recursos.index');
    Route::get('/recursos/create', [RecursoController::class, 'create'])->name('recursos.create');
    Route::post('/recursos', [RecursoController::class, 'store'])->name('recursos.store');
    Route::get('/recursos/{id}', [RecursoController::class, 'show'])->name('recursos.show');
    Route::get('/recursos/{id}/edit', [RecursoController::class, 'edit'])->name('recursos.edit');
    Route::put('/recursos/{id}', [RecursoController::class, 'update'])->name('recursos.update');
    Route::delete('/recursos/{id}', [RecursoController::class, 'destroy'])->name('recursos.destroy');
    
    Route::get('/novedades/pdf', [NovedadController::class, 'generarPDF'])->name('novedades.pdf'); // Asegúrate de que esta línea esté aquí.
    // Novedades
    Route::get('/novedades', [NovedadController::class, 'index'])->name('novedades.index');
    Route::get('/novedades/create', [NovedadController::class, 'create'])->name('novedades.create');
    Route::post('/novedades', [NovedadController::class, 'store'])->name('novedades.store');
    Route::get('/novedades/{id}', [NovedadController::class, 'show'])->name('novedades.show');
    Route::get('/novedades/{id}/edit', [NovedadController::class, 'edit'])->name('novedades.edit');
    Route::put('/novedades/{id}', [NovedadController::class, 'update'])->name('novedades.update');
    Route::delete('/novedades/{id}', [NovedadController::class, 'destroy'])->name('novedades.destroy');
   
    Route::get('/tipo-ambientes', [TipoAmbienteController::class, 'index'])->name('tipo-ambientes.index');
    Route::get('/tipo-ambientes/create', [TipoAmbienteController::class, 'create'])->name('tipo-ambientes.create');
    Route::post('/tipo-ambientes', [TipoAmbienteController::class, 'store'])->name('tipo-ambientes.store');
    Route::get('/tipo-ambientes/{id}', [TipoAmbienteController::class, 'show'])->name('tipo-ambientes.show');
    Route::get('/tipo-ambientes/{id}/edit', [TipoAmbienteController::class, 'edit'])->name('tipo-ambientes.edit');
    Route::put('/tipo-ambientes/{id}', [TipoAmbienteController::class, 'update'])->name('tipo-ambientes.update');
    Route::delete('/tipo-ambientes/{id}', [TipoAmbienteController::class, 'destroy'])->name('tipo-ambientes.destroy');
    
// Rutas para Estado Ambiente
Route::get('/estado-ambientes', [EstadoAmbienteController::class, 'index'])->name('estado-ambientes.index');
Route::get('/estado-ambientes/create', [EstadoAmbienteController::class, 'create'])->name('estado-ambientes.create');
Route::post('/estado-ambientes', [EstadoAmbienteController::class, 'store'])->name('estado-ambientes.store');
Route::get('/estado-ambientes/{id}', [EstadoAmbienteController::class, 'show'])->name('estado-ambientes.show');
Route::get('/estado-ambientes/{id}/edit', [EstadoAmbienteController::class, 'edit'])->name('estado-ambientes.edit');
Route::put('/estado-ambientes/{id}', [EstadoAmbienteController::class, 'update'])->name('estado-ambientes.update');
Route::delete('/estado-ambientes/{id}', [EstadoAmbienteController::class, 'destroy'])->name('estado-ambientes.destroy');
});


Route::prefix('ambiente-programacion')->middleware(['auth'])->group(function () {
    Route::get('/', [AmbienteProgramacionController::class, 'index'])->name('ambiente-programacion.index');
    Route::get('/create', [AmbienteProgramacionController::class, 'create'])->name('ambiente-programacion.create');
    Route::post('/', [AmbienteProgramacionController::class, 'store'])->name('ambiente-programacion.store');
    Route::get('/{ambienteProgramacion}', [AmbienteProgramacionController::class, 'show'])->name('ambiente-programacion.show');
    Route::get('/{ambienteProgramacion}/edit', [AmbienteProgramacionController::class, 'edit'])->name('ambiente-programacion.edit');
    Route::put('/{ambienteProgramacion}', [AmbienteProgramacionController::class, 'update'])->name('ambiente-programacion.update');
    Route::delete('/{ambienteProgramacion}', [AmbienteProgramacionController::class, 'destroy'])->name('ambiente-programacion.destroy');
    Route::post('/{id}/generar-sesiones', [AmbienteProgramacionController::class, 'generarSesiones'])
        ->name('ambiente-programacion.generar-sesiones');
    
    Route::get('/api/competencias/{competencia}/resultados', [AmbienteProgramacionController::class, 'getResultados'])->name('competencias.resultados');
    
});



// Grupo de rutas para reportes de programación
Route::middleware(['auth'])->group(function () {
    // Ruta base de reportes
    Route::get('/reportes-programacion', [ReporteProgramacionController::class, 'index'])
        ->name('reportes-programacion.index');

    // Rutas para administrador

        Route::get('/reportes-programacion/diario', [ReporteProgramacionController::class, 'diario'])
            ->name('reportes-programacion.diario');
        Route::get('/reportes-programacion/semanal', [ReporteProgramacionController::class, 'semanal'])
            ->name('reportes-programacion.semanal');
        Route::get('/reportes-programacion/mensual', [ReporteProgramacionController::class, 'mensual'])
            ->name('reportes-programacion.mensual');

    // Rutas para instructor
 
        Route::get('/diario', [ReporteProgramacionController::class, 'diario'])
            ->name('reportes-programacion.instructor.diario');
        Route::get('/semanal', [ReporteProgramacionController::class, 'semanal'])
            ->name('reportes-programacion.instructor.semanal');
        Route::get('/mensual', [ReporteProgramacionController::class, 'mensual'])
            ->name('reportes-programacion.instructor.mensual');
   
    // Rutas para aprendiz
        Route::get('/diario', [ReporteProgramacionController::class, 'diario'])
            ->name('reportes-programacion.aprendiz.diario');
        Route::get('/semanal', [ReporteProgramacionController::class, 'semanal'])
            ->name('reportes-programacion.aprendiz.semanal');
        Route::get('/mensual', [ReporteProgramacionController::class, 'mensual'])
            ->name('reportes-programacion.aprendiz.mensual');
});


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Rutas de administrador
});

Route::prefix('reportes-programacion')->middleware(['auth'])->group(function () {
    // Rutas para instructor
        Route::get('/instructor/diario', [ReporteProgramacionController::class, 'diario'])
            ->name('reportes-programacion.instructor.diario');
        Route::get('/instructor/semanal', [ReporteProgramacionController::class, 'semanal'])
            ->name('reportes-programacion.instructor.semanal');
        Route::get('/instructor/mensual', [ReporteProgramacionController::class, 'mensual'])
            ->name('reportes-programacion.instructor.mensual');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/importar', [ImportController::class, 'showImportForm'])->name('import.form');
        Route::post('/admin/importar', [ImportController::class, 'import'])->name('import.documentos');
        Route::get('/admin/importar/eliminar', [ImportController::class, 'eliminarTodo'])->name('import.eliminar');
    });

   
    // Rutas para aprendiz
        Route::get('/aprendiz/diario', [ReporteProgramacionController::class, 'diario'])
            ->name('reportes-programacion.aprendiz.diario');
        Route::get('/aprendiz/semanal', [ReporteProgramacionController::class, 'semanal'])
            ->name('reportes-programacion.aprendiz.semanal');
        Route::get('/aprendiz/mensual', [ReporteProgramacionController::class, 'mensual'])
            ->name('reportes-programacion.aprendiz.mensual');


    Route::get('/diario/excel', [ReporteProgramacionController::class, 'exportarDiarioExcel'])
    ->name('reportes-programacion.diario.excel');
Route::get('/diario/pdf', [ReporteProgramacionController::class, 'exportarDiarioPDF'])
    ->name('reportes-programacion.diario.pdf');

Route::get('/semanal/excel', [ReporteProgramacionController::class, 'exportarSemanalExcel'])
    ->name('reportes-programacion.semanal.excel');
Route::get('/semanal/pdf', [ReporteProgramacionController::class, 'exportarSemanalPDF'])
    ->name('reportes-programacion.semanal.pdf');

Route::get('/mensual/excel', [ReporteProgramacionController::class, 'exportarMensualExcel'])
    ->name('reportes-programacion.mensual.excel');
Route::get('/mensual/pdf', [ReporteProgramacionController::class, 'exportarMensualPDF'])
    ->name('reportes-programacion.mensual.pdf');

    Route::prefix('reportes-programacion')->middleware(['auth'])->group(function () {
        // ... otras rutas ...
        
        Route::get('/diario/pdf', [ReporteProgramacionController::class, 'exportarDiarioPDF'])
             ->name('reportes-programacion.diario.pdf');
    });
});
