<?php

use App\Http\Controllers\PersonasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramaFormacionController;
use App\Http\Controllers\CompetenciaController;
use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\ResultadoAprendizajeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckPersonaRegistration;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

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
    });
    

    Route::middleware([CheckPersonaRegistration::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Otras rutas protegidas
    });
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
    Route::get('/recursos', [RecursoController::class, 'index'])->name('recursos.index');
    Route::get('/recursos/create', [RecursoController::class, 'create'])->name('recursos.create');
    Route::post('/recursos', [RecursoController::class, 'store'])->name('recursos.store');
    Route::get('/recursos/{id}/edit', [RecursoController::class, 'edit'])->name('recursos.edit');
    Route::put('/recursos/{id}', [RecursoController::class, 'update'])->name('recursos.update');
    Route::delete('/recursos/{id}', [RecursoController::class, 'destroy'])->name('recursos.destroy');
    
    // Novedades
    Route::get('/novedades', [NovedadController::class, 'index'])->name('novedades.index');
    Route::get('/novedades/create', [NovedadController::class, 'create'])->name('novedades.create');
    Route::post('/novedades', [NovedadController::class, 'store'])->name('novedades.store');
    Route::get('/novedades/{id}/edit', [NovedadController::class, 'edit'])->name('novedades.edit');
    Route::put('/novedades/{id}', [NovedadController::class, 'update'])->name('novedades.update');
    Route::delete('/novedades/{id}', [NovedadController::class, 'destroy'])->name('novedades.destroy');
});
