<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadiController;
use App\Http\Controllers\JugadoraController;
use App\Http\Controllers\PartitController;
use App\Http\Controllers\EquipController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- RUTAS PROTEGIDAS (Crear, Editar, Borrar) ---
// Es IMPORTANTE definirlas ANTES de las rutas públicas para evitar conflictos de URL
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de gestión completas (excepto las que haremos públicas abajo)
    Route::resource('equips', EquipController::class)->except(['index', 'show']);
    
    // El middleware 'role:admin' protege todo el recurso de estadios
    Route::middleware('role:admin')->resource('estadis', EstadiController::class)->except(['index', 'show']);
    
    Route::resource('partits', PartitController::class)->except(['index', 'show']);
    Route::resource('jugadores', JugadoraController::class)
        ->except(['index', 'show'])
        ->parameter('jugadores', 'jugadora');
});

require __DIR__.'/auth.php';

// --- RUTAS PÚBLICAS (Ver lista y detalle) ---
// Se definen al final para que '/equips/create' tenga prioridad sobre '/equips/{id}'
Route::resource('equips', EquipController::class)->only(['index', 'show']);
Route::resource('estadis', EstadiController::class)->only(['index', 'show']);
Route::resource('partits', PartitController::class)->only(['index', 'show']);
Route::resource('jugadores', JugadoraController::class)
    ->only(['index', 'show'])
    ->parameter('jugadores', 'jugadora');