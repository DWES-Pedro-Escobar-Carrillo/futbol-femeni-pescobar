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

// GRUP PROTEGIT: Tot el que hi ha aquí dins requereix estar loguejat
Route::middleware('auth')->group(function () {
    // Perfil d'usuari
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RECURSOS (Ara estan protegits i comparteixen sessió correctament)
    Route::resource('estadis', EstadiController::class);
    Route::resource('partits', PartitController::class);
    Route::resource('equips', EquipController::class);
    Route::resource('jugadores', JugadoraController::class)->parameter('jugadores', 'jugadora');
});

require __DIR__.'/auth.php';