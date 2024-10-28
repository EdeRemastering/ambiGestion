<?php

use App\Http\Controllers\PersonasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\ProgramacionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckPersonaRegistration;
use App\Http\Middleware\CheckRoleRedirect;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Grupo de rutas para "personas"
Route::middleware(['auth'])->group(function () {
    Route::prefix('personas')->group(function () {
        Route::get('/settings/{persona}/edit', [PersonasController::class, 'settings'])->name('personas.settings');
        Route::put('/settings/{persona}', [PersonasController::class, 'updateSettings'])->name('personas.updateSettings');
    });

    Route::middleware([CheckPersonaRegistration::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});

// Middleware para redirigir según roles
Route::middleware(['auth', CheckRoleRedirect::class])->group(function () {

     
            // Rutas para el rol "admin"
            Route::prefix('admin')->group(function () {
                Route::resource('personas', PersonasController::class);
                Route::resource('ambientes', AmbienteController::class);
                Route::resource('recursos', RecursoController::class);
                Route::resource('novedades', NovedadController::class);
                Route::resource('programas', ProgramaController::class);
                Route::resource('fichas', FichaController::class);
                Route::resource('programaciones', ProgramacionController::class);
            });

            // Rutas para el rol "instructor_lider"
            Route::prefix('instructor-lider')->group(function () {
                Route::get('/ambientes', [AmbienteController::class, 'index'])->name('ambientes.index');
                Route::get('/ambientes/{id}', [AmbienteController::class, 'show'])->name('ambientes.show');
                Route::get('/recursos', [RecursoController::class, 'index'])->name('recursos.index');
                Route::get('/recursos/{id}', [RecursoController::class, 'show'])->name('recursos.show');
                Route::get('/novedades', [NovedadController::class, 'index'])->name('novedades.index');
                Route::get('/novedades/{id}', [NovedadController::class, 'show'])->name('novedades.show');
                Route::get('/programas', [ProgramaController::class, 'index'])->name('programas.index');
                Route::get('/programas/{id}', [ProgramaController::class, 'show'])->name('programas.show');
                Route::get('/fichas', [FichaController::class, 'index'])->name('fichas.index');
                Route::get('/fichas/{id}', [FichaController::class, 'show'])->name('fichas.show');
                Route::resource('programaciones', ProgramacionController::class);
            });

    
    
    // Rutas para el rol "instructor"
    Route::prefix('instructor')->group(function () {
        Route::get('/mis-programaciones', [ProgramacionController::class, 'misProgramaciones'])->name('programaciones.mis_programaciones');
    });

    // Rutas para el rol "aprendiz"
    Route::prefix('aprendiz')->group(function () {
        Route::get('/mis-clases', [ProgramacionController::class, 'misClases'])->name('programaciones.mis_clases');
    });


});
