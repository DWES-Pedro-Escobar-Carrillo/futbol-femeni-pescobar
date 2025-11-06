<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadiController;
use App\Http\Controllers\JugadoraController;
use App\Http\Controllers\PartitController;
use App\Http\Controllers\EquipController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome'); // <-- AFEGEIX AIXÒ

Route::controller(EstadiController::class)->group(function () {
    Route::get('/estadis', 'index')->name('estadis.index');
    Route::get('/estadis/crear', 'create')->name('estadis.create');
    Route::post('/estadis', 'store')->name('estadis.store');
});


Route::controller(JugadoraController::class)->group(function () {
    Route::get('/jugadores', 'index')->name('jugadores.index');
    Route::get('/jugadores/crear', 'create')->name('jugadores.create');
    Route::post('/jugadores', 'store')->name('jugadores.store');
});


Route::controller(PartitController::class)->group(function () {
    Route::get('/partits', 'index')->name('partits.index');
    Route::get('/partits/crear', 'create')->name('partits.create');
    Route::post('/partits', 'store')->name('partits.store');
});

Route::resource('equips', EquipController::class);