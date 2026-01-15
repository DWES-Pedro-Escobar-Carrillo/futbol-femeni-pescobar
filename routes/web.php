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

Route::get('/historic', [PartitController::class, 'historic'])->name('partits.historic');

// --- TOTES LES RUTES PROTEGIDES (Auth Requerit) ---
// Ara tot està dins del grup 'auth'. Si no estàs loguejat, Laravel et redirigeix al login.
Route::middleware('auth')->group(function () {
    
    // Perfil d'usuari
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 1. ESTADIS: 
    //    - Crear/Editar/Esborrar -> Només Admin (middleware role:admin)
    //    - Veure (index/show)    -> Qualsevol usuari loguejat
    Route::middleware('role:admin')->resource('estadis', EstadiController::class)->except(['index', 'show']);
    Route::resource('estadis', EstadiController::class)->only(['index', 'show']);

    // 2. ALTRES RECURSOS (Equips, Partits, Jugadores):
    //    - Totes les accions requereixen estar loguejat.
    //    - La restricció específica (qui pot editar què) la gestionen les Policies als Controladors.
    Route::resource('equips', EquipController::class);
    Route::resource('partits', PartitController::class);
    Route::resource('jugadores', JugadoraController::class)->parameter('jugadores', 'jugadora');
});

require __DIR__.'/auth.php';